<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

class EventsController extends Controller
{
    public function eventsList(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $eventList = \App\BirdsFest\birdsFestDetails::where('isActive', 1)->orderBy('id', 'desc')->get()->toArray();

            $previousList = \App\BirdsFest\birdsFestDetails::where('isActive', 2)->orderBy('id', 'desc')->get()->toArray();

            // redirecting to safarilist front end view page
            return view('events/eventList',['eventList'=>$eventList, 'previousList' => $previousList]);
        } catch (Exception $e) {
            return redirect()->route('eventsList');
        }
    }

    public function getEventDetails(Request $request, $eventId,  $eventTypeId, $eventName)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        //Remove old booking data session
        $request->session()->forget('bookingData');
        $request->session()->forget('bookingDatas');


        try {
            //Get the event details
            $getEvents = \App\BirdsFest\birdsFestDetails::where('id',$eventId)->where('isActive' ,'!=', 0)->get()->toArray();

            if (count($getEvents) > 0){
                // get the images of the safari
                $eventImages = \App\BirdsFest\birdsFestImages::where('birdsFest_id', $eventId)->get()->toArray();

                //buyfercate the speakers images
                $arr = array();
                foreach ($eventImages as $key => $item) {
                    if ($item['image_type'] == 0) {
                        $arr['eventImage'][] = $item;
                    }else{
                        $arr['speakerImage'][] = $item;
                    }
                }

                $getEvents[0]['images'] = $arr;

                //Get the pricing for all booking types
                // $bookingTypes = \App\BirdsFest\birdFestPricings::join('eventsBooking','eventsBooking.booking_type_id','=','birdsFestPricing.id')->where('event_id', $eventId)
                //             ->where('remaining_slots','>',0)
                //             ->where()
                //             ->get()
                //             ->toArray();

                $bookingTypes = \DB::select(\DB::raw("SELECT bsf.*,(SELECT SUM(number_of_tickets) FROM eventsBooking evBook WHERE evBook.booking_type_id = bsf.id AND evBook.booking_status= 'Waiting') AS 'waitingTicket' FROM birdsFestPricing bsf WHERE bsf.event_id = $eventId AND bsf.status = 1" ));

               $formated = json_decode(json_encode($bookingTypes),true);

                //Add data to session
                $bookingData['eventLogo']  = $getEvents[0]['logo'];
                $bookingData['eventName']  = $getEvents[0]['name'];
                $bookingData['eventId']    = $getEvents[0]['id'];

                session(['bookingData'=> $bookingData]);

                // echo "<pre>"; print_r($getEvents);exit();
                return view('events/eventDetail', ['eventDetail'=> $getEvents[0], 'bookingTypes' => $formated, 'eventName' => $eventName]);
            }else{
                return redirect()->route('eventsList');
            }

        } catch (Exception $e) {
            return redirect()->route('eventsList');
        }
    }

    public function getRemaningSlotDropdown(Request $request, $noOfSlots)
    {

        $explodeSlot = explode("_",$noOfSlots);

        // echo "<pre>"; print_r($explodeSlot);exit();
        //Save session data and price per head
        $data =  session()->get('_previous');
        session(['eventDetailURL'=> $data['url']]);

        //Add data to session
        session(['bookingData.selectedBookingPrice'=> $explodeSlot['2']]);
        session(['bookingData.eventType'=> $explodeSlot['0']]);

        return view('events/remaningSlots', ['noOfSlots'=> $explodeSlot[1]]);
    }

    public function isAvaiable($eventType, $numberOfTicket)
    {
        $validation = 'False';

        //Get the pricing for all booking types
        $bookingTypes = \App\BirdsFest\birdFestPricings::where('id', $eventType)->where('status',1)
            ->get()->toArray();

        if ($bookingTypes[0]['remaining_slots'] >= $numberOfTicket){
            $validation =  'True';
        }

        return $validation;

    }

    public function eventCheckAvailability(Request $request, $eventName)
    {

        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $sessionData = session()->all();

//        print_r($sessionData);exit();
        try {
            $getEvents = \App\BirdsFest\birdsFestDetails::where('id',$_POST['event_id'])->where('isActive' ,'!=', 0)->first();

            if ($request->session()->get('userId') || $getEvents->event_id == 3) {

                //without login booking

                $sessionBookingData = $sessionData['bookingData'];
                $pricePerHead = $sessionBookingData['selectedBookingPrice'];
                // dd($sessionBookingData, $_POST);

                if ($pricePerHead){
                    $formData = $_POST;


                    // Call to the grand total amount.
                    $totalAmount = $formData['tickets'] * floatval($pricePerHead);
                    $displayData = $sessionData['bookingData'];

                    if ($getEvents->event_id == 3) {
                        // For book
                        $kedbCommission = 50 * $formData['tickets'];
                        //Shipping charges
                        $shippingCharge = 285 * $formData['tickets'];

                        //GST charges
                        $gstPercentage = \Config::get('common.gstForBook');
                        $gstAmount = ($gstPercentage / 100) * ($totalAmount + $kedbCommission + $shippingCharge);


                        $totalPayable = round($totalAmount + $shippingCharge + $gstAmount + $kedbCommission, 2);

                        $displayData['total'] = $totalAmount;
                        $displayData['gstCharges'] = $gstAmount;
                        $displayData['serviceCharges'] = $shippingCharge;
                        $displayData['totalPayable'] = $totalPayable;
                        $displayData['kedb_amount'] = $kedbCommission;

                    }else {

                        $internetHandlingPercentage = \Config::get('common.internetHandlingCharge');
                        $internetHandling = ($internetHandlingPercentage / 100) * $totalAmount;

                        //GST charges
                        $gstPercentage = \Config::get('common.gstCharge');
                        $gstAmount = ($gstPercentage / 100) * $internetHandling;

                        $totalAmount = $totalAmount - $internetHandling;
                        $internetHandling -= $gstAmount;

                        // Payment gateway
                        $paymentGateway = 0;
                        // $paymentGatewayPercentage = \Config::get('common.paymentGatewayCharge');
                        // $paymentGateway = ($paymentGatewayPercentage / 100) * ($totalAmount + $internetHandling + $gstAmount);

                        //KEDB commission
                        $totalPayable = $totalAmount + $internetHandling + $gstAmount;

                        $kedbCommission = ( 3 / 100 ) * $totalPayable;

                        $totalPayable += round($kedbCommissionc, 2);

                        $displayData['total'] = $totalAmount;
                        $displayData['gstCharges'] = $gstAmount;
                        $displayData['serviceCharges'] = $internetHandling + $paymentGateway + $kedbCommission;
                        $displayData['totalPayable'] = $totalPayable;
                        $displayData['kedb_amount'] = $kedbCommission;

                    }


                    $displayData['tickets'] = $formData['tickets'];

                    session(['bookingData' => $displayData]);
                    // dd($displayData, $_POST);exit();

                    return view('events/bookingDetails', ['displayData'=> $displayData, 'event' => $getEvents]);

                }else{
                    return \Redirect::to($sessionData['eventDetailURL']);
                }


            }else{
                Session::flash('message', 'Please login to continue booking.');
                Session::flash('alert-class', 'alert-danger');
                if(isset($sessionData['eventDetailURL'])){
                    return \Redirect::to($sessionData['eventDetailURL']);
                }
                return redirect()->route('eventsList');
            }
        } catch (Exception $e) {
            return redirect()->route('eventsList');
        }
    }


    public function initiateEventBooking(Request $request)
    {
        try{
            // dd($_POST);
            $sessionData = session()->all();
            $sessionBookingData = $sessionData['bookingData'];
            $getEvents = \App\BirdsFest\birdsFestDetails::where('id',$sessionBookingData['eventId'])->where('isActive' ,'!=', 0)->first();

            $validation = $this->isAvaiable($sessionBookingData['eventType'],$sessionBookingData['tickets']);

            if ($validation == 'True'){
                if ($request->session()->get('userId') || $getEvents->event_id == 3) {
                    // Generate the display booking id.
                    $digits = 4;
                    $randNo = rand(pow(10, $digits-1), pow(10, $digits)-1);

                    if (!$request->session()->get('userId') && $getEvents->event_id == 3) {

                        $details = $_POST['detail'][0];
                        $checkUser = \App\User::where('email', $details['email'])->first();

                        if($checkUser){
                            session(['userId' => $checkUser->id]);
                            session(['userName' => $details['first_name']]);
                        }else{
                            $createUser['first_name'] = $details['first_name'];
                            $createUser['last_name'] = $details['last_name'];
                            $createUser['contact_no'] = $details['contact_no'];
                            $createUser['email'] = $details['email'];
                            $createUser['sign_in_with'] = "myecotrip";

                            $createUs = \App\User::create($createUser);

                            session(['userId' => $createUs->id]);
                            session(['userName' => $details['first_name']]);
                        }

                    }
                    $userId = $request->session()->get('userId');
                    $displayId = date('ymd').$userId. $randNo;

                    // dd($userId);
                    // get the trekkers details
                    $trekkerDetails = [];
                    foreach ($_POST['detail'] as $key => $value) {
                        $trekkerDetails[] = $value;
                    }

                    $bookingInit = array();
                    $bookingInit['display_id'] = $displayId;
                    $bookingInit['user_id'] = $userId;
                    $bookingInit['event_id'] = $sessionBookingData['eventId'];
                    $bookingInit['booking_type_id'] = $sessionBookingData['eventType'] ;
                    $bookingInit['date_of_booking'] = date("Y-m-d H:i:s");
                    $bookingInit['number_of_tickets'] = $sessionBookingData['tickets'] ;
                    $bookingInit['amount'] = $sessionBookingData['total'] ;
                    $bookingInit['amountWithTax'] = $sessionBookingData['totalPayable'];
                    $bookingInit['kedb_amount'] = $sessionBookingData['kedb_amount'];
                    $bookingInit['gst_amount'] = $sessionBookingData['gstCharges'];
                    $bookingInit['booking_status'] = 'Waiting';
                    $bookingInit['users_details'] = json_encode($trekkerDetails);

                    $placeOrder = \App\Events\EventsBooking::create($bookingInit);

                    $bookingId = $placeOrder->id;

                        // Payment data
                    $redirectUrl = url('/').'/eventDetails/responseReceiver';

                    // For CCAvenue
                    // $paymentData = [];
                    // $paymentData['order_id']        = $bookingId;
                    // $paymentData['userId']          = $userId;
                    // $paymentData['amount']          = $sessionBookingData['totalPayable'];
                    // $paymentData['redirect_url']    = $redirectUrl;
                    // $paymentData['cancel_url']      = $redirectUrl;
                    // $paymentData['merchant_param1'] = $sessionBookingData['tickets'];
                    // $paymentData['merchant_param2'] = $sessionBookingData['eventType'];
                    // $paymentData['merchant_param3'] = $sessionBookingData['eventName'];

                    // $data = $this->initPaymentTran($paymentData);

                    $merchantId = \Config::get('payment.sbiMerchantId');
                    $sbiKey = \Config::get('payment.sbiKey');

                    $requestParameter  = $merchantId."|DOM|IN|INR|".$sessionBookingData['totalPayable']."|".$userId."|".$redirectUrl."|".$redirectUrl."|SBIEPAY|".$bookingId."|".$userId."|NB|ONLINE|ONLINE|";

                    $data = $this->_encrypt($requestParameter,$sbiKey);

                    return view('payment/sbiGateway', ['data'=> $data]);
                    // if ($data == 0) {
                    //     if(isset($sessionData['eventDetailURL'])){
                    //         return \Redirect::to($sessionData['eventDetailURL']);
                    //     }
                    //     return redirect()->route('eventsList');
                    // }else{
                    //     // return view('payment/requestHandler', ['data'=> $data]);
                    //     return view('payment/sbiGateway', ['data'=> $data]);
                    //
                    // }
                }else{
                    Session::flash('valMessage', 'User Id not found');
                    Session::flash('alert-class', 'alert-danger');
                    if(isset($sessionData['eventDetailURL'])){
                        return \Redirect::to($sessionData['eventDetailURL']);
                    }
                    return redirect()->route('eventsList');
                }
            }else{
                Session::flash('valMessage', 'Requested seat not found');
                Session::flash('alert-class', 'alert-danger');
                if(isset($sessionData['eventDetailURL'])){
                    return \Redirect::to($sessionData['eventDetailURL']);
                }
                return redirect()->route('eventsList');
            }

        } catch (Exception $e) {
            return redirect()->route('eventsList');
        }
    }

    public function sbiResponseReceiver(Request $request)
    {
        $sbiKey = \Config::get('payment.sbiKey');

        $encResponse = $_POST["encData"];   //This is the response sent by the SBI Server
        $rcvdString = $this->_decrypt($encResponse, $sbiKey);
        $decryptValues = explode('|', $rcvdString);

        $orderStatus = $decryptValues[2];
        $userId = $decryptValues[6];
        $orderId = $decryptValues[0];

        $sessionData = session()->all();
        $sessionBookingData = $sessionData['bookingData'];

        $validation = $this->isAvaiable($sessionBookingData['eventType'],$sessionBookingData['tickets']);

        // update the row
        $updateContent = array();

        if ($validation != 'True'){
            // If seats are booked by others
            $orderStatus = 'Conflit-Booking';
        }

        $updateContent['booking_status'] = ucwords(strtolower($orderStatus));
        $updateContent['gatewayResponse'] = $encResponse;
        $updateContent['transaction_id'] = $decryptValues[1];

        $updateRow = \App\Events\EventsBooking::where('id',$orderId)->update($updateContent);

        // Data to send mail
        $bookingData = \App\Events\EventsBooking::join('birdsFestDetails', 'birdsFestDetails.id', '=', 'eventsBooking.event_id')->where('eventsBooking.id',$orderId)
            ->select('eventsBooking.*', 'birdsFestDetails.name as event_name')
            ->get()
            ->toArray();

        $bookingTypeInfo = \App\BirdsFest\birdFestPricings::where('id',$bookingData[0]['booking_type_id'])->get()->toArray();

        // get the user details
        $userInfo = \App\User::where('id', $bookingData[0]['user_id'])->get()->toArray();

        if ($orderStatus == 'SUCCESS') {

            //Decrement remaning slots
            $decrementSlots = \App\BirdsFest\birdFestPricings::where('id',$bookingData[0]['booking_type_id'])->decrement('remaining_slots',$bookingData[0]['number_of_tickets']);

            // Send a mail to user account
            if ($userId) {

                // Send SMS
                $data['userInfo'] = $userInfo[0];
                $data['bookingData'] = $bookingData[0];

                $this->bookingSMS($data, 3);

                $subject = "Myecotrip Booking Confirmation";

                // return view('payment.eventMailTemplate', ['bookingData' => $bookingData[0]]);

                $order = \App\Events\EventsBooking::find($orderId);

                $event = \App\BirdsFest\birdsFestDetails::find($order->event_id);

                if($event->event_id == 3){
                    $message = \View::make('payment.bookMailTemplate', ['bookingData' => $bookingData[0]]);
                }else{
                    $message = \View::make('payment.eventMailTemplate', ['bookingData' => $bookingData[0]]);
                }

                $sendMail = $this->sendEmail($userInfo[0]['email'], $userInfo[0]['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

                return view('payment/success', ['userEmail'=> $userInfo[0]['email']]);

            }
        }else if($orderStatus == 'Conflit-Booking'){
            //Send user a mail with booking Id for failure reference
            $message = 'Dear '.$userInfo[0]['first_name'] . ' <br />Your booking reference Id : '. $bookingData[0]['display_id'] . ' <br /> There was a delay in ur payment process. So please contact our customer support for further details.';

            $subject = "Myecotrip Event booking - Conflit";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "Bcc:myecotrip17@gmail.com" . "\r\n";

            // More headers
            $headers .= 'From: <support@myecotrip.com>' . "\r\n";

            // mail($userInfo[0]['email'],$subject,$message,$headers);
            $sendMail = $this->sendEmail($userInfo[0]['email'], $userInfo[0]['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

            return view('payment/failure');

        }else{
            return view('payment/failure');
        }
    }

    public function responseReceiver(Request $request)
    {
        $workingKey = \Config::get('common.workingKey');
        $accessCode = \Config::get('common.accessCode');
        $merchantId = \Config::get('common.merchantId');

        $sessionData = session()->all();
        $sessionBookingData = $sessionData['bookingData'];

        $validation = $this->isAvaiable($sessionBookingData['eventType'],$sessionBookingData['tickets']);


        $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server

        //        $encResponse = '563f27f292a0566d28306e08eb1a1142dc65f721949d2b9eef67e94a562c96828da38534846e0a46dfbd59d9999643260833ed0e2ab65a2ddd541dbdb5cca7b55ac1eec202264361363cae0d1d27fe3443eb386e7ac35579fa468e582db46ef0a164e07b7b54c73d2f32af80bd801fcc5ea513d5a36e824395adb81c5da3b9b36aff5cdb218f88b84a419d248a8c351aba8f7c0690681e1a5757280a8716e2297445cafcd1b13e512af337330080241c4fb99d29d66d6241f9a6172ba5ba2bf6707924d1e4744318d2880292b55e5263339f14f00381d18335c94da9e0026866140d60d2accaf5dfbef6c2b306bad810cfa3950f908db177cb38700d20c4c689b6aa7a48459880b60060bd0a1df880e82ad73e69cfa59580621f1dc4534ba86567f0b6051d1f9813963b80a3ece5088241e930b24008aee954d72cb46447cebf0669a8cddb1497df584f6149174b069486dc69066133583a329f5c0737728fa6049ab1092b06635b08f71b003694bb99a0f3c7a2d5ea91a51070076cee7ce317ab55ca56a112550f6eae2dfa1d13fe35a472ac9d1a589b17148331a10375aacc12a479df56f28325e4dc79ace66ce0938902af934d776ad954dd244bce85ad23c976aa4f7c152dd96d088613629d3eaa72b5d2b00d69fd5b3630928b0fa71b776fb13591a0a816cf731d3c5a220f8d8ad77df2063e4a2a64de9cdcc53b25d06b313c68af6f7298441e7a9d31ca8af4c17eca95461381b958bc97eeffe214a670446914c31ade1d298788dfb60594906efd318527787151452d88edc10630a6933e948b16347f5e8f375fed28b1c4cfccfe64e8adefd8b019c1ac161f5df1083d254d63dc681e8cb865d1944fc19b3e6d5545e52f2b4b7ff1864bbddb80f18933e816b1e77d1c51347ceaf1ae76f6ea42b4a034e44e04f04210fec74ca33156d54cc07dbaebc74214b6a7c6f9c0cb400441c094c7af99e55683c6285fed11973fa5c03ab3a965da0cdee46fad07cfbde076aa44917c6f660173fc093ef4668492a42a809fcc46e681f55c415743b18b3264afa847b9df4973b21fa68ad01fe1966dd839e0f0fc9a60cf6b58736a164030342abd475b21b36d3db848bcdf2f3e577a66a40cdbba82f9fdf26bbac018997632b7ead01b2d98d9c3c68af4b80ed913eafbe217949dba0b10dde3b7321660b6';

        $rcvdString = $this->decrypt($encResponse, $workingKey);

        $orderStatus = "";
        $userEmail = "";
        $orderAmount = "";

        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);

//        echo '<pre>';print_r($decryptValues);exit();
        $keysNeeded = ['tracking_id','order_status','failure_message','payment_mode','card_name','trans_date', 'merchant_param1','merchant_param2'];
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
            if ($information[0] == 'merchant_param1')
                $totalTickets = $information[1];
            if ($information[0] == 'merchant_param2')
                $bookingType = $information[1];
            if ($information[0] == 'merchant_param3')
                $eventName = $information[1];
        }

        // update the row
        $updateContent = array();

        if ($validation != 'True'){
            // If seats are booked by others
            $orderStatus = 'Conflit-Booking';
        }

        $updateContent['booking_status'] = $orderStatus;
        $updateContent['gatewayResponse'] = json_encode($responseArray);

        $updateRow = \App\Events\EventsBooking::where('id',$orderId)->update($updateContent);

        // Data to send mail
        $bookingData = \App\Events\EventsBooking::join('birdsFestDetails', 'birdsFestDetails.id', '=', 'eventsBooking.event_id')->where('eventsBooking.id',$orderId)
            ->select('eventsBooking.*', 'birdsFestDetails.name as event_name')
            ->get()
            ->toArray();

        $bookingTypeInfo = \App\BirdsFest\birdFestPricings::where('id',$bookingType)->get()->toArray();

        // get the user details
        $userInfo = \App\User::where('id', $bookingData[0]['user_id'])->get()->toArray();

        if ($orderStatus == 'Success') {

            //Decrement remaning slots
            $decrementSlots = \App\BirdsFest\birdFestPricings::where('id',$bookingType)->decrement('remaining_slots',$totalTickets);

            // Send a mail to user account
            if ($userEmail != '') {

                // Send SMS
                $data['userInfo'] = $userInfo[0];
                $data['bookingData'] = $bookingData[0];

               $this->bookingSMS($data, 3);


                $subject = "Myecotrip Event booking";

                $message = \View::make('payment.eventMailTemplate', ['bookingData' => $bookingData[0]]);

                $sendMail = $this->sendEmail($userEmail, $userInfo[0]['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

                return view('payment/success', ['userEmail'=> $userEmail]);

            }
        }else if($orderStatus == 'Conflit-Booking'){
            //Send user a mail with booking Id for failure reference
            $message = 'Dear '.$userInfo[0]['first_name'] . ' <br />. Your booking reference Id : '. $bookingData[0]['display_id'] . ' <br /> There was a delay in ur payment process. So please contact our customer support for further details.';

            $subject = "Myecotrip Event booking - Conflit";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "Bcc:myecotrip17@gmail.com" . "\r\n";

            // More headers
            $headers .= 'From: <support@myecotrip.com>' . "\r\n";

            $sendMail = $this->sendEmail($userEmail, $userInfo[0]['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

            // mail($userEmail,$subject,$message,$headers);
            return view('payment/failure');

        }else{
            return view('payment/failure');
        }

    }


}
