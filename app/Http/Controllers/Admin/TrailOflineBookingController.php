<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class TrailOflineBookingController extends Controller
{
    public function trailBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('trailId')) {
            try {

            	$numberOfTruckers = 0;
            	$returnData = [];

                $trailId = $request->session()->get('trailId');

                // Todays dertails
                $getBooking = \App\TrailOflineBOokings::where('trail_id',$trailId)
                    ->where('checkIn',date("Y-m-d 00:00:00"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    
                    if ($bookings['booking_status'] == "Success") {
                        $returnData[] = $getBooking[$index];
                        $numberOfTruckers += $bookings['number_of_trekkers'];
                    }                    
                }

                // echo "<pre>";print_r($returnData);exit();
                return view('Admin/adminPages/trails/oflineIndex', ['getBooking'=> $returnData,'numberOfTruckers' =>$numberOfTruckers]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('oflineTrailBookings');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function getTrekkersDetails(Request $request)
    {

        $trailId = $this->getLoggedInUserDetails($request, 'trailId');

        $getTimeSlots = \App\TrailPricing::join('ecotrailTimeSlots', 'ecotrailTimeSlots.id','=','trailPricing.ecotrailTimeSlots_id')
                    ->select('trailPricing.*', 'ecotrailTimeSlots.timeslots')
                    ->where('trailPricing.trail_id', $trailId)
                    ->get()
                    ->toArray();
        // echo "<pre>"; print_r($getTimeSlots);exit();

        return view('Admin/adminPages/trails/passengerDetails', ['timeSlots' => $getTimeSlots]);

    }

    public function offlineTrailBookNow(Request $request)
    {
    	if ($request->session()->get('trailId')) {
            try {
            	$trailId = $request->session()->get('trailId');
            	$numberOfTruckers = 0;

            	// Todays online details
                $getBooking = \App\TrailBooking::where('trail_id',$trailId)
                    ->where('checkIn',date("Y-m-d 00:00:00"))
                    ->where('booking_status','Success')
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                        $numberOfTruckers += $bookings['number_of_trekkers'];
                }

                // Todays Offline dertails
                $getBooking = \App\TrailOflineBOokings::where('trail_id',$trailId)
                    ->where('checkIn',date("Y-m-d 00:00:00"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    $numberOfTruckers += $bookings['number_of_trekkers'];
                }

                // Get the maximum trekkers
                $maxTrekkers = \App\Trail::where('id',$trailId)->select('max_trekkers','max_offline_trekkers')->get()->toArray();

                $maxTrekkers = $maxTrekkers[0]['max_trekkers'] + $maxTrekkers[0]['max_offline_trekkers'] - $numberOfTruckers;

                // echo "<pre>";print_r($maxTrekkers);exit();
                return view('Admin/adminPages/trails/bookNow',['maxTrekkers'=> $maxTrekkers]);

            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('offlineTrailBookNow');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function getAdultChildPrice($priceList){
        $priceList = json_decode($priceList, true);

        $returnData['pricePerPerson'] = 0;
        $returnData['pricePerChild'] = 0;
        $returnData['pricePerStudent'] = 0;

        $keysNeeded = ['TAC','guide_fee','entry_fee'];
        $childKeysNeeded = ['TAC_child','guide_fee_child','entry_fee_child'];

        foreach ($keysNeeded as $key => $priceType) {
            $returnData['pricePerPerson'] += $priceList['India']['adult'][$priceType];
        }

        foreach ($childKeysNeeded as $key => $priceType) {
            $returnData['pricePerChild'] += $priceList['India']['child'][$priceType];
        }

        foreach ($keysNeeded as $key => $priceType) {
            $returnData['pricePerStudent'] += $priceList['India']['student'][$priceType];
        }

        return $returnData;
    }

    public function saveOfflineTrail(Request $request)
    {   
        // echo "<pre>"; print_r($request->session());exit();
    	if ($request->session()->get('trailId')) {
            try {

            	$data = $_POST;
                $trailId = $this->getLoggedInUserDetails($request, 'trailId');
                $userId = $this->getLoggedInUserDetails($request, 'userId');
		    	
                // Generate the display booking id.
		        $digits = 6;
		        $randNo = rand(pow(10, $digits-1), pow(10, $digits)-1);

		        // $userId = $request->session()->get('userId');   
		        $displayId = date('ymd'). $randNo;

		        // get the trekkers details
		        $trekkerDetails = [];
		        foreach ($_POST['detail'] as $key => $value) {
		            $trekkerDetails[] = $value;
		        }

                $getTimeSlots = explode("||", $data['time_slot']);

                //Cal the amount
                //Get the pricing for the timeslot
                $getPricingRow = \App\TrailPricing::where('id', $getTimeSlots[0])->get()->toArray();
                $getPrice = $this->getAdultChildPrice($getPricingRow[0]['price']);

                // echo "<pre>"; print_r($getPrice);exit();
                // Cal to the grand total amount.
                $childPrice = $data['requestedChildrenSeats'] * $getPrice['pricePerChild'];
                $studentPrice = $data['requestedStudentSeats'] * $getPrice['pricePerStudent'];
                $adultPrice = $data['requestedSeats'] * $getPrice['pricePerPerson'];
                $totalAmount = $adultPrice + $childPrice + $studentPrice;

                // Internet handling charge
                $internetHandlingPercentage = \Config::get('common.internetHandlingCharge');
                $internetHandling = ($internetHandlingPercentage / 100) * $totalAmount;

                //GST charges
                $gstPercentage = \Config::get('common.gstCharge');
                $gstAmount = ($gstPercentage / 100) * $internetHandling;

                // Payment gateway
                $paymentGatewayPercentage = \Config::get('common.paymentGatewayCharge');
                $paymentGateway = ($paymentGatewayPercentage / 100) * ($totalAmount + $internetHandling + $gstAmount);
            
                $totalPayable = round($totalAmount + $internetHandling + $paymentGateway + $gstAmount, 2);

		        $bookingInit = array();
                $bookingInit['trail_id'] = $trailId;
		        $bookingInit['user_id'] = $userId;
		        $bookingInit['name'] = $data['detail'][0]['name'];
		        $bookingInit['contat_no'] = $data['contat_no'];
		        $bookingInit['email'] = $data['email'];
		        $bookingInit['date_of_booking'] = date("Y-m-d H:i:s");
		        $bookingInit['checkIn'] = date("Y-m-d")." 00:00:00" ;
		        $bookingInit['number_of_trekkers'] = $data['requestedSeats'] ;
                $bookingInit['number_of_children'] = $data['requestedChildrenSeats'] ;
                $bookingInit['number_of_students'] = $data['requestedStudentSeats'] ;
		        $bookingInit['amount'] = $totalAmount ;
                $bookingInit['gst_amount'] = $gstAmount ;
		        $bookingInit['amountWithTax'] = $totalPayable;
                $bookingInit['time_slot'] = $getTimeSlots[1];
		        $bookingInit['booking_status'] = 'Waiting';
		        $bookingInit['display_id'] = $displayId;
		        $bookingInit['trekkers_details'] = json_encode($trekkerDetails);
                $bookingInit['total_trekkers'] = $data['requestedSeats'] + $data['requestedChildrenSeats'] + $data['requestedStudentSeats'];

		        $placeOrder = \App\TrailOflineBOokings::create($bookingInit);
		        $bookingId = $placeOrder->id;

                $bookingId = $placeOrder->id;

                // Payment data
                $redirectUrl = url('/').'/admin/ecotrails/adminResponseReceiver';

                $paymentData = [];
                $paymentData['order_id']        = $bookingId;
                $paymentData['userId']          = $userId;
                $paymentData['amount']          = $totalPayable;
                $paymentData['redirect_url']    = $redirectUrl;
                $paymentData['cancel_url']      = $redirectUrl;
                $paymentData['merchant_param1'] = $bookingId;
                $paymentData['merchant_param4'] = $displayId;
                $paymentData['contat_no'] = $data['contat_no'];
                $paymentData['email'] = $data['email'];


                $data = $this->initAdminPaymentTran($paymentData);

                if ($data == 0) {
                    Session::flash('message', 'Sorry could not process. '); 
                    Session::flash('alert-class', 'alert-danger'); 
                    return redirect()->route('offlineTrailBookNow');
                }else{
                    return view('payment/requestHandler', ['data'=> $data]);
                }


            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('offlineTrailBookNow');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function responseReceiver(Request $request)
    {   
        $workingKey = \Config::get('common.workingKey');
        $accessCode = \Config::get('common.accessCode');
        $merchantId = \Config::get('common.merchantId');

        $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server

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
            if ($information[0] == 'billing_tel')
                $phoneNo = $information[1];
        }
        

        // update the row
        $updateContent = array();

        $updateContent['booking_status'] = $orderStatus;
        $updateContent['gatewayResponse'] = json_encode($responseArray);

        $updateRow = \App\TrailOflineBOokings::where('id',$orderId)->update($updateContent);
        
        if ($orderStatus == 'Success') {

            // Send a mail to user account
            if ($userEmail != '') {
                $bookingData = \App\TrailOflineBOokings::where('id',$orderId)->get()->toArray();

                $trailData = \App\Trail::where('id',$bookingData[0]['trail_id'])->get()->toArray();

                // Send SMS to do
                $data['userInfo'] = ['contact_no' => $phoneNo, 'first_name' => 'Trekker'];
                $data['trailData'] = $trailData[0];
                $data['bookingData'] = $bookingData[0];
                
                // $this->bookingSMS($data, 1);

                $bookingData[0]['trekkers_details'] = json_decode($bookingData[0]['trekkers_details'],true);

                $qrFileName = $bookingData[0]['display_id'].'.png';
                $qrText = $bookingData[0]['display_id'] . '$$' .$bookingData[0]['number_of_trekkers']. '$$' . $bookingData[0]['checkIn'] ;

                //Save the QR file
                \QrCode::format('png')->generate($qrText, public_path().'/assets/img/qrcodes/'.$qrFileName);


                // echo "<pre>";print_r($bookingData[0]);exit();
                // return \View::make('payment.trailMailTemplate', ['bookingData' => $bookingData[0], 'trailData' => $trailData[0]]);
                
                $message = \View::make('payment.trailMailTemplate', ['bookingData' => $bookingData[0], 'trailData' => $trailData[0], 'qrFileName' => $qrFileName]);

                $subject = "Ecotrail booking";
                $sendMail = $this->sendEmail($userEmail, $data['userInfo']['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

                return view('payment/success', ['userEmail'=> $userEmail]);

            }
        }else{
                return view('payment/failure');
        }

    }

    public function offlineBookingDetails(Request $request, $bookingId)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('trailId')) {
            try {
                $trailId = $request->session()->get('trailId');

                // booking details
                $bookingData = \App\TrailOflineBOokings::where('id',$bookingId)->get()->toArray();
                $bookingData = $bookingData[0];

                $bookingData['trekkers_details'] = json_decode($bookingData
                    ['trekkers_details'],true);

                $bookingData['first_name'] = $bookingData['name'];
                $bookingData['last_name'] = '';

                // Trail Details
                // $trailData = \App\Trail::where('id',$trailId)->get()->toArray();

                // echo "<pre>";print_r($bookingData);print_r($userData);exit();
                return view('Admin/adminPages/trails/offlineBookingDetails', ['bookingData'=> $bookingData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('offlineTrailBookNow');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }
}
