<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class BirdSanctuaryController extends Controller
{
    public function index()
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $birdSanctuaryList = \App\BirdSanctuary\birdSanctuary::all()->toArray();
            // redirecting to homepage front end view page
            return view('birdSanctuary/homepage',['birdSanctuaryList'=>$birdSanctuaryList]);
        } catch (Exception $e) {
            return redirect()->route('home');
        }
    }

    public function getBirdSanctuaryDetails(Request $request, $birdSanctuaryId, $birdSanctuaryName)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

            $birdSanctuaryDetail = \App\BirdSanctuary\birdSanctuary::where('id',$birdSanctuaryId)->get()->toArray();
            // $birdSanctuaryBoatType = \App\BirdSanctuary\boatType::where('birdSanctuary_id',$birdSanctuaryId)->get()->toArray();
            // $birdSanctuaryTimeSlots = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('birdSanctuary_id',$birdSanctuaryId)->get()->toArray();

            // foreach ($birdSanctuaryTimeSlots as $index => $timeSlots) {
            //     $getTimeSlots = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id',$timeSlots['timeslots_id'])->get()->toArray();

            //     $birdSanctuaryTimeSlots[$index]['timeslots'] = $getTimeSlots[0]['timeslots'];
            // }
            // // get the images of the birdSanctuary
            $birdSanctuaryImages = \App\BirdSanctuary\birdSanctuaryImages::where('birdSanctuary_id', $birdSanctuaryId)->get()->toArray();
            $birdSanctuaryDetail[0]['birdSanctuaryImages'] = $birdSanctuaryImages;

            // echo "<pre>"; print_r($birdSanctuaryDetail);exit();
            return view('birdSanctuary/birdSanctuaryDetail', ['birdSanctuaryDetail'=> $birdSanctuaryDetail[0], 'birdSanctuaryId' => $birdSanctuaryId, 'birdSanctuaryName' => $birdSanctuaryName, 'birdSanctuaryImages' => $birdSanctuaryImages]);
        } catch (Exception $e) {
            return redirect()->route('homepage');
        }
    }

    public function entryDetails(Request $request,$birdSanctuaryId, $birdSanctuaryName)
    {
        if ($request->session()->get('userId')){

            $getCheckDate = explode(" ", $_POST['start']);
            $checkDate = $getCheckDate[0];


            //Get the Entrance pricing
            $entryFee = [];
            $boatingPricing = [];

            $getEntryPricing = \App\BirdSanctuary\birdSanctuaryPrice::join('birdSanctuaryPricingMasters', 'birdSanctuaryEntryFee.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')->
                where('birdSanctuary_id', $birdSanctuaryId)->where('from_date','<=', $checkDate)->where('to_date','>=', $checkDate)->where('isActive', 1)->select('birdSanctuaryPricingMasters.name', 'birdSanctuaryPricingMasters.backend_key', 'birdSanctuaryEntryFee.*')->get()->toArray();

            if ($getEntryPricing) {
                
                //Get the boating pricing 
                $birdSanctuaryDetail = \App\BirdSanctuary\birdSanctuary::where('id',$birdSanctuaryId)->get()->toArray();

                $boatingTypes = json_decode($birdSanctuaryDetail[0]['boat_types']);
                $hasBoating = false;

                \DB::enableQueryLog();
                //Get the pricing for each boating types
                $boatings = [];
                foreach ($boatingTypes as $key => $boatingType) {
                    $getBoatingPricing =  \App\BirdSanctuary\boatTypePrice::leftJoin('birdSanctuaryBoatType', 'birdSanctuaryBoatType.id','=','birdSanctuaryBoatTypePrice.boatType_id')
                            ->join('birdSanctuaryPricingMasters', 'birdSanctuaryBoatTypePrice.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                            ->where('birdSanctuary_id', $birdSanctuaryId)
                            ->where('from_date','<=', $checkDate)
                            ->where('to_date','>=', $checkDate)
                            ->where('boatType_id' , $boatingType)
                            ->where('birdSanctuaryBoatTypePrice.isActive', 1)
                            ->orderBy('birdSanctuaryBoatTypePrice.pricing_master_id')
                            ->select('birdSanctuaryBoatTypePrice.*', 'birdSanctuaryBoatType.name as boat_name','birdSanctuaryBoatType.full_booking','birdSanctuaryBoatType.shortDesc', 'birdSanctuaryPricingMasters.name', 'birdSanctuaryPricingMasters.backend_key')
                            ->get()->toArray();

                    if($getBoatingPricing){
                        $hasBoating = true;

                        foreach ($getBoatingPricing as $key => $value2) {
                            $boatings[$value2['boat_name']][] = $value2;
                        }
                    }
                    // echo dd(\DB::getQueryLog());
                    // print_r($getBoatingPricing);
                }

                //Get the camera type.
                $cameraTypes = json_decode($birdSanctuaryDetail[0]['camera_types']);
                $hasCameraTypes = false;

                $camers = [];
                foreach ($cameraTypes as $key => $cameraType) {
                    $getCameraPricing =  \App\BirdSanctuary\cameraFee::where('birdSanctuary_id', $birdSanctuaryId)
                            ->leftJoin('birdSanctuaryCameraType', 'birdSanctuaryCameraType.id','=','birdSanctuaryCameraFee.cameratype_id')
                            ->where('cameratype_id' , $cameraType)
                            ->where('birdSanctuaryCameraFee.isActive', 1)
                            ->orderBy('id', 'desc')
                            ->select('birdSanctuaryCameraFee.*', 'birdSanctuaryCameraType.type')
                            ->first();


                    if($getCameraPricing){
                        $getCameraPricing = $getCameraPricing->toArray();
                        
                        $hasCameraTypes = true;
                        $camers[] = $getCameraPricing;
                    }
                    // echo dd(\DB::getQueryLog());
                    // print_r($getBoatingPricing);
                }



                $displayData['birdSanctuaryLogo'] = $birdSanctuaryDetail[0]['logo'];
                $displayData['travelDate'] = $_POST['start'];
                $displayData['birdSanctuaryName'] = $birdSanctuaryName;

                session(['bookingData' => $displayData]);
                // $hasBoating = false;
                // echo "<pre>"; print_r($getEntryPricing);exit();

                return view('birdSanctuary/visitorsDetails-new', ['displayData' => $displayData, 'entryPricing' => $getEntryPricing, 'boatings' => $boatings, 'hasBoating' => $hasBoating, 'hasCameraTypes' => $hasCameraTypes, 'camers' => $camers]);

            }else{
                Session::flash('safariErrMessage', 'Sorry there is some problem in processing the request. Please contact our support team.'); 
                Session::flash('alert-class', 'alert-info');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
            // print_r($getEntryPricing);exit();
        }else{
            Session::flash('message', 'Please login to continue booking.'); 
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function timeSlots(Request $request,$boatTypeId, $birdSanctuaryId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $birdSanctuaryTimeSlots = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('birdSanctuary_id',$birdSanctuaryId)
                                                                                        ->where('boatType_id',$boatTypeId)
                                                                                        ->get()->toArray();

            foreach ($birdSanctuaryTimeSlots as $index => $timeSlots) {
                $getTimeSlots = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id',$timeSlots['timeslots_id'])->get()->toArray();

                $birdSanctuaryTimeSlots[$index]['timeslots'] = $getTimeSlots[0]['timeslots'];
            }
           
            // set safariDetail url to session (to avoid loading  _previous url)
            $data =  session()->get('_previous');
            session(['birdSanctuaryDetailURL'=> $data['url']]);

            return view('birdSanctuary/dynamicTimeSlots', ['birdSanctuaryTimeSlots'=>$birdSanctuaryTimeSlots]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('birdSanctuary/birdSanctuaryDetail'));
        }
    }

    public function getParkingTypeDetails(Request $request, $birdSanctuaryId, $parkingTypeId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $parkingFeeDetails = \App\BirdSanctuary\parkingFee::where('birdSanctuary_id',$birdSanctuaryId)->
                                                                where('parkingtype_id',$parkingTypeId)->get()->toArray();

            foreach ($parkingFeeDetails as $index => $parkingFee) {
                $parkingVehicleTypeDetails = \App\BirdSanctuary\parkingVehicleType::where('birdSanctuary_id',$birdSanctuaryId)
                                                                                    ->where('id',$parkingFee['vehicletype_id'])
                                                                                    ->get()->toArray();     

                $parkingFeeDetails[$index]['parkingVehicleTypeId'] = $parkingVehicleTypeDetails[0]['id'];
                $parkingFeeDetails[$index]['parkingVehicleTypeName'] = $parkingVehicleTypeDetails[0]['type'];
            }

            // set safariDetail url to session (to avoid loading  _previous url)
            $data =  session()->get('_previous');
            session(['birdSanctuaryDetailURL'=> $data['url']]);

            return view('birdSanctuary/dynamicVehicleTypes', ['parkingFeeDetails'=>$parkingFeeDetails]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('birdSanctuary/birdSanctuaryDetail'));
        }
    }

    public function checkAvailability(Request $request,$birdSanctuaryId, $birdSanctuaryName)
    {
        //echo "<pre>";
        $sessionData = session()->all();
        $expoldeTimeslot = explode("##", $_POST['timeslots']);
        $timeslotId = $expoldeTimeslot[0];
        $timeslots = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id',$timeslotId)->get()->toArray();
        $timeslotValue = $timeslots[0]['timeslots'];

        $parkingTypeDetails = \App\BirdSanctuary\parkingType::where('birdSanctuary_id',$birdSanctuaryId)->get()->toArray();
        $parkingVehicleTypeDetails = \App\BirdSanctuary\parkingVehicleType::where('birdSanctuary_id',$birdSanctuaryId)->get()->toArray();

        $cameraTypeDetails = \App\BirdSanctuary\cameraType::where('birdSanctuary_id',$birdSanctuaryId)->get()->toArray();

        foreach ($cameraTypeDetails as $index => $cameraTypes) {
            $cameraFee = \App\BirdSanctuary\cameraFee::where('birdSanctuary_id',$birdSanctuaryId)
                                                      ->where('cameratype_id',$cameraTypes['id'])
                                                      ->get()->toArray();
            $cameraTypeDetails[$index]['cameratypeId'] = $cameraFee[0]['cameratype_id'];
            $cameraTypeDetails[$index]['cameraFee'] = $cameraFee[0]['price'];                                              
        }
       
        $boatTypePrice = \App\BirdSanctuary\boatTypePrice::where('birdSanctuary_id',$birdSanctuaryId)
                                                               ->where('boatType_id',$_POST['boatType'])
                                                               ->get()->toArray();
        $boatType = \App\BirdSanctuary\boatType::where('id',$boatTypePrice[0]['boatType_id'])->get()->toArray();
      
        if ($request->session()->get('userId')) {
        
            $data = $_POST;
            $boatTypeId = $boatType[0]['id'];
            $boatType = $boatType[0]['name'];

            $getCheckDate = explode(" ", $data['start']);
            $checkDate = $getCheckDate[0];
           
            if($checkDate != date("Y-m-d")) {
                if ($data['noOfSeats'] == '4+') {
                    $checkbirdSanctuarySeats = $data['noOfSeats2'];
                }else{
                    $checkbirdSanctuarySeats = $data['noOfSeats'];
                }

                $birdSanctuaryLogo = \App\BirdSanctuary\birdSanctuary::select('logo')->where('id',$birdSanctuaryId)->get()->toArray();
              
                if($boatTypePrice[0]['full_booking'] == 0){
                    $maxSeats = 150;
                    $seats = 0;
                    $bookedSeats = \App\BirdSanctuary\birdSanctuaryBookings::where('birdSanctuary_id',$birdSanctuaryId)
                                                                            ->where('checkIn',$data['start'])
                                                                            ->where('boatType_id',$boatTypeId)
                                                                            ->where('timeslot',$timeslotId)
                                                                            ->where('booking_status','Success')
                                                                            ->get()->toArray();
                    foreach ($bookedSeats as $index => $value) {
                        $seats += $value['no_of_seats'];
                    }
                    $availableSeats = $maxSeats - $seats;
                    if($checkbirdSanctuarySeats > $availableSeats){
                        Session::flash('valMessage', 'Sorry only '.$availableSeats.' seats are available for the timeslot !!!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route("getBirdSanctuaryDetails",[$birdSanctuaryId,$birdSanctuaryName]);  
                    }
                }
                
                $sendData = [];
                $sendData['birdSanctuaryId'] = $birdSanctuaryId;
                $sendData['birdSanctuaryName'] = $birdSanctuaryName;
                $sendData['birdSanctuaryLogo'] = $birdSanctuaryLogo[0]['logo'];
                $sendData['timeslotId'] = $timeslotId;
                $sendData['timeslotValue'] = $timeslotValue;
                $sendData['requestedSeats'] = $checkbirdSanctuarySeats;
                $sendData['boatType'] = $boatType;
                $sendData['boatTypeId'] = $boatTypeId;
                $sendData['boatTypePrice'] = $boatTypePrice;
                $sendData['travelDate'] = $data['start'];
                $sendData['parkingTypeDetails'] = $parkingTypeDetails;
                $sendData['parkingVehicleTypeDetails'] = $parkingVehicleTypeDetails;
                $sendData['cameraTypeDetails'] = $cameraTypeDetails;

                session(['bookingData' => $sendData]);



                return redirect()->route("birdSanctuaryVistiorsDetails");
            }else{
                    Session::flash('valMessage', 'Sorry bookings are closed for today!!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route("getBirdSanctuaryDetails",[$birdSanctuaryId,$birdSanctuaryName]);
                }
        }else{
                Session::flash('message', 'Please login to continue booking.');
                Session::flash('alert-class', 'alert-danger');
                if(isset($sessionData['birdSanctuaryDetailURL'])){
                    return \Redirect::to($sessionData['birdSanctuaryDetailURL']);
                }
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
             }
    }

    // function for sending visitorDetails to view file
    public function birdSanctuaryVistiorsDetails(Request $request)
    {
        if ($request->session()->get('bookingData')) {
            $displayData = $request->session()->get('bookingData');

            // Cal to the grand total amount.
            $totalAmount = $displayData['requestedSeats'];// * $displayData['perHead'];

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
            
            return view('birdSanctuary/visitorsDetails', ['displayData'=> $displayData]);
        }else{
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function confirmBirdSanctuaryBooking(Request $request)
    {
        // echo "<pre>"; print_r($_POST);exit();
        $fullSecssiondata = session()->all();
        if ($request->session()->get('userId')) {
            try{
                $sessionData = $request->session()->get('bookingData');
                $cameraAmount = 0;
                $parkingAmount = 0;
                $totalEntryFee = 0;
                $birdSanctuaryFee = 0;

                if(!empty($_POST['vehicleType'])){
                    $parkingAmount = array();
                    $vehicleTypeId = array();
                    $vehicleType = array();
                    $vehicleType = $_POST['vehicleType'];
                      foreach ($vehicleType as $index => $value) {
                        $vehicleType = explode("-",$value);
                        $vehicleCount = $_POST['noOfvehicles'][$index];
                        $vehicleTypeId[] = $vehicleType['1'];
                        $parkingAmount[] = $vehicleCount * $vehicleType['2'];
                    }
                    $vehicleTypeId = implode(',', $vehicleTypeId);
                    $parkingAmount = array_sum($parkingAmount);  
                }
              
                if(!empty($_POST['cameraType'])){
                    $cameraAmount = array();
                    $cameraTypeId = array();
                    $cameraType = array();
                    $cameraType = $_POST['cameraType'];
                      foreach ($cameraType as $index => $value) {
                        $cameraType = explode("-",$value);
                        $cameraCount = $_POST['noOfcameras'][$index];
                        $cameraTypeId[] = $cameraType['1'];
                        $cameraAmount[] = $cameraCount * $cameraType['2'];
                    }
                    $cameraTypeId = implode(',', $cameraTypeId);
                    $cameraAmount = array_sum($cameraAmount);  
                }
                
                $addOn_details = array();
                $vehicleDetails = '["Vehicle :'.$_POST['vehicleName'].'",'.'"Count :'.array_sum($_POST['noOfvehicles']).'",'.'"Amount :'.$parkingAmount.'"]';
                $cameraDetails = '["Vehicle :'.$_POST['cameraName'].'",'.'"Count :'.array_sum($_POST['noOfcameras']).'",'.'"Amount :'.$cameraAmount.'"]';
                
                $addOn_details['parkingDetails'] = $vehicleDetails;
                $addOn_details['cameraDetails'] = $cameraDetails;
                
                $birdSanctuaryEntryFee = \App\BirdSanctuary\birdSanctuaryPrice::where('birdSanctuary_id',$sessionData['birdSanctuaryId'])->get()->toArray();

                $boatTypePrice = $sessionData['boatTypePrice'];

                $boatTypeId = $sessionData['boatTypeId'];
               
                if($boatTypePrice[0]['full_booking'] == 1){
                    foreach ($_POST['detail'] as $visitors){
                        $visitorType = 0;
                        
                        if (isset($visitors['visitorType'])) {
                            // Foreigner passenger
                            $visitorType = 1;
                            $isForeigner = 1;
                        }
                        $birdSanctuaryFee += $this->calEntryFee($birdSanctuaryEntryFee,$visitorType, $visitors['age']);
                    }
                    
                    if(isset($isForeigner)){
                       $visitorType = 1; 
                       $totalEntryFee = $this->getFullBoatTypePrice($boatTypePrice, $visitorType);
                    }else{
                        $totalEntryFee = $this->getFullBoatTypePrice($boatTypePrice, $visitorType);
                    }

                }else{
                    foreach ($_POST['detail'] as $visitors){
                        $visitorType = 0;
                        if (isset($visitors['visitorType'])) {
                            // Foreigner passenger
                            $visitorType = 1;
                        }
                        $totalEntryFee += $this->getNormalBoatTypePrice($boatTypePrice, $visitorType, $visitors['age']);
                        $birdSanctuaryFee += $this->calEntryFee($birdSanctuaryEntryFee,$visitorType, $visitors['age']);
                    }
                }

                $totalAmount = $birdSanctuaryFee + $totalEntryFee + $parkingAmount + $cameraAmount;

                // Internet handling charge
                $internetHandlingPercentage = \Config::get('common.internetHandlingCharge');
                $internetHandling = ($internetHandlingPercentage / 100) * $totalAmount;

                // Payment gateway
                $paymentGatewayPercentage = \Config::get('common.paymentGatewayCharge');
                $paymentGateway = ($paymentGatewayPercentage / 100) * $totalAmount;

                $displayData['birdSanctuaryEntryFee'] = $birdSanctuaryFee;
                $displayData['boatingFee'] = $totalEntryFee;
                $displayData['parkingFee'] = $parkingAmount;
                $displayData['cameraCharges'] = $cameraAmount;
                $displayData['serviceCharges'] = $internetHandling + $paymentGateway;
                $displayData['totalPayable'] = $totalAmount + $internetHandling + $paymentGateway;
                
               return view('birdSanctuary/confirmBooking', ['postData'=> $_POST, 'addOn_details'=>$addOn_details,'feeDetails' => $displayData, 'displayData' => $sessionData]);
              
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

    public function calEntryFee($birdSanctuaryEntryFee, $nationality, $age)
    {
        if (count($birdSanctuaryEntryFee) > 0) {
            $birdSanctuaryEntryFee = $birdSanctuaryEntryFee[0];
            switch ($nationality){
                case 0 :
                    if($age <= 12){
                        return $birdSanctuaryEntryFee['child_price_india'];
                    }else{
                        return $birdSanctuaryEntryFee['adult_price_india'];
                    }
                    break;
                case 1:
                    if($age <= 12){
                        return $birdSanctuaryEntryFee['child_price_foreign'];
                    }else{
                        return $birdSanctuaryEntryFee['adult_price_foreign'];
                    }
                    break;
                default :
                    return 0;
            }
        }else{
            return 0;
        }
    }

    public function getFullBoatTypePrice($boatTypePrice,$nationality){
        if (count($boatTypePrice) > 0) {
            $boatTypePrice = $boatTypePrice[0];
                switch ($nationality){
                    case '0':
                            return $boatTypePrice['price_india'];
                        break;

                    case '1':
                            return $boatTypePrice['price_foreign'];
                        break;

                    default :
                        return 0;
            }
        }
    }

    public function getNormalBoatTypePrice($boatTypePrice,$nationality,$age){
        if (count($boatTypePrice) > 0) {
            $boatTypePrice = $boatTypePrice[0];
            
                switch ($nationality){
                    case '0':
                        if($age <= 12){
                            return $boatTypePrice['child_price_india'];
                        }
                        else if($age > 12){
                            return $boatTypePrice['adult_price_india'];
                        }
                        break;

                    case '1':
                        if($age <= 12){
                            return $boatTypePrice['child_price_foreign'];
                        }
                        else if($age > 12){
                            return $boatTypePrice['adult_price_foreign'];
                        }
                        break;

                    default :
                        return 0;
            }
        }
    }

    public function initiateBooking(Request $request)
    {
        $_POST['detail'] = json_decode($_POST['detail'], true);
        $_POST['feeDetails'] = json_decode($_POST['feeDetails'], true);

        $sessionData = $request->session()->get('bookingData');
        //echo "<pre>"; print_r($_POST);print_r($sessionData);exit;
        
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
                        
                        $totalseatscount = $sessionData['requestedSeats'];

                        $bookingInit = array();
                        $bookingInit['display_id'] = $displayId;
                        $bookingInit['birdSanctuary_id'] = $sessionData['birdSanctuaryId'];
                        $bookingInit['user_id'] = $userId;
                        $bookingInit['boatType_id'] = $sessionData['boatTypeId'];
                        $bookingInit['date_of_booking'] = date("Y-m-d H:i:s");
                        $bookingInit['checkIn'] = $sessionData['travelDate'] ;
                        $bookingInit['no_of_seats'] = $totalseatscount;
                        $bookingInit['amount'] = $_POST['feeDetails']['birdSanctuaryEntryFee'] ;
                        $bookingInit['parkingFee'] = $_POST['feeDetails']['parkingFee'] ;
                        $bookingInit['cameraCharges'] = $_POST['feeDetails']['cameraCharges'] ;
                        $bookingInit['amount_with_tax'] = $_POST['feeDetails']['totalPayable'];
                        $bookingInit['park_entry_amount'] = $_POST['feeDetails']['boatingFee'];
                        $bookingInit['service_charge'] = $_POST['feeDetails']['serviceCharges'];
                        $bookingInit['timeslot'] = $sessionData['timeslotId'];
                        $bookingInit['booking_status'] = 'Waiting';
                        $bookingInit['visitors_details'] = json_encode($_POST['detail']);
                        $bookingInit['addOn_details'] = $_POST['addOn_details'];
                        
                        $placeOrder = \App\BirdSanctuary\birdSanctuaryBookings::create($bookingInit);
                        $bookingId = $placeOrder->id;

                        // Payment data
                        $redirectUrl = url('/') . '/birdSanctuary/responseReceiver';

                        $paymentData = [];
                        $paymentData['order_id'] = $bookingId;
                        $paymentData['userId'] = $userId;
                        $paymentData['amount'] = $_POST['feeDetails']['totalPayable'];
                        $paymentData['redirect_url'] = $redirectUrl;
                        $paymentData['cancel_url'] = $redirectUrl;
                        $paymentData['merchant_param1'] = $bookingId;

                        $data = $this->initPaymentTran($paymentData);
                        if ($data == 0) {
                            return \Redirect::to(url('/') . '/birdSanctuary');
                        } else {
                            return view('payment/requestHandler', ['data' => $data]);
                        }
                }else{
                    return \Redirect::to(url('/').'/birdSanctuary');
                }
            }else{
                return \Redirect::to(url('/').'/birdSanctuary');
            }
        }else{
            Session::flash('TranErrMessage', 'Available seats are being booked!! Please checks seats available and book faster.');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('/').'/birdSanctuary');
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

        $updateRow = \App\BirdSanctuary\birdSanctuaryBookings::where('id',$orderId)->update($updateContent);

        if ($orderStatus == 'Success') {

            // Send a mail to user account
            if ($userEmail != '') {
                // $orderId = 1;
                $bookingData = \App\BirdSanctuary\birdSanctuaryBookings::where('id',$orderId)->get()->toArray();
                $birdSanctuaryData = \App\BirdSanctuary\birdSanctuary::where('id',$bookingData[0]['birdSanctuary_id'])->get()->toArray();
                
                $boatDetail = \App\BirdSanctuary\boatType::where('id',$bookingData[0]['boatType_id'])->get()->toArray();
                $timeslotDetail = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id',$bookingData[0]['timeslot'])->get()->toArray();
                $visitorsDetails = json_decode($bookingData[0]['visitors_details'], true);

                $birdSanctuaryDetail['type'] = $boatDetail[0]['name'] ;
                $birdSanctuaryDetail['timeSlotName'] = $timeslotDetail[0]['timeslots'];
                $birdSanctuaryDetail['visitorsDetails'] = $visitorsDetails;
                
                return  \View::make('payment.birdSanctuaryMailTemplate', ['bookingData' => $bookingData[0],'birdSanctuaryData'=>$birdSanctuaryData[0],'birdSanctuaryDetail'=>$birdSanctuaryDetail]);

                $message = \View::make('payment.birdSanctuaryMailTemplate', ['bookingData' => $bookingData[0],'birdSanctuaryData'=>$birdSanctuaryData[0],'birdSanctuaryDetail'=>$birdSanctuaryDetail]);

                $subject = "Myecotrip - BirdSanctuary booking confirmation";
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

