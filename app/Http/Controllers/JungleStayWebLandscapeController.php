<?php

namespace App\Http\Controllers;

use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class JungleStayWebLandscapeController extends Controller
{
    public function index()
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$landscapelist = \App\JungleStay\JungleStayLandscape::all()->toArray();

            // get number of stay in each landscape
            foreach($landscapelist as $index => $landscape){
                $getStayCount = \App\JungleStay\jungleStay::where('landscape_id', $landscape['id'])->get()->toArray();
                $landscapelist[$index]['stayCount'] = count($getStayCount);
            }

        	return view('junglestay/junglestaylandscapes', ['landscapeList'=> $landscapelist]);
        } catch (Exception $e) {
        	// Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            // Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('home');
        }
    }

    public function getJungleStays(Request $request,$landscapeId, $landscapeName)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $staylist = \App\JungleStay\jungleStay::where('landscape_id',$landscapeId)
                ->where('isActive', '1')
                ->get()
                ->toArray();

            return view('junglestay/junglestay', ['staylist'=> $staylist, 'landscapeName' => $landscapeName, 'landscapeId' => $landscapeId]);
        } catch (Exception $e) {
            return \Redirect::to(url('admin/jungleStayLandscapes'));
        }
    }

    public function getJungleStaysDetails(Request $request, $stayId, $stayName)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

            $stayDetail = \App\JungleStay\jungleStay::where('id',$stayId)
                ->get()
                ->toArray();

            $landscapeDetails = \App\JungleStay\JungleStayLandscape::where('id',$stayDetail[0]['landscape_id'])->get()->toArray();

            // get the images of the stay
            $stayImages = \App\JungleStay\jungleStayImages::where('jungleStay_id', $stayId)->get()->toArray();

            $stayDetail[0]['stayImages'] = $stayImages;

            $stayTypes = \App\JungleStay\jungleStayRooms::all()->toArray();

            return view('junglestay/junglestayDetail', ['stayDetail'=> $stayDetail[0],'stayTypes'=>$stayTypes,'landscapeDetails'=>$landscapeDetails[0], 'stayId' => $stayId, 'stayName' => $stayName]);
        } catch (Exception $e) {
            return \Redirect::to(url('admin/jungleStayLandscapes'));
        }
    }

    function junglestaycheckAvailability(Request $request, $stayId, $stayName)
    {
        // check user login
        if ($request->session()->get('userId')) {
            $request->session()->forget('bookingData');
            $request->session()->forget('bookingDatas');

            $data = $_POST;
            $getCheckDate = explode(" ", $data['start']);
            $checkDate = $getCheckDate[0];

            $stayType = \App\JungleStay\jungleStayRooms::where('id',$data['type'])->get()->toArray();
            $stayTypeImage = \App\JungleStay\jungleStay::select('logo')->where('id',$stayType[0]['jungleStay_id'])->get()->toArray();
            $stayTypeId = $stayType[0]['id'];
            $stayTypeName = $stayType[0]['type'];

            $sendData = [];
            $sendData['stayId'] = $stayId;
            $sendData['stayName'] = $stayName;
            $sendData['stayLogo'] = $stayTypeImage[0]['logo'];
            $sendData['travelDate'] = $data['start'];
            $sendData['stayTypeId'] = $stayTypeId;
            $sendData['stayTypeName'] = $stayTypeName;
            $sendData['no_of_stays'] = $data['no_of_stays'];

            session(['bookingData' => $sendData]);

            return redirect()->route("jungleStayVisitorDetails");
        }else{
            Session::flash('message', 'Please login to continue booking.');
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');

            return \Redirect::to($data['url']);
        }
    }

    public function jungleStayVisitorDetails(Request $request)
    {
        if ($request->session()->get('bookingData')) {
            $displayData = $request->session()->get('bookingData');

            session(['bookingData' => $displayData]);
            return view('junglestay/jungleStayVisitorDetails', ['displayData'=> $displayData]);
        }else{
            $data =  $request->session()->get('_previous');

            return \Redirect::to($data['url']);
        }
    }

    public function confirmjungleStayBooking(Request $request)
    {
        if ($request->session()->get('userId')) {
            try{
                $forestEntryFee = 0;
                $jungleStayTypeFee = 0;
                $sessionData = $request->session()->get('bookingData');

                foreach ($_POST['detail'] as $visitors){
                    $visitorType = 0;
                    if (isset($visitors['visitorType'])) {
                        // Foreigner passenger
                        $visitorType = 1;
                    }
                    $forestEntryFee = '250';
                    $jungleStayTypeFee += $this->stayTypeFee($sessionData['stayTypeId'],$visitorType);
                }

                // Cal to the grand total amount.
                $totalAmount = $forestEntryFee + $jungleStayTypeFee;

                // Internet handling charge
                $internetHandlingPercentage = \Config::get('common.internetHandlingCharge');
                $internetHandling = ($internetHandlingPercentage / 100) * $totalAmount;

                // Payment gateway
                $paymentGatewayPercentage = \Config::get('common.paymentGatewayCharge');
                $paymentGateway = ($paymentGatewayPercentage / 100) * $totalAmount;

                $displayData['jungleStayFee'] = $forestEntryFee;
                $displayData['stayTypeFee'] = $jungleStayTypeFee;
                $displayData['total'] = $totalAmount;
                $displayData['serviceCharges'] = $internetHandling + $paymentGateway;
                $displayData['totalPayable'] = $totalAmount + $internetHandling + $paymentGateway;

                return view('junglestay/confirmBooking', ['postData'=> $_POST,'displayData'=> $sessionData,'feeDetails' => $displayData]);

            }catch (Exception $e) {
                Session::flash('TranErrMessage', $e);
                Session::flash('alert-class', 'alert-danger');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }else{
            Session::flash('TranErrMessage', 'Please login to continue');
            Session::flash('alert-class', 'alert-danger');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }
    public function stayTypeFee($stayId,$nationality){
        $stayRoomFee = \App\JungleStay\jungleStayRoomsPrice::
                            where('jungleStayRooms_id',$stayId)
                            ->get()->toArray();
        switch ($nationality) {
            case 0 :
                return $stayRoomFee[0]['price_india'];
                break;
            case 1:
                return $stayRoomFee[0]['price_foreign'];
                break;
            default:
                return 0;
        }
    }

    public function initiateJungleStayBooking(Request $request)
    {
        $_POST['detail'] = json_decode($_POST['detail'], true);
        $_POST['feeDetails'] = json_decode($_POST['feeDetails'], true);
        $sessionData = $request->session()->get('bookingData');

        $availability = 1;

        if ($availability) {
            if ($request->session()->get('userId')) {
                if (count($sessionData) > 0) {
                    // Generate the display booking id.
                    $digits = 4;
                    $randNo = rand(pow(10, $digits-1), pow(10, $digits)-1);

                    $userId = $request->session()->get('userId');
                    $displayId = date('ymd').$userId. $randNo;
                    $visitorsDetails = array();

                    // visitorsData to insert into booking table

                    $totalseatscount = $sessionData['no_of_stays'];

                    $bookingInit = array();
                    $bookingInit['display_id'] = $displayId;
                    $bookingInit['junglestay_id'] = $sessionData['stayId'];
                    $bookingInit['user_id'] = $userId;
                    $bookingInit['stayType_id'] = $sessionData['stayTypeId'];
                    $bookingInit['date_of_booking'] = date("Y-m-d H:i:s");
                    $bookingInit['checkIn'] = $sessionData['travelDate'] ;
                    $bookingInit['no_of_stays'] = $totalseatscount;
                    $bookingInit['junglestayFee'] = $_POST['feeDetails']['jungleStayFee'] ;
                    $bookingInit['stayTypeFee'] = $_POST['feeDetails']['stayTypeFee'] ;
                    $bookingInit['amount_with_tax'] = $_POST['feeDetails']['totalPayable'];
                    $bookingInit['service_charge'] = $_POST['feeDetails']['serviceCharges'];
                    $bookingInit['booking_status'] = 'Waiting';
                    $bookingInit['visitors_details'] = json_encode($_POST['detail']);

                    $placeOrder = \App\JungleStay\jungleStayBookings::create($bookingInit);
                    $bookingId = $placeOrder->id;

                    // Payment data
                    $redirectUrl = url('/') . '/junglestays/responseReceiver';

                    $paymentData = [];
                    $paymentData['order_id'] = $bookingId;
                    $paymentData['userId'] = $userId;
                    $paymentData['amount'] = $_POST['feeDetails']['totalPayable'];
                    $paymentData['redirect_url'] = $redirectUrl;
                    $paymentData['cancel_url'] = $redirectUrl;
                    $paymentData['merchant_param1'] = $bookingId;

                    $data = $this->initPaymentTran($paymentData);

                    if ($data == 0) {
                        return \Redirect::to(url('/') . '/JungleStayLandscapes');
                    } else {
                        return view('payment/requestHandler', ['data' => $data]);
                    }
                }else{
                    return \Redirect::to(url('/').'/JungleStayLandscapes');
                }
            }else{
                return \Redirect::to(url('/').'/JungleStayLandscapes');
            }
        }else{
            Session::flash('TranErrMessage', 'Available seats are being booked!! Please checks seats available and book faster.');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('/').'/JungleStayLandscapes');
        }
    }

    public function responseReceiver(Request $request)
    {
        $workingKey = \Config::get('common.workingKey');
        $accessCode = \Config::get('common.accessCode');
        $merchantId = \Config::get('common.merchantId');

        $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server

        //$encResponse = 'd8037879f8195b6fb1c3de3d7707e1224b1d948c8f2c5a42be662fd44240fc0fa616540c1198adc5bfd0bab733250e5da52447549e84b8e4ab485c9900678e21cd075773dc331792b623c8af9ebfda6d71fdf6602c5ec1b40246dbfffceca0154e20d6c3e19749a795021a59cb9011e5297f50bf3aed8fee44fb988f2edc0a4e17428cb91be51301d7ae24ab9f4e6ce48bb4576de0ecd6a89eb9bdb6cdab0e452e0b773c0c5d4f4d254ec8c8f9ca27992caa5e6c6bd3b71c163fb5fd7ea8af8a2540f79c5fafeb76cb95139774dbd165b838840bccba29866040fb9a7e6e54264e8967dc30850a899268cf228d230fb0411110447090cc28e0e1818e0dbf5343ae9ea2e5ea187e8534b799ac4137053bc3fb799124f311a50ee687fe2acfeb73ec031606952ffd8042e837bedc9eb0398caf96821424f3375fafdac04a35cbbb43097d25d390a86b5324f7fe3141d460287a4c042a0185a70f237d0832e2ee49509c1021c8011c1c76f6eb0fc285c10bc47d8602c9efa2c3bd1603f6d5e4c3506d090891d6e94215ded09da5e8b9293e5cf37b9bef07043114fa6fe47832b18c171a613b76cf1559e2139e69af8c55802103c36e2d840155ddbecd427190412a29f64fbf6d33cd19e4d512ee5cff95525e2383991d148d7a614d4ae3ad46759d2e117bcfccdf88c40a737bb3ae5983fc417f4d1b4c1fe750420df9f0e566d4b0b39908dff3523cdd127b05cc1c2f925b7d185ce1d30ae383b5d4c2b426c9182f6a5ab8072b380dc33cc3dc1ea6440ad6ccfee0995fb98c80051072b2fe43c9c00085c5195f97b3ccd4f40bdef29cec9f45865e8fd2927ffb9a5ab254fb07189c5c347730aa7a4b13c0f994576da98b2588fb27b391b3c395aabb78815e137399e0021cf296e598cc33b0b45171fdcc52b385032b1d7d8da88cbf4f3bc6e39db1678928c7ab0836b3b73114cce5f8901b3a29336b5ccd0d9eb034d3999b66c45824f79a01fcc33db24c2624902a7895573806477722a252b8fb569493ccd3b34a203d04891b43fcee3bc322740ef2449d758b72a62f665d11c098357fea78ee5eabd9aeb8a6aa1262affdb22e2245e06b';

        $rcvdString = $this->decrypt($encResponse, $workingKey);

        $orderStatus = "";
        $userEmail = "";
        $orderAmount = "";

        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);

        $keysNeeded = ['tracking_id','order_status','failure_message','payment_mode','card_name','trans_date'];
        // response to array
        $responseArray = array();
        foreach ($decryptValues as $key => $value) {
            $slipt = explode('=', $value);

            if (in_array($slipt[0], $keysNeeded)) {
                $responseArray[$slipt[0]] = $slipt[1];
            }
        }

        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($information[0] == 'order_status')
                $orderStatus = $information[1];
            if ($information[0] == 'order_id')
                $orderId = $information[1];
            if ($information[0] == 'billing_email')
                $userEmail = $information[1];
            if ($information[0] == 'amount')
                $orderAmount = $information[1];
        }


        // update the row
        $updateContent = array();

        $updateContent['booking_status'] = $orderStatus;
        $updateContent['gateway_response'] = json_encode($responseArray);

        $updateRow = \App\JungleStay\jungleStayBookings::where('id',$orderId)->update($updateContent);

        if ($orderStatus == 'Success') {

            // Send a mail to user account
            if ($userEmail != '') {
                $bookingData = \App\JungleStay\jungleStayBookings::where('id',$orderId)->get()->toArray();

                $junglestayData = \App\JungleStay\jungleStay::where('id',$bookingData[0]['junglestay_id'])->get()->toArray();
                $jungleStayType = \App\JungleStay\jungleStayRooms::where('jungleStay_id',$junglestayData[0]['id'])->get()->toArray();

                // get the user details
                $userInfo = \App\User::where('id', $bookingData[0]['user_id'])->get()->toArray();

                // Send SMS
                $data['userInfo'] = $userInfo[0];
                $data['jungleStayData'] = $junglestayData[0];
                $data['bookingData'] = $bookingData[0];

                $this->bookingSMS($data, 1);

                $jungleStayDetail['type'] = $jungleStayType[0]['type'];
                $jungleStayDetail['visitors_details'] = json_decode($bookingData[0]['visitors_details'],true);

                return  \View::make('payment.jungleStayMailTemplate', ['bookingData' => $bookingData[0], 'jungleStayData' => $junglestayData[0],'jungleStayDetail'=>$jungleStayDetail]);

                $message = \View::make('payment.jungleStayMailTemplate', ['bookingData' => $bookingData[0], 'jungleStayData' => $junglestayData[0],'jungleStayDetail'=>$jungleStayDetail]);

                $subject = "Ecotrail booking";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "Bcc:myecotrip17@gmail.com" . "\r\n";

                // More headers
                $headers .= 'From: <support@myecotrip.com>' . "\r\n";

                mail($userEmail,$subject,$message,$headers);
                return view('payment/success', ['userEmail'=> $userEmail]);

            }
        }else{
            return view('payment/failure');
        }
    }
}
