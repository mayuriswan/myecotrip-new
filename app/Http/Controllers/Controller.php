<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use View;

use PHPMailer\PHPMailer\PHPMailer;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     public function __construct()
    {
        $this->middleware(function ($request, $next) {

            // Visitors count
            $getRow = \App\Visitor::increment('visits', 1);

            $getRow = \App\Visitor::find(1);

            // echo \Route::current()->getName();exit;

            //Get the header parts
            $landscapes = \App\Landscape::where('status', 1)->get();
            $trails = \App\Trail::where('status', 1)->get();
            $birdFest = \App\BirdsFest\birdsFestDetails::whereIn('isActive', [1,2])->orderBy('isActive')->get();

            View::share([
                'clients'    => $getRow->visits,
                'landscapes' => $landscapes,
                'trails' => $trails,
                'birdFest' => $birdFest
            ]);

            return $next($request);
        });



    }




    function isWeekend($date) {
        return (date('N', strtotime($date)) >= 6);
    }

    public function daysOfMonth($month, $year, $startDate = 1)
    {
        $monthsDays = [];
        for($d = $startDate; $d<= cal_days_in_month(CAL_GREGORIAN, $month, $year) ; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time)==$month)
                $monthsDays[]=date('Y-m-d', $time);
        }

        return $monthsDays;
    }

    public function firstDayOfNextMonth($inputDate)
    {
        $currentDate = new \DateTime(date($inputDate));

        //Add 1 month
        $currentDate->add(new \DateInterval('P1M'));

        //Get the first day of the next month as string
        $firstDayOfNextMonth = $currentDate->format('Y-m-01');

        return $firstDayOfNextMonth;
    }

    public function getLoggedInUserDetails($request, $key, $level = Null)
    {
        if ($level != Null && $level == 0) {
            return $request->session()->get($key)[$level];
        }
        return $request->session()->get($key);
    }

    public function downloadAsXlsx($fileName, $data )
    {
        return \Excel::create($fileName, function($excel) use ($data) {
            $excel->sheet('Items', function($sheet) use ($data)
            {
                $sheet->fromArray($data, null, 'A1', true);
            });
        })->store('xlsx')->download('xlsx');
    }

    public function S3upload($request, $fileName, $filePath )
    {
        try{
            $image = $request->file($fileName);

            if($image) {
                $s3 = \Storage::disk('s3');
                $s3->put($filePath, file_get_contents($image), 'public');
                return \Storage::disk('s3')->url($filePath);
            }else{
                return null;
            }
        }catch (Exception $e){
            return null;
        }
    }

    public function writeLogTest()
    {
        $content = "\n\n". date("Y-m-d H:i:s") .": Came";
        file_put_contents('../storage/myecotripLogs/SMSreports.log', $content, FILE_APPEND);
    }

    public function writeLog($fileName, $content)
    {
        $content = "\n\n". date("Y-m-d H:i:s") .": ". $content;
        file_put_contents('../storage/myecotripLogs/'.$fileName, $content, FILE_APPEND);
    }

    public function sendSMS($mobileno, $msg){

        $sender = 'ECOTRP';
        $apikey = '266el1c61qha1c1brl6670c088n5gs15o40';
        $otp = rand(100000, 999999); //store it in session for further use Ex. Verification
        $textmessage = urlencode($msg);
        $apiurl = 'http://instantalerts.co/api/web/send';
        $smsgatewaydata = $apiurl.'?apikey='.$apikey.'&sender='.$sender.'&to='.$mobileno.'&message='.$textmessage;
        file_get_contents($smsgatewaydata);

        // $this->writeLog('SMSreports.log', $mobileno . " : " . $msg );

    }

    public function bookingSMS($data, $type)
    {
        try{
            if ($type == 1) {
                // Trail booking
                $mobileNo = $data['userInfo']['contact_no'];
                $firstName = $data['userInfo']['first_name'];
                $trailName = $data['trailData']['name'];
                $checkIn = $data['bookingData']['checkIn'];
                $displayId = $data['bookingData']['display_id'];

                $msg = \Config::get('SMSmessages.trailBookingSms');
                $msg = str_replace("#firstName",$firstName,$msg);
                $msg = str_replace("#trekName",$trailName,$msg);
                $msg = str_replace("#date",substr($checkIn,0,10),$msg);
                $msg = str_replace("#bookingId",$displayId,$msg);
            }

            if ($type == 2) {
                // Safari booking
                $mobileNo = $data['userInfo']['contact_no'];
                $firstName = $data['userInfo']['first_name'];
                $safariName = $data['safariData']['name'];
                $checkIn = $data['bookingData']['checkIn'];
                $displayId = $data['bookingData']['display_id'];
                $timeSlot = $data['safariDetail']['timeSlotName'];

                $msg = \Config::get('SMSmessages.safariBookingSMS');
                $msg = str_replace("#firstName",$firstName,$msg);
                $msg = str_replace("#safariName",$safariName,$msg);
                $msg = str_replace("#checkIn",substr($checkIn,0,10),$msg);
                $msg = str_replace("#bookingId",$displayId,$msg);
                $msg = str_replace("#timeSlot",$timeSlot,$msg);
            }

            if ($type == 3) {
                //Event booking
                $mobileNo = $data['userInfo']['contact_no'];
                $msg = \Config::get('SMSmessages.eventBookingSms');
                $msg = str_replace("#firstName",$data['userInfo']['first_name'],$msg);
                $msg = str_replace("#eventName",$data['bookingData']['event_name'],$msg);
                $msg = str_replace("#bookingId",$data['bookingData']['display_id'],$msg);

            }

            if ($type == 4) {
                //Jungle Stay booking
                $mobileNo = $data['userInfo']['contact_no'];
                $msg = \Config::get('SMSmessages.jsBookingSms');

                $msg = str_replace("#firstName",ucwords($data['userInfo']['first_name']),$msg);
                $msg = str_replace("#js",ucwords($data['stayData']['name']),$msg);
                $msg = str_replace("#bookingId",$data['bookingData']['display_id'],$msg);
                $msg = str_replace("#checkIn",date("d-m-Y", strtotime($data['bookingData']['check_in'])),$msg);
                $msg = str_replace("#checkOut",date("d-m-Y", strtotime($data['bookingData']['check_out'])),$msg);
                $msg = str_replace("#guests",$data['bookingData']['total_guests'],$msg);
                $msg = str_replace("#rooms",$data['bookingData']['noOfRooms'],$msg);
                $msg = str_replace("#amount",$data['bookingData']['total_amount'],$msg);

            }

            // $mobileNo = 8861422700;
            // echo "<pre>"; print_r($msg);exit();

            $sender = 'ECOTRP';
            $apikey = '266el1c61qha1c1brl6670c088n5gs15o40';
            $otp = rand(100000, 999999); //store it in session for further use Ex. Verification
            $textmessage = urlencode($msg);
            $apiurl = 'http://instantalerts.co/api/web/send';
            $smsgatewaydata = $apiurl.'?apikey='.$apikey.'&sender='.$sender.'&to='.$mobileNo.'&message='.$textmessage;
            file_get_contents($smsgatewaydata);

            return true;

        }catch(\Exception $e ){
            return false;
        }
    }

    public function initAdminPaymentTran($data)
    {
        // echo "<pre>"; print_r($data);exit;

        // Get the user info
        $workingKey = \Config::get('common.workingKey');
        $accessCode = \Config::get('common.accessCode');
        $merchantId = \Config::get('common.merchantId');

        $transaction_no = rand();
        $paying_amount  = $data['amount'];
        $order_id       = $data['order_id'];
        $redirect       = $data['redirect_url'];

        $merchantData = '';

        $merchantData.='language=EN&';
        $merchantData.='currency=INR&';
        $merchantData.='merchant_id='.$merchantId.'&';
        $merchantData.='amount=' . $paying_amount . '&';
        $merchantData.='tid=' . $transaction_no . '&';
        $merchantData.='order_id=' . $order_id . '&';
        $merchantData.='redirect_url=' . $redirect . '&';
        $merchantData.='cancel_url=' . $redirect . '&';
        $merchantData.='billing_email=' . $data["email"] . '&';
        $merchantData.='billing_tel=' . $data["contat_no"] . '&';


        if (isset($data['merchant_param1'])){
            $merchantData.='merchant_param1=' . $data['merchant_param1'] . '&';
        }

        if (isset($data['merchant_param2'])){
            $merchantData.='merchant_param2=' . $data['merchant_param2'] . '&';
        }

        if (isset($data['merchant_param3'])){
            $merchantData.='merchant_param3=' . $data['merchant_param3'] . '&';
        }

        // Method for encrypting the data.
        $encrypted_data = $this->encrypt($merchantData, $workingKey);
        // print_r($encrypted_data);exit();
        $data["encrypted_data"] = $encrypted_data;
        $data["access_code"] = $accessCode;

        return $data;

    }

    public function initPaymentTran($data)
    {
        // Get the user info
        $userInfo = \App\User::where('id',$data['userId'])->get()->toArray();

        if (count($userInfo) > 0) {

            $user = $userInfo[0];

            $workingKey = \Config::get('common.workingKey');
            $accessCode = \Config::get('common.accessCode');
            $merchantId = \Config::get('common.merchantId');

            $transaction_no = rand();
            $paying_amount  = $data['amount'];
            $order_id       = $data['order_id'];
            $redirect       = $data['redirect_url'];

            $merchantData = '';

            $merchantData.='language=EN&';
            $merchantData.='currency=INR&';
            $merchantData.='merchant_id='.$merchantId.'&';
            $merchantData.='amount=' . $paying_amount . '&';
            $merchantData.='tid=' . $transaction_no . '&';
            $merchantData.='order_id=' . $order_id . '&';
            $merchantData.='redirect_url=' . $redirect . '&';
            $merchantData.='cancel_url=' . $redirect . '&';

            $merchantData.='billing_name=' . $user["first_name"] . ' ' . $user["last_name"] . '&';
            $merchantData.='billing_address=' . $user["address"] . '&';
            $merchantData.='billing_city=' . $user["city"] . '&';
            $merchantData.='billing_state=' . $user["state"] . '&';
            $merchantData.='billing_country=' . $user["country"] . '&';
            // $merchantData.='billing_zip=' . $user["pincode"] . '&';
            $merchantData.='billing_tel=' . $user["contact_no"] . '&';
            $merchantData.='billing_email=' . $user["email"] . '&';

            if (isset($data['merchant_param1'])){
                $merchantData.='merchant_param1=' . $data['merchant_param1'] . '&';
            }

            if (isset($data['merchant_param2'])){
                $merchantData.='merchant_param2=' . $data['merchant_param2'] . '&';
            }

            if (isset($data['merchant_param3'])){
                $merchantData.='merchant_param3=' . $data['merchant_param3'] . '&';
            }

            // Method for encrypting the data.
            $encrypted_data = $this->encrypt($merchantData, $workingKey);
            // print_r($encrypted_data);exit();
            $data["encrypted_data"] = $encrypted_data;
            $data["access_code"] = $accessCode;

            return $data;
        }else{
            return 0;
        }

    }

   //  public function encrypt($plainText, $key){
   //      $key = $this->hextobin(md5($key));
   //      $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
   //      $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
   //      $encryptedText = bin2hex($openMode);
   //      return $encryptedText;
   // }

    /**
     * Function to decrypt
     * @param $encryptedText string
     * @param $key
     * @return string
     */
    // public function decrypt($encryptedText, $key){
    //     $key = $this->hextobin(md5($key));
    //     $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    //     $encryptedText = $this->hextobin($encryptedText);
    //     $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    //     return $decryptedText;
    // }

    // function encrypt($plainText,$key)
    // {
    //     $secretKey = $this->hextobin(md5($key));
    //     $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    //     $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
    //     $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
    //     $plainPad = $this->pkcs5_pad($plainText, $blockSize);
    //     if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1)
    //     {
    //           $encryptedText = mcrypt_generic($openMode, $plainPad);
    //               mcrypt_generic_deinit($openMode);
    //
    //     }
    //     return bin2hex($encryptedText);
    // }
    //
    // function decrypt($encryptedText,$key)
    // {
    //     $secretKey = $this->hextobin(md5($key));
    //     $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    //     $encryptedText=$this->hextobin($encryptedText);
    //     $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
    //     mcrypt_generic_init($openMode, $secretKey, $initVector);
    //     $decryptedText = mdecrypt_generic($openMode, $encryptedText);
    //     $decryptedText = rtrim($decryptedText, "\0");
    //     mcrypt_generic_deinit($openMode);
    //     return $decryptedText;
    //
    // }
    //*********** Padding Function *********************

    //  function pkcs5_pad ($plainText, $blockSize)
    // {
    //     $pad = $blockSize - (strlen($plainText) % $blockSize);
    //     return $plainText . str_repeat(chr($pad), $pad);
    // }
    //
    // //********** Hexadecimal to Binary function for php 4.0 version ********
    //
    // function hextobin($hexString)
    //  {
    //     $length = strlen($hexString);
    //     $binString="";
    //     $count=0;
    //     while($count<$length)
    //     {
    //         $subString =substr($hexString,$count,2);
    //         $packedString = pack("H*",$subString);
    //         if ($count==0)
    //     {
    //         $binString=$packedString;
    //     }
    //
    //     else
    //     {
    //         $binString.=$packedString;
    //     }
    //
    //     $count+=2;
    //     }
    //         return $binString;
    //   }

    /*
* @param1 : Plain String
* @param2 : Working key provided by CCAvenue
* @return : Decrypted String
*/
public function encrypt($plainText,$key)
{
    $encryptionMethod = "AES-128-CBC";
    $secretKey        = $this->hextobin(md5($key));
    $initVector       = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText    = openssl_encrypt($plainText, $encryptionMethod, $secretKey, OPENSSL_RAW_DATA, $initVector);
    return bin2hex($encryptedText);

}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
public function decrypt($encryptedText,$key)
{
    $encryptionMethod     = "AES-128-CBC";
    $secretKey         =  $this->hextobin(md5($key));
    $initVector         =  pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText      =  $this->hextobin($encryptedText);
    $decryptedText         =  openssl_decrypt($encryptedText, $encryptionMethod, $secretKey, OPENSSL_RAW_DATA, $initVector);
    return $decryptedText;
}

