<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class SafariController extends Controller
{
    public function index()
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $safariList = \App\Safari\Safari::all()->toArray();
            // redirecting to safarilist front end view page
            return view('safari/safarilist',['safariList'=>$safariList]);
        } catch (Exception $e) {
            return redirect()->route('home');
        }
    }

    public function getSafariDetails(Request $request, $safariId, $safariName)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

            $safariDetail = \App\Safari\Safari::where('id',$safariId)->get()->toArray();
            $tranIds = explode(",",$safariDetail[0]['transportation_id']);
            $transporttypeslist = \App\Transportation\TransportationTypes::whereIn('id', $tranIds)->get()->toArray();

            // get transportations types details for particluar safari
            $tranWithName = array();
            foreach($transporttypeslist as $tran ){
                $tranWithName[$tran['id']] = $tran['name'];
            }

            // get the images of the safari
            $safariImages = \App\Safari\SafariImages::where('safari_id', $safariId)->get()->toArray();
            $safariDetail[0]['safariImages'] = $safariImages;

            // set safariDetail url to session (to avoid loading  _previous url)
            // session(['safariDetailURL'=> \Request::fullUrl()]);

            // echo "<pre>";print_r(session()->all());exit();
            return view('safari/safariDetail', ['safariDetail'=> $safariDetail[0], 'safariId' => $safariId, 'safariName' => $safariName,'safariTransportation'=>$tranWithName]);
        } catch (Exception $e) {
            return redirect()->route('safarilist');
        }
    }

    public function getSafariTimeSlots($safariId, $transportationId){

        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        try {
            $getSlots = \App\TimeSlots::all()->toArray();
            $timeSlot = array();
            foreach ($getSlots as $getSlot) {
                $timeSlot[$getSlot['id']] = $getSlot['timeslots'];
            }

            // get timeslots for particular safari and transportation type
            $timeSlots = \App\Safari\SafariNumbers::where('safari_id',$safariId)
                ->where('transportation_id',$transportationId)
                ->get()->toArray();
            $finalTimeSlotArray = array();
            foreach ($timeSlots as $time){
                $finalTimeSlotArray[$time['timeslot_id']] = $timeSlot[$time['timeslot_id']];
            }

            // set safariDetail url to session (to avoid loading  _previous url)
            $data =  session()->get('_previous');
            session(['safariDetailURL'=> $data['url']]);

            //dynamic timeslot div loading
            return view('safari/dynamic',['timeSlots'=>$finalTimeSlotArray]);

        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('safari/safariDetail'));
        }
    }

    public function checkAvailability(Request $request,$safariId,$safariName)
    {
        $sessionData = session()->all();
        $transportationId = $_POST['transportation'];

        $expoldeTimeslot = explode("##", $_POST['timeslots']);
        $timeslotId = $expoldeTimeslot[0];
        $timeslotValue = $expoldeTimeslot[1];

        if ($request->session()->get('userId')) {
            $request->session()->forget('bookingData');
            $request->session()->forget('bookingDatas');

            $data = $_POST;
            $getCheckDate = explode(" ", $data['startSafari']);
            $checkDate = $getCheckDate[0];
            $totalSeats = '';
            $remainingSeats = '';
            $sendData = [];

            if($checkDate != date("Y-m-d")) {
                if ($data['noOfSeats'] == '4+') {
                    $checkSafariSeats = $data['noOfSeats2'];
                }else{
                    $checkSafariSeats = $data['noOfSeats'];
                }
                $userRequestedSeats = $checkSafariSeats;

                // $checkTypeResult resluts in whether the transportation is of Full booking/ Individual booking
                $checkTypeResult = $this->getCheckType($safariId, $transportationId);

                $safariLogo = \App\Safari\Safari::select('logo')->where('id',$safariId)->get()->toArray();

                // get total vehicle count for particular safari, transportation type, and timeslot
                $getVehicleCount = $this->getVehicleCount($safariId, $transportationId, $timeslotId);

                // get individual total_max transportation seats for particular safari and transportation type
                $getTransportationSeats = $this->getTransportationSeats($safariId, $transportationId);

                // get safari and transportation entry fees
                $getSafariEntryFeePriceList = $this->getSafariEntryFeePriceList($safariId);
                $getSafariTransportatiionFeePriceList = $this->getSafariTransportatiionFeePriceList($safariId, $transportationId);

                if($checkTypeResult){
                    // Individual booking

                    $vehicleMaxSeats = array();

                    // get already booked seats
                    foreach ($getVehicleCount as $index => $vehicle){
                        $bookedSeats = \App\Safari\SafariBookingEntries::whereDate('checkIn', '=', $checkDate)
                            ->where('safari_id', $safariId)
                            ->where('transportation_id', $transportationId)
                            ->where('timeslot_id', $timeslotId)
                            ->where('vehicle_id', $vehicle['vehicle_id'])
                            ->where(function ($query) {
                                $query->where('booking_status', '=', 'Success')
                                    ->OrWhere('booking_status', '=', 'Waiting');
                            })
                            ->selectRaw('sum(no_of_seats) AS bookedSeats')
                            ->get()
                            ->toArray();

                        $vehicleMaxSeats[$index]['id'] = $vehicle['vehicle_id'];
                        $vehicleMaxSeats[$index]['totalSeats'] = $getTransportationSeats[0]['no_of_seats'];
                        $vehicleMaxSeats[$index]['no_of_seats_booked'] = $bookedSeats[0]['bookedSeats'];
                        $vehicleMaxSeats[$index]['availableSeats'] = $vehicleMaxSeats[$index]['totalSeats'] - $vehicleMaxSeats[$index]['no_of_seats_booked'];
                    }

                    $showVehicles = array();

                    // logic for showing available seats and vehicles for Individaul booking transportations
                    foreach ($vehicleMaxSeats as $vehicleSeats){
                        $availableTotalSeats[] = $vehicleSeats['availableSeats'];
                        if($vehicleSeats['availableSeats'] == 0){
                            continue;
                        }
                        else if($userRequestedSeats <= $vehicleSeats['availableSeats']){
                            $showVehicles[] = $vehicleSeats;
                            break;
                        }else{
                            $showVehicles[] = $vehicleSeats;
                        }
                    }

                    // alert message if userRequested seats is greater than the total available seats.
                    if($checkSafariSeats > array_sum($availableTotalSeats)){
                        Session::flash('TranErrMessage', 'Sorry only '.array_sum($availableTotalSeats).' seats are available');
                        Session::flash('alert-class', 'alert-danger');
                        return \Redirect::to(url('/').'/safaries');
                    }

                    // getting details of the available vehicles for booking
                    foreach ($showVehicles as $index =>$vehicle){
                        $vehiclelist = \App\Safari\SafariVehicle::where('safari_id',$safariId)
                            ->where('transportation_id',$transportationId)
                            ->where('full_booking',0)
                            ->where('id',$vehicle['id'])
                            ->get()->toArray();

                        $showVehicles[$index]['displayName'] = $vehiclelist[0]['displayName'];
                    }

                    $sendData['showVehicles'] = $showVehicles;
                    $remainingSeats = array_sum($availableTotalSeats);
                }
                else
                {

                    // Full booking
                    $transportationSeats = $getTransportationSeats[0]['no_of_seats'];

                    foreach ($getVehicleCount as $tranportvehicles){
                        $vehicleresult[] = $tranportvehicles['vehicle_id'];
                    }

                    // get already booked seats
                    $bookedSeats = \App\Safari\SafariBookingEntries::whereDate('checkIn', '=', $checkDate)
                        ->where('safari_id', $safariId)
                        ->where('transportation_id', $transportationId)
                        ->where('timeslot_id', $timeslotId)
                        ->where(function ($query) {
                            $query->where('booking_status', '=', 'Success')
                                ->OrWhere('booking_status', '=', 'Waiting');
                        })
                        ->get()
                        ->toArray();

                    foreach ($bookedSeats as $bookedVehicleId) {
                        $bookedvehicleresult[] = $bookedVehicleId['vehicle_id'];
                    }

                    if(empty($bookedSeats)) {
                        $bookedvehicleresult[] = ' ';
                    }

                    $remainingVehicle = array_diff($vehicleresult, $bookedvehicleresult);

                    // getting details of the available vehicles for booking
                    $vehiclelist = \App\Safari\SafariVehicle::where('safari_id',$safariId)
                        ->where('transportation_id',$transportationId)
                        ->where('full_booking',1)
                        ->whereIn('id',$remainingVehicle)
                        ->get()->toArray();

                    // echo "<pre>";print_r($vehiclelist);exit();
                    $n = count($vehiclelist);
                    $totalSeats = $n * $transportationSeats;

                    // logic for showing vehicles which are not booked for Full booking transportations
                    if($totalSeats > $checkSafariSeats){
                        for($i=0;$i<$n;$i++){
                            $eachVehicleSeat = $checkSafariSeats - $transportationSeats;
                            if($eachVehicleSeat == 0){
                                $vehiclelist[$i]['availableSeats'] = $transportationSeats;
                                $sendData['showVehicles'][] = $vehiclelist[$i];
                                break;
                            }else if($eachVehicleSeat > 0){
                                $vehiclelist[$i]['availableSeats'] = $transportationSeats;
                                $sendData['showVehicles'][] = $vehiclelist[$i];
                                $checkSafariSeats = $eachVehicleSeat;
                            }else{
                                $vehiclelist[$i]['availableSeats'] = $transportationSeats;
                                $sendData['showVehicles'][] = $vehiclelist[$i];
                                break;
                            }
                        }
                    }
                }

                if ($totalSeats > $checkSafariSeats || $remainingSeats >= $checkSafariSeats) {
                    $sendData['safariId'] = $safariId;
                    $sendData['safariName'] = $safariName;
                    $sendData['safariLogo'] = $safariLogo[0]['logo'];
                    $sendData['transportationId'] = $transportationId;
                    $sendData['timeslotId'] = $timeslotId;
                    $sendData['timeslotValue'] = $timeslotValue;
                    $sendData['requestedSeats'] = $userRequestedSeats;
                    $sendData['travelDate'] = $data['startSafari'];
                    $sendData['perHead'] = $data['amount'];

                    session(['bookingData' => $sendData]);
                    return redirect()->route("getVistiorsDetails");
                }else{
                    Session::flash('valMessage', 'Sorry limited/No seats available on '.$data['startSafari'].' for selected time. Please try for different timeslot');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route("getSafariDetails",[$safariId,$safariName]);
                }
            }else{
                Session::flash('valMessage', 'Sorry bookings are closed for today!!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route("getSafariDetails",[$safariId,$safariName]);
            }
        }else{
            Session::flash('message', 'Please login to continue booking.');
            Session::flash('alert-class', 'alert-danger');
            if(isset($sessionData['safariDetailURL'])){
                return \Redirect::to($sessionData['safariDetailURL']);
            }
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    //function for checking full booking or individual booking
    public function getCheckType($safariId, $transportationId){
        $checkType = \App\Safari\SafariVehicle::where('safari_id', $safariId)
            ->where('transportation_id', $transportationId)
            ->where('full_booking',0)
            ->get()->toArray();

        if(count($checkType) > 0){
            return true;
        }else{
            return false;
        }
    }

    // function for get total vehicles
    public function getVehicleCount($safariId, $transportationId, $timeslotId){
        $getVehicleCount = \App\Safari\SafariNumbers::where('safari_id',$safariId)
            ->where('transportation_id',$transportationId)
            ->where('timeslot_id',$timeslotId)
            ->orderBy('vehicle_id','asc')
            ->get()->toArray();

        if(count($getVehicleCount)> 0){
            return $getVehicleCount;
        }else{
            return false;
        }
    }

    // function for get total transportations
    public function getTransportationSeats($safariId, $transportationId){
        $getTransportationSeats = \App\Safari\SafariTransportationPrice::select('no_of_seats')
            ->where('safari_id', $safariId)
            ->where('transportation_id', $transportationId)
            ->get()->toArray();

        if(count($getTransportationSeats )> 0){
            return $getTransportationSeats;
        }else{
            return false;
        }
    }

    // function for sending visitorDetails to view file
    public function getVistiorsDetails(Request $request)
    {
        if ($request->session()->get('bookingData')) {
            $displayData = $request->session()->get('bookingData');

            // Cal to the grand total amount.
            $totalAmount = $displayData['requestedSeats'] * $displayData['perHead'];

            // Internet handling charge
            $internetHandlingPercentage = \Config::get('common.internetHandlingCharge');
            $internetHandling = ($internetHandlingPercentage / 100) * $totalAmount;

            // Payment gateway
            $paymentGatewayPercentage = \Config::get('common.paymentGatewayCharge');
            $paymentGateway = ($paymentGatewayPercentage / 100) * $totalAmount;

            $displayData['total'] = $totalAmount;
            $displayData['serviceCharges'] = $internetHandling + $paymentGateway;
            $displayData['totalPayable'] = $totalAmount + $internetHandling + $paymentGateway;

            session(['bookingData' => $displayData]);

            // echo "<pre>";print_r($request->session()->get('bookingData'));exit();
            return view('safari/visitorsDetails', ['displayData'=> $displayData]);
        }else{
            $data =  $request->session()->get('_previous');

            return \Redirect::to($data['url']);
        }
    }

    // function for sending transportations and vehicleId for the (visitorDetails view -> userDetailsList is appending in the dynamic div)
    public function getUserDetailsList(Request $request,$transportationSeats,$vehicleId){
        $userDetailsList = array() ;
        $userDetailsList['transportationSeats'] = $transportationSeats;
        $userDetailsList['vehicleId'] = $vehicleId;
        return view('safari/userDetailsList', ['userDetailsList'=> $userDetailsList]);
    }


    public function confirmSafariBooking(Request $request)
    {
        $fullSecssiondata = session()->all();
        if ($request->session()->get('userId')) {
            try{
                    $sessionData = $request->session()->get('bookingData');

                    // echo "<pre>"; print_r($fullSecssiondata);exit();
                    $getSafariTransportatiionFeePriceList = $this->getSafariTransportatiionFeePriceList($sessionData['safariId'], $sessionData['transportationId']);

                    $safariEntryFee = \App\Safari\SafariEntryFee::where('safari_id',$sessionData['safariId'])->get()->toArray();

                    // logic for calculating amount for indian and foreigner
                    if ($_POST['detail']> 0 && $getSafariTransportatiionFeePriceList['status'] == "success") {     

                        $safariTransportatiionFeePriceList = $getSafariTransportatiionFeePriceList['data'];

                        $safariFee = 0;
                        $totalEntryFee = 0;
                        foreach ($_POST['detail'] as $vehicleId => $value) {

                            // Checking requested and vistior details are same.
                            $sumcount[] = count($value);
                            if(array_sum($sumcount) > $sessionData['requestedSeats'] || array_sum($sumcount) < $sessionData['requestedSeats']){
                                Session::flash('safariErrMessage', 'Please ensure that requested seat and number of visitors details are same. Requested seat was '.$sessionData['requestedSeats']);
                                Session::flash('alert-class', 'alert-danger');
                                if(isset($fullSecssiondata['safariDetailURL'])){
                                    return \Redirect::to($fullSecssiondata['safariDetailURL']);
                                }
                                return \Redirect::to(url('/').'/safaries');
                            }

                            foreach ($value as $vehiclePassenger) {
                                $visitorType = 0;
                                if (isset($vehiclePassenger['visitorType'])) {
                                    // Foreigner passenger
                                    $visitorType = 1;
                                }
                                $safariFee += $this->getTransportationPrice($safariTransportatiionFeePriceList, $visitorType, $vehiclePassenger['age']);

                                $totalEntryFee += $this->calEntryFee($safariEntryFee,$visitorType, $vehiclePassenger['age']);
                            }
                        }

                        $totalAmount = $safariFee + $totalEntryFee;
                        // Internet handling charge
                        $internetHandlingPercentage = \Config::get('common.internetHandlingCharge');
                        $internetHandling = ($internetHandlingPercentage / 100) * $totalAmount;

                        // Payment gateway
                        $paymentGatewayPercentage = \Config::get('common.paymentGatewayCharge');
                        $paymentGateway = ($paymentGatewayPercentage / 100) * $totalAmount;

                        $displayData['safariFee'] = $safariFee;
                        $displayData['entryFee'] = $totalEntryFee;
                        $displayData['serviceCharges'] = $internetHandling + $paymentGateway;
                        $displayData['totalPayable'] = $totalAmount + $internetHandling + $paymentGateway;

                        // echo "<pre>";print_r($_POST);exit();
                        return view('safari/confirmBooking', ['postData'=> $_POST, 'feeDetails' => $displayData, 'displayData' => $sessionData]);

                    }
            } catch (Exception $e) {
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

    public function initiateBooking(Request $request)
    {
        $_POST['detail'] = json_decode($_POST['detail'], true);
        $_POST['feeDetails'] = json_decode($_POST['feeDetails'], true);
        
        // echo "<pre>"; print_r($_POST);exit();
        $sessionData = $request->session()->get('bookingData');
        // Reconfirm the seat availability
        //$availability = $this->confirmAvailability($sessionData['safariId'], $sessionData['travelDate'], $sessionData['requestedSeats'], $sessionData['transportationId'] = 1, $sessionData['timeslotId'] = 2);
        $availability = 1;

        if ($availability) {
            // check user login
            if ($request->session()->get('userId')) {
                if (count($sessionData) > 0) {

                    // Generate the display booking id.
                    $digits = 4;
                    $randNo = rand(pow(10, $digits-1), pow(10, $digits)-1);

                    $userId = $request->session()->get('userId');
                    $displayId = date('ymd').$userId. $randNo;
                    $visitorsDetails = array();
                    $vehicleIds = array();

                        // visitorsData to insert into safariBookingEntries table
                        foreach ($_POST['detail'] as $vehicleId => $value) {
                            // $vehicleId[] = $vehicleId;
                            $totalseatscount = $sessionData['requestedSeats'];

                            $bookingInit = array();
                            $bookingInit['safari_id'] = $sessionData['safariId'];
                            $bookingInit['transportation_id'] = $sessionData['transportationId'];
                            $bookingInit['timeslot_id'] = $sessionData['timeslotId'];
                            $bookingInit['vehicle_id'] = $vehicleId;
                            $bookingInit['user_id'] = $userId;
                            $bookingInit['checkIn'] = $sessionData['travelDate'] ;
                            $bookingInit['no_of_seats'] = $totalseatscount;
                            $bookingInit['seat_numbers'] = '';
                            $bookingInit['amount'] = $_POST['feeDetails']['totalPayable'] ;
                            $bookingInit['booking_status'] = 'Waiting';
                            $bookingInit['display_id'] = $displayId;

                            $vehicleIds[] = $vehicleId;
                            foreach ($value as $passDetails){
                                $passDetails['vehicleId'] = $vehicleId;
                                $passengerdetails[] = $passDetails;
                            }
                            $value = array_values($value);
                            $bookingInit['visitors_details'] = json_encode($value);

                            $insert = \App\Safari\SafariBookingEntries::create($bookingInit);
                        }

                        $bookingEntryData = \App\Safari\SafariBookingEntries::where('display_id',$bookingInit['display_id'])
                            ->get()->toArray();


                        // visitorsData to insert into safariBookings table from SafariBookingEntries table
                        $bookingInit['no_of_seats'] = $totalseatscount; 
                        $bookingInit['visitors_details'] = json_encode($passengerdetails);
                        $bookingInit['vehicle_id'] = implode(',',$vehicleIds);
                        $bookingInit['date_of_booking'] = date("Y-m-d H:i:s");
                        $bookingInit['amount_with_tax'] = $_POST['feeDetails']['totalPayable'];
                        $bookingInit['amount'] = $_POST['feeDetails']['safariFee'];
                        $bookingInit['park_entry_amount'] = $_POST['feeDetails']['entryFee'];
                        $bookingInit['service_charge'] = $_POST['feeDetails']['serviceCharges'];

                        $placeOrder = \App\Safari\SafariBookings::create($bookingInit);
                        $bookingId = $placeOrder->id;

                        // Payment data
                        $redirectUrl = url('/') . '/safari/responseReceiver';

                        $paymentData = [];
                        $paymentData['order_id'] = $bookingId;
                        $paymentData['userId'] = $userId;
                        $paymentData['amount'] = $_POST['feeDetails']['totalPayable'];
                        $paymentData['redirect_url'] = $redirectUrl;
                        $paymentData['cancel_url'] = $redirectUrl;
                        $paymentData['merchant_param1'] = $bookingId;

                        $data = $this->initPaymentTran($paymentData);

                        if ($data == 0) {
                            return \Redirect::to(url('/') . '/safaries');
                        } else {
                            return view('payment/requestHandler', ['data' => $data]);
                        }
                }else{
                    return \Redirect::to(url('/').'/safaries');
                }
            }else{
                return \Redirect::to(url('/').'/safaries');
            }
        }else{
            Session::flash('TranErrMessage', 'Available seats are being booked!! Please checks seats available and book faster.');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('/').'/safaries');
        }
    }

    public function responseReceiver(Request $request)
    {
        $workingKey = \Config::get('common.workingKey');
        $accessCode = \Config::get('common.accessCode');
        $merchantId = \Config::get('common.merchantId');

        $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server

        // $encResponse = '563f27f292a0566d28306e08eb1a1142dc65f721949d2b9eef67e94a562c96828da38534846e0a46dfbd59d9999643260833ed0e2ab65a2ddd541dbdb5cca7b55ac1eec202264361363cae0d1d27fe3443eb386e7ac35579fa468e582db46ef0a164e07b7b54c73d2f32af80bd801fcc5ea513d5a36e824395adb81c5da3b9b36aff5cdb218f88b84a419d248a8c351aba8f7c0690681e1a5757280a8716e2297445cafcd1b13e512af337330080241c4fb99d29d66d6241f9a6172ba5ba2bf6707924d1e4744318d2880292b55e5263339f14f00381d18335c94da9e0026866140d60d2accaf5dfbef6c2b306bad810cfa3950f908db177cb38700d20c4c689b6aa7a48459880b60060bd0a1df880e82ad73e69cfa59580621f1dc4534ba86567f0b6051d1f9813963b80a3ece5088241e930b24008aee954d72cb46447cebf0669a8cddb1497df584f6149174b069486dc69066133583a329f5c0737728fa6049ab1092b06635b08f71b003694bb99a0f3c7a2d5ea91a51070076cee7ce317ab55ca56a112550f6eae2dfa1d13fe35a472ac9d1a589b17148331a10375aacc12a479df56f28325e4dc79ace66ce0938902af934d776ad954dd244bce85ad23c976aa4f7c152dd96d088613629d3eaa72b5d2b00d69fd5b3630928b0fa71b776fb13591a0a816cf731d3c5a220f8d8ad77df2063e4a2a64de9cdcc53b25d06b313c68af6f7298441e7a9d31ca8af4c17eca95461381b958bc97eeffe214a670446914c31ade1d298788dfb60594906efd318527787151452d88edc10630a6933e948b16347f5e8f375fed28b1c4cfccfe64e8adefd8b019c1ac161f5df1083d254d63dc681e8cb865d1944fc19b3e6d5545e52f2b4b7ff1864bbddb80f18933e816b1e77d1c51347ceaf1ae76f6ea42b4a034e44e04f04210fec74ca33156d54cc07dbaebc74214b6a7c6f9c0cb400441c094c7af99e55683c6285fed11973fa5c03ab3a965da0cdee46fad07cfbde076aa44917c6f660173fc093ef4668492a42a809fcc46e681f55c415743b18b3264afa847b9df4973b21fa68ad01fe1966dd839e0f0fc9a60cf6b58736a164030342abd475b21b36d3db848bcdf2f3e577a66a40cdbba82f9fdf26bbac018997632b7ead01b2d98d9c3c68af4b80ed913eafbe217949dba0b10dde3b7321660b6';

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

        // echo "<pre>"; print_r($decryptValues);exit();
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

        $updateRow = \App\Safari\SafariBookings::where('id',$orderId)->update($updateContent);

        if ($orderStatus == 'Success') {

            // Send a mail to user account
            if ($userEmail != '') {
                // $orderId = 1;
                $bookingData = \App\Safari\SafariBookings::where('id',$orderId)->get()->toArray();

                $safariData = \App\Safari\Safari::where('id',$bookingData[0]['safari_id'])->get()->toArray();

                $vehicleList = \App\Safari\SafariVehicle::all()->toArray();

                foreach ($vehicleList as $key => $vehicle) {
                    $vehicleName[$vehicle['id']] = $vehicle['displayName'];
                }

                $visitorsDetails = json_decode($bookingData[0]['visitors_details'], true);
                foreach ($visitorsDetails as $index => $visitor) {
                    $visitorsDetails[$index]['vehicleName'] = $vehicleName[$visitor['vehicleId']];
                }
                
                // Transportaion type 
                $getTransportaionType = \App\Transportation\TransportationTypes::where('id',$bookingData[0]['transportation_id'])->get()->toArray();

                // timeslot
                $getTimeSlot = \App\TimeSlots::where('id', $bookingData[0]['timeslot_id'])->get()->toArray();

                $safariDetail['transportaionType'] = $getTransportaionType[0]['name'];
                $safariDetail['timeSlotName'] = $getTimeSlot[0]['timeslots'];
                $safariDetail['visitorsDetails'] = $visitorsDetails;

                // get the user details
                $userInfo = \App\User::where('id', $bookingData[0]['user_id'])->get()->toArray();

                // Send SMS
                $data['userInfo'] = $userInfo[0];
                $data['safariData'] = $safariData[0];
                $data['bookingData'] = $bookingData[0];
                $data['safariDetail'] = $safariDetail;
                
                $this->bookingSMS($data, 2);


                // echo "<pre>"; print_r($bookingData);exit();
                // return  \View::make('payment.safariMailTemplate', ['bookingData' => $bookingData[0], 'safariData' => $safariData[0], 'safariDetail'=> $safariDetail]);

                $message = \View::make('payment.safariMailTemplate', ['bookingData' => $bookingData[0], 'safariData' => $safariData[0], 'safariDetail'=> $safariDetail]);

                $subject = "Myecotrip - Safari booking confirmation";
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

    // function for get safari entry fee
    public function getSafariEntryFeePriceList($safariId)
    {
        $safariEntryFee = \App\Safari\SafariEntryFee::where('safari_id', $safariId)->orderBy('id', 'desc')->get()->toArray();
        if(count($safariEntryFee) > 0){
            return $safariEntryFee;
        }else{
            return false;
        }
    }

    // function for get transportation fee
    public function getSafariTransportatiionFeePriceList($safariId, $transportationId){

        $safariTransportationFees = \App\Safari\SafariTransportationPrice::where('safari_id', $safariId)
            ->where('transportation_id', $transportationId)
            ->orderBy('id','desc')
            ->limit(1)
            ->get()->toArray();
        $retutnArray = array();
        if (count($safariTransportationFees) > 0){
            $retutnArray['status'] = "success";
            $retutnArray['data'] = $safariTransportationFees[0];
        }else{
            $retutnArray['status'] = "false";
        }
        return $retutnArray;
    }

    // function for getting individual prices for the transportation based on age
    public function getTransportationPrice($safariTransportationFees,$nationality,$age){
        switch ($nationality){
            case 0 :
                if($age < 12){
                    return $safariTransportationFees['child_price_india'];
                }else{
                    return $safariTransportationFees['adult_price_india'];
                }
                break;
            case 1:
                if($age < 12){
                    return $safariTransportationFees['child_price_foreign'];
                }else{
                    return $safariTransportationFees['adult_price_foreign'];
                }
                break;
            default :
                return 0;
        }

    }

    public function calEntryFee($safariEntryFee, $nationality, $age)
    {
        if (count($safariEntryFee) > 0) {
            $safariEntryFee = $safariEntryFee[0];
            switch ($nationality){
                case 0 :
                    if($age < 12){
                        return $safariEntryFee['child_price_india'];
                    }else{
                        return $safariEntryFee['adult_price_india'];
                    }
                    break;
                case 1:
                    if($age < 12){
                        return $safariEntryFee['child_price_foreign'];
                    }else{
                        return $safariEntryFee['adult_price_foreign'];
                    }
                    break;
                default :
                    return 0;
            }
        }else{
            return 0;
        }
    }
}