public function hextobin($hexString)
{
    $length = strlen($hexString);
    $binString="";
    $count=0;
    while($count<$length)
    {
        $subString =substr($hexString,$count,2);
        $packedString = pack("H*",$subString);
        if ($count==0)
        {
            $binString=$packedString;
        }
        else
        {
            $binString.=$packedString;
        }
        $count+=2;
    }
    return $binString;
}

    public function sendTestEmail()
    {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIAIXQGUWBNKJDHVQXA';
        $mail->Password = 'Atnub9685n4VBFw/KpUE/l9MemvPaJEHMpQLzPFthFpF';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 25;

        //Recipients
        $mail->setFrom('support@myecotrip.com', 'Myecotrip');
        $mail->addAddress('vinayan17@gmail.com', 'Vinay');


        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Ecotrail booking';
        $mail->Body    = '$body';

        echo  $mail->send();
    }

    public function sendEmail($email, $toName, $ccTo, $subject, $body, $attachements, $bccTo = [])
    {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'AKIAIXQGUWBNKJDHVQXA';                 // SMTP username
        $mail->Password = 'Atnub9685n4VBFw/KpUE/l9MemvPaJEHMpQLzPFthFpF';  // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('support@myecotrip.com', 'Myecotrip');
        $mail->addAddress($email, $toName);

        // $mail->addCC('myecotrip17@gmail.com');
        if (count($ccTo) > 0) {

            foreach ($ccTo as $cc) {
                $mail->addCC($cc);
            }
        }

        if (count($bccTo) > 0) {

            foreach ($bccTo as $bcc) {
                $mail->addBCC($bcc);
            }
        }

        if (count($attachements) > 0) {
            foreach ($attachements as $attachement) {
                $mail->addAttachment($attachement['path'],$attachement['name']);
            }
        }

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        return $mail->send();
    }

    public function getSafariTransportation($safari_id){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        try {
            $safarilist = \App\Safari\Safari::select('transportation_id')->where('id',$safari_id)->get()->toArray();
            $safarilistId =explode(',',$safarilist[0]['transportation_id']);
            $transporttypes = \App\Transportation\TransportationTypes::whereIn('id',$safarilistId)->get()->toArray();

            return view('Admin/safari/safarivehicles/dynamicdiv',['transportList'=>$transporttypes]);

        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariVehicles'));
        }
    }

    public function birdSancturyFunctionVersion($birdSancturyId, $requiredVersion)
    {
        try {
            $getRow = \App\BirdSanctuary\birdSanctuary::where('id', $birdSancturyId)->get()->toArray();

            if (count($getRow)) {
                return $getRow[0][$requiredVersion];
            }else{
                return 0;
            }

        } catch (Exception $e) {
            return 0;
        }
    }

    public function idNameFormat($inputArray, $columName)
    {
        $returnArray = [];

        foreach ($inputArray as $key => $value) {
            $returnArray[$value['id']] = $value[$columName];
        }

        return $returnArray;
    }

    public function idArrayFormat($inputArray, $columName)
    {
        $returnArray = [];

        foreach ($inputArray as $key => $value) {
            $returnArray[$value[$columName]] = $value;
        }

        return $returnArray;
    }

    function dateDiffInDays($date1, $date2)
    {
        // Calulating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);

        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }


    public function checkAccountVerification($userId)
    {
        try {
            $checkUser = \App\User::where('id', $userId)
                            ->where(function ($query) {
                                $query->where('email_verified',1)
                                      ->orWhere('phone_verified', 1);
                            })
                            ->get()
                            ->toArray();

            if (count($checkUser) > 0) {
                return 1;
            }else{
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getOutputArray($content, $traillist, $all)
    {
        // echo "<pr/e>"; print_r($content);exit();
        $outputArray = [];
        $Items = [];
        $startDate = $content['selectMonth'].'-01';
        $endDate = $content['selectMonth'].'-31';

        if ($content['type'] == 'Online') {

            if ($all) {
                $getBooking = \App\TrailBooking::whereIn('trail_id',$traillist)
                            ->whereDate($content['report_for'],'>=',$startDate)
                            ->whereDate($content['report_for'],'<=',$endDate)
                            ->where('booking_status', 'Success')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->toArray();
            }else{
                $getBooking = \App\TrailBooking::where('trail_id',$traillist)
                            ->whereDate($content['report_for'],'>=',$startDate)
                            ->whereDate($content['report_for'],'<=',$endDate)
                            ->where('booking_status', 'Success')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->toArray();
            }

            foreach ($getBooking as $index => $bookings) {
                // get the trail name
                $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                // Trail Details
                $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();

                $getBooking[$index]['user'] = $getName[0]['first_name'];
                $getBooking[$index]['phone_no'] = $getName[0]['contact_no'];
                $getBooking[$index]['email'] = $getName[0]['email'];
                $getBooking[$index]['trailName'] = $trailData[0]['name'];

                $unsetItems = ['user_id','trail_id','booking_status','created_at','updated_at','trekkers_details'];

                foreach ($unsetItems as $unsetKeys) {
                    unset($getBooking[$index][$unsetKeys]);
                }
                $Items[] = $getBooking[$index];

            }

            $downloadKeys = ['SlNo'=>'id','bookingId'=>'display_id','user'=>'user','Trail'=>'trailName','phone_no'=>'phone_no','email'=>'email','Date of booking'=>'date_of_booking','checkIn'=>'checkIn','Adults'=>'number_of_trekkers','Children' => 'number_of_children','Student' => 'number_of_students','amount'=>'amount', 'GST Amount' => 'gst_amount', 'Total amount' => 'amountWithTax', 'Bank referance no.' => 'gatewayResponse'];

            // echo "<pre>"; print_r($Items);exit();
            $outputArray = [];
            foreach ($Items as  $index => $value) {
                foreach ($downloadKeys as $displayKey => $dbKey) {
                    if ($dbKey == 'gatewayResponse') {
                        $getTrackingId = json_decode($value[$dbKey], true);
                        $outputArray[$index][$displayKey] = $getTrackingId['tracking_id'];

                    }else{
                        $outputArray[$index][$displayKey] = $value[$dbKey];
                    }
                }
            }

            // echo "<pre>"; print_r($outputArray);exit();
        }else{
            if ($all) {
                 $getBooking = \App\TrailOflineBOokings::whereIn('trail_id',$traillist)
                            ->whereDate('checkIn','>=',$startDate)
                            ->whereDate('checkIn','<=',$endDate)
                            ->where('booking_status', 'Success')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->toArray();
            }else{
                $getBooking = \App\TrailOflineBOokings::where('trail_id',$traillist)
                            ->whereDate('checkIn','>=',$startDate)
                            ->whereDate('checkIn','<=',$endDate)
                            ->where('booking_status', 'Success')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->toArray();
            }

            foreach ($getBooking as $index => $bookings) {
               // Trail Details
                $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();

                $getBooking[$index]['user'] = $bookings['name'];
                $getBooking[$index]['phone_no'] = $bookings['contat_no'];
                $getBooking[$index]['email'] = $bookings['email'];
                $getBooking[$index]['trailName'] = $trailData[0]['name'];
                $trailName = $trailData[0]['name'];

                $unsetItems = ['user_id','trail_id','amountWithTax','booking_status', 'gatewayResponse','gatewayResponse','created_at','updated_at','trekkers_details'];

                foreach ($unsetItems as $unsetKeys) {
                    unset($getBooking[$index][$unsetKeys]);
                }
                $Items[] = $getBooking[$index];
            }

            $downloadKeys = ['SlNo'=>'id','bookingId'=>'display_id','user'=>'user','Trail'=>'trailName','phone_no'=>'phone_no','email'=>'email','checkIn'=>'checkIn','Trekkers'=>'number_of_trekkers','amount'=>'amount','receipt' => 'receipt'];


            foreach ($Items as  $index => $value) {
                foreach ($downloadKeys as $displayKey => $dbKey) {
                    $outputArray[$index][$displayKey] = $value[$dbKey];
                }
            }
        }

        return $outputArray;
    }


    // SBI payment gateway
    function _encrypt($data,  $key){
        try{
            $algo='aes-128-cbc';

            $iv=substr($key, 0, 16);
            //echo $iv;
            $cipherText = openssl_encrypt(
                $data,
                $algo,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );
            $cipherText = base64_encode($cipherText);

            return $cipherText;

        } catch (Exception $e) {
            return 0;
        }
    }

    function _decrypt($cipherText,  $key){

        $algo='aes-128-cbc';

        $iv=substr($key, 0, 16);
        $cipherText = base64_decode($cipherText);

            $plaintext = openssl_decrypt(
            $cipherText,
            $algo,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        return $plaintext;
    }

}
