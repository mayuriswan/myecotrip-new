<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class TrailController extends Controller
{

    public function getTrails(Request $request,$landscapeId, $landscapeName)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {



            $keysNeeded = [ "id","landscape_id", "park_id", "name","seo_url", "max_trekkers", "distance", "distance_unit", "hours", "minutes", "type", "description", "logo", "status",'display_price'];

            $landscapelist = \App\Landscape::where('id',$landscapeId)
                            ->get()
                            ->toArray()[0];

            $trailslist = \App\Trail::where('landscape_id',$landscapeId)
                        ->where('status', '1')
                        ->select($keysNeeded)
                        ->orderBy('display_order_no')
                        ->get()
                        ->toArray();

            session(['trailsList' => url('/')."/trails/$landscapeId/$landscapeName"]);
            session(['trailsListName' => $landscapelist['name']]);

            // echo "<pre>"; print_r($landscapelist);exit();

            return view('ecotrails/trails', ['trailslist'=> $trailslist, 'landscapelist' => $landscapelist]);
        } catch (Exception $e) {
            return redirect()->route('landscapes');
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

    public function getPricePerPerson($priceList)
    {
        $priceList = json_decode($priceList, true);

        $pricePerPerson = 0;
        $pricePerChild = 0;

        $keysNeeded = ['TAC','guide_fee','entry_fee'];
        $childKeysNeeded = ['TAC_child','guide_fee_child','entry_fee_child'];

        foreach ($keysNeeded as $key => $priceType) {
            $pricePerPerson += $priceList['India']['adult'][$priceType];
        }

        foreach ($childKeysNeeded as $key => $priceType) {
            $pricePerChild += $priceList['India']['child'][$priceType];
        }


        return $pricePerPerson;
    }

    public function getFilteredTrails(Request $request)
    {
        $keysNeeded = [ "id","landscape_id", "park_id", "name", "max_trekkers", "distance", "distance_unit", "hours", "minutes", "type", "description", "logo", "status"];

        $where = "distance != ''";
        // Distance filter
        if (isset($_POST['trekDistance'])) {
            if ($_POST['trekDistance'] == 'any') {
                $where = "distance >= 4";
            }else{
                $gerRange = explode("-", $_POST['trekDistance']);
                $start = $gerRange[0];
                $end = $gerRange[1];

                $where = "distance >= ".$start;
                $where .= " AND distance <= ".$end;
            }
        }

        $trailslist = \App\Trail::whereRaw($where)
                        ->where('status', 1)
                        ->where('landscape_id', $_POST['landscapeId'])
                        ->select(\DB::raw('trails.hours*60+trails.minutes AS hoursInMin , trails.*'))
                        ->get()
                        ->toArray();

        // echo "<pre>"; print_r($trailslist);exit;
        foreach ($trailslist as $index => $trail) {
            try{
                $getThePriceList = \App\TrailPricing::where('trail_id', $trail['id'])->orderBy('id', 'desc')->first()->toArray();

                if (count($getThePriceList) > 0) {
                    $pricePerPerson = $this->getPricePerPerson($getThePriceList['price']);
                }else{
                    $pricePerPerson = 0;
                }
            }catch(\Error $e){
                $pricePerPerson = 0;
            }

            $trailslist[$index]['pricePerPerson'] = $pricePerPerson;
        }

        if ($_POST['fromNumber'] != '' || $_POST['toNumber'] != '') {
            $priceOutput = array();
            //get the pricing
            foreach ($trailslist as $key => $value) {
                if ($value['pricePerPerson'] >= $_POST['fromNumber'] && $value['pricePerPerson'] <= $_POST
                    ['toNumber']) {
                    $priceOutput[] = $value;
                }
            }

            $trailslist = $priceOutput;
        }

        // Duration filter
        if(isset($_POST['trekTime'])) {
            $outPut = array();

            if ($_POST['trekTime'] == 'any') {
                $hours = 3 * 60;
                foreach ($trailslist as $index => $trail) {
                    if ($trail['hoursInMin'] >= $hours) {
                        $outPut[] = $trailslist[$index];
                    }
                }
            }else{
                $hours = $_POST['trekTime'] * 60 ;
                foreach ($trailslist as $index => $trail) {
                    if ($trail['hoursInMin'] <= $hours) {
                        $outPut[] = $trailslist[$index];
                    }
                }
            }

            $trailslist = $outPut;
            }

            $landscapelist = \App\Landscape::where('id',$_POST['landscapeId'])
                            ->get()
                            ->toArray()[0];


        // echo "<pre>";print_r($_POST);print_r($trailslist);exit();
        return view('ecotrails/trails', ['trailslist'=> $trailslist, 'landscapelist' => $landscapelist,'filters' => $_POST]);
    }

    public function calanderData($trailDetail)
    {
        $trailId = $trailDetail[0]['id'];
        $maxList = [];
        $bookedList = [];
        $hasExtraDays = 0;
        $nextDay = 0;

        $currentTime = time() + 3600;

        if (((int) date('H', $currentTime)) >= 12) {
          $nextDay = 1;
        }

        if($trailDetail[0]['max_weekend_trekkers'] > 0){
            $hasExtraDays = 1;
        }

        if ($nextDay) {
            $checkDate = date("Y-m-d", strtotime("+1 day"));
        }else{
            $checkDate = date("Y-m-d");
        }

        $checkAvailability = \App\TrailBooking::
                whereDate('checkIn', '>=', $checkDate)
                    ->where('trail_id', $trailId)
                    ->where(function ($query) {
                        $query->where('booking_status', '=', 'Success')
                            ->OrWhere('booking_status', '=', 'Waiting');
                    })
                    ->select(\DB::raw('SUM(total_trekkers) as booked'), 'checkIn')
                    ->groupBy('checkIn')
                    ->get()
                    ->toArray();

        foreach ($checkAvailability as $key => $value) {
            $bookedList[$value['checkIn']] = $value['booked'];
        }
        // echo "<pre>";print_r($bookedList);exit;

        //Current Month

        if ($nextDay) {
            $day = date("d", strtotime("+1 day"));
        }else{
            $day = date("d");
        }

        $year = date("Y");
        $month = date("m");
        $monthDates = $this->daysOfMonth($month, $year, $day);
        $appendArray = array_fill_keys($monthDates, $trailDetail[0]['max_trekkers']);

        if ($hasExtraDays) {
            //Get holiday list
            $getList = \App\Holiday::where('year', $year)->orderBy('id', 'DESC')->get()->toArray();

            if (count($getList)) {
                $holidays = json_decode($getList[0]['dates'], true);

                foreach ($holidays as $key => $value) {
                    if (isset($appendArray[$value])) {
                        $appendArray[$value] = $trailDetail[0]['max_weekend_trekkers'];
                    }
                }
            }

            //Check for weekends
            foreach ($appendArray as $key => $value) {
                $get_name = date('l', strtotime($key)); //get week day

                //if not a weekend add day to array
                if($get_name == 'Sunday' || $get_name == 'Saturday'){
                    $appendArray[$key] = $trailDetail[0]['max_weekend_trekkers'];
                }
            }

        }

        $maxList = array_merge($maxList, $appendArray);

        //Current Month + 1
        $year = date('Y',strtotime("+1 month"));
        $month = date('m',strtotime('first day of +1 month'));
        $monthDates = $this->daysOfMonth($month, $year);
        $appendArray = array_fill_keys($monthDates, $trailDetail[0]['max_trekkers']);

        if ($hasExtraDays) {
            //Get holiday list
            $getList = \App\Holiday::where('year', $year)->orderBy('id', 'DESC')->get()->toArray();

            if (count($getList)) {
                $holidays = json_decode($getList[0]['dates'], true);

                foreach ($holidays as $key => $value) {
                    if (isset($appendArray[$value])) {
                        $appendArray[$value] = $trailDetail[0]['max_weekend_trekkers'];
                    }
                }
            }

            //Check for weekends
            foreach ($appendArray as $key => $value) {
                $get_name = date('l', strtotime($key)); //get week day

                //if not a weekend add day to array
                if($get_name == 'Sunday' || $get_name == 'Saturday'){
                    $appendArray[$key] = $trailDetail[0]['max_weekend_trekkers'];
                }
            }
        }

        // array_push($maxList, $appendArray);
        $maxList =  array_merge($maxList, $appendArray);
        // echo "<pre>";print_r($maxList);exit;


        //Current Month + 2
        $year = date('Y',strtotime("+2 month"));
        $month = date('m',strtotime("+2 month"));
        $monthDates = $this->daysOfMonth($month, $year);
        $appendArray = array_fill_keys($monthDates, $trailDetail[0]['max_trekkers']);

        if ($hasExtraDays) {
            //Get holiday list
            $getList = \App\Holiday::where('year', $year)->orderBy('id', 'DESC')->get()->toArray();

            if (count($getList)) {
                $holidays = json_decode($getList[0]['dates'], true);

                foreach ($holidays as $key => $value) {
                    if (isset($appendArray[$value])) {
                        $appendArray[$value] = $trailDetail[0]['max_weekend_trekkers'];
                    }
                }
            }

            //Check for weekends
            foreach ($appendArray as $key => $value) {
                $get_name = date('l', strtotime($key)); //get week day

                //if not a weekend add day to array
                if($get_name == 'Sunday' || $get_name == 'Saturday'){
                    $appendArray[$key] = $trailDetail[0]['max_weekend_trekkers'];
                }
            }
        }

        $maxList =  array_merge($maxList, $appendArray);

        $returnArray['maxList'] = $maxList;
        $returnArray['bookedList'] = $bookedList;

        return $returnArray;
    }

    public function getTrailDetails(Request $request, $trailId, $trailName)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $getTimeSlots = [];

        try {

            $trailDetail = \App\Trail::where('id',$trailId)
                        ->get()
                        ->toArray();


            $getTimeSlots = \App\TrailEntryFee::join('trail_timeslots', 'trail_timeslots.id','trail_entry_fee.timeslot_id')
                    ->where('trail_id', $trailId)
                    ->where('version', $trailDetail[0]['entrance_fee_version'])
                    ->select(\DB::raw('DISTINCT(timeslot_id)'),'trail_timeslots.timeslots')
                    ->groupBy('trail_entry_fee.timeslot_id')
                    ->get()
                    ->toArray();


            //get the pricing by slots wise
            foreach ($trailDetail as $index => $trail) {
                // $getTimeSlots = \App\TrailPricing::join('ecotrailTimeSlots', 'ecotrailTimeSlots.id','=','trailPricing.ecotrailTimeSlots_id')
                //     ->select('trailPricing.*', 'ecotrailTimeSlots.timeslots')
                //     ->where('trailPricing.trail_id', $trail['id'])
                //     ->get()
                //     ->toArray();


                // fetch incharger_details
                $fetch = explode(",", $trail['incharger_details']);
                $trailDetail[$index]['incharger_details']   = $fetch;

            }

            // get the images of the trek
            $trekImages = \App\TrailImages::where('trail_id', $trailId)->get()->toArray();

            // foreach ($getTimeSlots as $key => $value) {
            //     $getTimeSlots[$key]['prices'] =  $this->getAdultChildPrice($value['price']);

            // }

            $trailDetail[0]['trailImages'] = $trekImages;


            $calendarData = $this->calanderData($trailDetail);

            // echo "<pre>"; print_r($getTimeSlots);exit();

            return view('ecotrails/trailDetail', ['trailDetail'=> $trailDetail[0], 'trailId' => $trailId, 'trailName' => $trailName, 'timeslots' => $getTimeSlots, 'calendarData' => $calendarData]);
        } catch (Exception $e) {
            // echo "string"; exit;
            return redirect()->route('landscapes');
        }
    }

    function checkAvailability(Request $request, $trailId, $trailName)
    {
        // echo "<pre>"; print_r($_POST);exit();
        // check user login
        if ($request->session()->get('userId')) {

            //Check user has verified his email / phone no
            $userId = $request->session()->get('userId');
            $checkAccountVerification = $this->checkAccountVerification($userId);

            if ($checkAccountVerification) {

                $request->session()->forget('bookingData');
                $request->session()->forget('bookingDatas');

                $data = $_POST;

                //Check number of trekkers

                $requiredFileds = ['noOfTrekkers', 'noOfTrekkers2','noOfChildren','noOfChildren2','noOfStudents','noOfStudents2'];
                $trekkersCount = 0;

                if ($data['noOfTrekkers'] == '4+') {
                    $checkTrekkers = $data['noOfTrekkers2'];
                    $trekkersCount += $data['noOfTrekkers2'];
                } else {
                    $checkTrekkers = $data['noOfTrekkers'];
                    $trekkersCount += $data['noOfTrekkers'];
                }

                if ($data['noOfChildren'] == '4+') {
                    $checkChildren = $data['noOfChildren2'];
                    $trekkersCount += $data['noOfChildren2'];
                } else {
                    $checkChildren = $data['noOfChildren'];
                    $trekkersCount += $data['noOfChildren'];
                }

                if ($data['noOfStudents'] == '4+') {
                    $checkStudent = $data['noOfStudents2'];
                    $trekkersCount += $data['noOfStudents2'];
                } else {
                    $checkStudent = $data['noOfStudents'];
                    $trekkersCount += $data['noOfStudents'];
                }

                if(!$trekkersCount){
                    Session::flash('valMessage', 'Please select number of trekkers');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route("getTrailDetails", [$trailId, $trailName]);
                }

                $getCheckDate = explode(" ", $data['start']);
                $checkDate = $getCheckDate[0];

                // Check users checkin date
                // if($checkDate != date("Y-m-d")){
                if ($data['noOfTrekkers'] == '4+') {
                    $checkTrekkers = $data['noOfTrekkers2'];
                } else {
                    $checkTrekkers = $data['noOfTrekkers'];
                }

                if ($data['noOfChildren'] == '4+') {
                    $checkChildren = $data['noOfChildren2'];
                } else {
                    $checkChildren = $data['noOfChildren'];
                }

                if ($data['noOfStudents'] == '4+') {
                    $checkStudent = $data['noOfStudents2'];
                } else {
                    $checkStudent = $data['noOfStudents'];
                }


                $maxTrekkers = $this->getMaxTrekkers($trailId, $checkDate);

                // echo $maxTrekkers; exit;
                $checkAvailability = \App\TrailBooking::
                whereDate('checkIn', '=', $checkDate)
                    ->where('trail_id', $trailId)
                    ->where(function ($query) {
                        $query->where('booking_status', '=', 'Success')
                            ->OrWhere('booking_status', '=', 'Waiting');
                    })
                    ->selectRaw('sum(total_trekkers) AS bookedTicket')
                    ->get()
                    ->toArray();

                // echo "<pre>";print_r($checkAvailability);exit();
                $availableSeat = $maxTrekkers - $checkAvailability[0]['bookedTicket'];

                if ($availableSeat >= $checkTrekkers + $checkChildren + $checkStudent) {
                    //Get the time slot selected
                    $sliptTimeSlot = explode("||", $data['timeslot']);

                    $sendData = [];
                    $sendData['trailId'] = $trailId;
                    $sendData['trailName'] = $trailName;
                    $sendData['requestedSeats'] = $checkTrekkers;
                    $sendData['requestedChildrenSeats'] = $checkChildren;
                    $sendData['requestedStudentSeats'] = $checkStudent;
                    $sendData['travelDate'] = $data['start'];
                    $sendData['timeslotId'] = $sliptTimeSlot[0];
                    $sendData['timeslot'] = $sliptTimeSlot[1];

                    // echo "<pre>"; print_r($sendData);exit();
                    session(['bookingData' => $sendData]);
                    return redirect()->route("getTrekkersDetails");
                } else {
                    Session::flash('valMessage', 'Sorry only ' . max($availableSeat,0) . ' seats available on ' . $data['start']);
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route("getTrailDetails", [$trailId, $trailName]);
                }
                // }else{
                //     Session::flash('valMessage', 'Sorry bookings are closed for today!!');
                //     Session::flash('alert-class', 'alert-danger');
                //     return redirect()->route("getTrailDetails",[$trailId,$trailName]);
                // }
            }else{
                Session::flash('verifyMessage', 'Please verify your Email or Phone number.');
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

        }else{
            Session::flash('message', 'Please login to continue booking.');
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }


    }

    public function getMaxTrekkers($trailId, $checkIn)
    {
        // get the max treak count of the trail
        $maxCount = \App\Trail::where('id', $trailId)->select('max_trekkers', 'max_weekend_trekkers','logo')
            ->get()
            ->toArray();

        $isHoliday = 0;

        $checkIndate = \DateTime::createFromFormat("Y-m-d", $checkIn);
        $checkInYear = $checkIndate->format("Y");

        //Get holiday list.
        if ($maxCount[0]['max_weekend_trekkers'] > 0) {
            $getDates = \App\Holiday::where('year', $checkInYear)
                        ->where('status', 1)
                        ->orderBy('id', 'DESC')
                        ->get()->toArray();

            if (count($getDates)) {
                $dates = json_decode($getDates[0]['dates'], true);

                if (in_array($checkIn, $dates)) {
                    $isHoliday = 1;
                }
            }

        }

        if (($this->isWeekend($checkIn)  || $isHoliday) && $maxCount[0]['max_weekend_trekkers'] > 0) {
            return $maxTrekkers = $maxCount[0]['max_weekend_trekkers'];
        }else{
            return $maxTrekkers = $maxCount[0]['max_trekkers'];
        }
    }

    public function formatPrice($data)
    {
        $returnData = [];
        foreach ($data as $key => $value) {
            $returnData[$value['pricing_master_id']] = $value['price'];
        }

        return $returnData;
    }

    public function getTrekkersDetails(Request $request)
    {
        // echo "<pre>"; print_r($request->session()->get('bookingData'));exit();
        if ($request->session()->get('bookingData')) {
            $displayData = $request->session()->get('bookingData');

            $trailData = \App\Trail::where('id', $displayData['trailId'])->select('logo','entrance_fee_version')
                        ->get()
                        ->toArray();

            //Get the trail pricing
            $getTrailPricing = \App\TrailEntryFee::where('trail_id',$displayData['trailId'])
                                                   ->where('version', $trailData[0]['entrance_fee_version'])
                                                   ->get()
                                                   ->toArray();

            $getPrice = $this->formatPrice($getTrailPricing);
            // echo "<pre>"; print_r($displayData);exit();


            //Get the pricing for the timeslot
            // $getPricingRow = \App\TrailPricing::where('id', $displayData['timeslotId'])->get()->toArray();
            // $getPrice = $this->getAdultChildPrice($getPricingRow[0]['price']);

            // echo "<pre>"; print_r($getPrice);exit();
            // Cal to the grand total amount.

            $adultPrice = 0;
            if ($displayData['requestedSeats'] > 0 && (!isset($getPrice[1]) && $getPrice[1] <= 0)) {
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            $childPrice = 0;
            if ($displayData['requestedChildrenSeats'] > 0 && (!isset($getPrice[2]) && $getPrice[2] <= 0)) {
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            $studentPrice = 0;
            if ($displayData['requestedStudentSeats'] > 0 && (!isset($getPrice[3]) && $getPrice[3] <= 0)) {
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }


            $adultPrice = $displayData['requestedSeats'] * $getPrice['1'];
            $childPrice = $displayData['requestedChildrenSeats'] * $getPrice['2'];
            $studentPrice = $displayData['requestedStudentSeats'] * $getPrice['3'];

            $totalAmount = $adultPrice + $childPrice + $studentPrice;

            // Internet handling charge
            $internetHandlingPercentage = \Config::get('common.internetHandlingCharge');
            $internetHandling = ($internetHandlingPercentage / 100) * $totalAmount;

            //GST charges
            $gstPercentage = \Config::get('common.gstCharge');
            $gstAmount = ($gstPercentage / 100) * $internetHandling;

            $internetHandling -= $gstAmount;

            $paymentGateway = 0;
            // Payment gateway
            // $paymentGatewayPercentage = \Config::get('common.paymentGatewayCharge');
            // $paymentGateway = ($paymentGatewayPercentage / 100) * ($totalAmount + $internetHandling + $gstAmount);


            $displayData['perHead'] = $getPrice['1'];
            $displayData['perChild'] = $getPrice['2'];
            $displayData['perStudent'] = $getPrice['3'];
            $displayData['total'] = $totalAmount;
            $displayData['gstCharges'] = $gstAmount;
            $displayData['serviceCharges'] = $internetHandling + $paymentGateway;
            $displayData['totalPayable'] = round($totalAmount + $internetHandling + $paymentGateway + $gstAmount, 2);


            $displayData['trailLogo'] = $trailData[0]['logo'];


            session(['bookingData' => $displayData]);


            // echo "<pre>"; print_r($displayData);exit();
            return view('ecotrails/trekkerDetails', ['displayData'=> $displayData]);
        }else{

            // echo "string"; exit;
            $data =  $request->session()->get('_previous');

            return \Redirect::to($data['url']);
        }
    }

    public function confirmAvailability($trailId, $travelDate, $noOfTrekkers)
    {
        $getCheckDate = explode(" ", $travelDate);
        $checkDate = $getCheckDate[0];

        $maxTrekkers = $this->getMaxTrekkers($trailId, $checkDate);

        $checkAvailability = \App\TrailBooking::
                    whereDate('checkIn', '=', $checkDate)
                    ->where('trail_id', $trailId)
                    ->where(function ($query) {
                            $query->where('booking_status', '=', 'Success')
                                  ->OrWhere('booking_status', '=', 'Waiting');
                        })
                    ->selectRaw('sum(total_trekkers) AS bookedTicket')
                    ->get()
                    ->toArray();

        $availableSeat = $maxTrekkers - $checkAvailability[0]['bookedTicket'];

        if ($availableSeat >= $noOfTrekkers) {
            return true;
        }else{
            return false;
        }
    }

    public function initiateBooking(Request $request)
    {
        // echo "<pre>"; print_r($_POST);exit;

        $sessionData = $request->session()->get('bookingData');

        $totalTrekkers  = $sessionData['requestedSeats'] + $sessionData['requestedChildrenSeats'] + $sessionData['requestedStudentSeats'];
        // Reconfirm the seat availability
        $availability = $this->confirmAvailability($sessionData['trailId'], $sessionData['travelDate'], $totalTrekkers);

        if ($availability) {
            // check user login
            if ($request->session()->get('userId')) {
                if (count($sessionData) > 0) {

                    // Generate the display booking id.
                    $digits = 4;
                    $randNo = rand(pow(10, $digits-1), pow(10, $digits)-1);

                    $userId = $request->session()->get('userId');
                    $displayId = date('ymd').$userId. $randNo;

                    // get the trekkers details
                    $trekkerDetails = [];
                    foreach ($_POST['detail'] as $key => $value) {
                        $trekkerDetails[] = $value;
                    }

                    if ($sessionData['travelDate'] != "0000-00-00 00:00:00"){
                        $bookingInit = array();
                        $bookingInit['trail_id'] = $sessionData['trailId'];
                        $bookingInit['user_id'] = $userId;
                        $bookingInit['date_of_booking'] = date("Y-m-d H:i:s");
                        $bookingInit['checkIn'] = $sessionData['travelDate'] ;
                        $bookingInit['total_trekkers'] = $sessionData['requestedSeats'] + $sessionData['requestedChildrenSeats'] + $sessionData['requestedStudentSeats'];
                        $bookingInit['number_of_trekkers'] = $sessionData['requestedSeats'] ;
                        $bookingInit['number_of_children'] = $sessionData['requestedChildrenSeats'] ;
                        $bookingInit['number_of_students'] = $sessionData['requestedStudentSeats'] ;
                        $bookingInit['amount'] = $sessionData['total'] ;
                        $bookingInit['amountWithTax'] = $sessionData['totalPayable'] ;
                        $bookingInit['gst_amount'] = $sessionData['gstCharges'] ;
                        $bookingInit['time_slot'] = $sessionData['timeslot'];
                        $bookingInit['booking_status'] = 'Waiting';
                        $bookingInit['display_id'] = $displayId;
                        $bookingInit['trekkers_details'] = json_encode($trekkerDetails);

                        if ($bookingInit['checkIn'] != "0000-00-00 00:00:00"){
                            //To avoide 0000-00-00 00:00:00
                            $placeOrder = \App\TrailBooking::create($bookingInit);
                        }else{
                            Session::flash('TranErrMessage', 'Invalid check in date');
                            Session::flash('alert-class', 'alert-danger');
                            return \Redirect::to(url('/').'/landscapes');
                        }

                        $bookingId = $placeOrder->id;
                        $merchantId = \Config::get('payment.sbiMerchantId');
                        $sbiKey = \Config::get('payment.sbiKey');

                        // Payment data
                        $redirectUrl = url('/').'/ecotrails/responseReceiver';

                        //For CCAvenue
                        // $paymentData = [];
                        // $paymentData['order_id']        = $bookingId;
                        // $paymentData['userId']          = $userId;
                        // $paymentData['amount']          = $sessionData['totalPayable'];
                        // $paymentData['redirect_url']    = $redirectUrl;
                        // $paymentData['cancel_url']      = $redirectUrl;
                        // $paymentData['merchant_param1'] = $bookingId;
                        // $paymentData['merchant_param4'] = $displayId;

                        // $data = $this->initPaymentTran($paymentData);

                        $requestParameter  = $merchantId."|DOM|IN|INR|".$sessionData['totalPayable']."|".$userId."|".$redirectUrl."|".$redirectUrl."|SBIEPAY|".$bookingId."|".$userId."|NB|ONLINE|ONLINE|";

                        $data = $this->_encrypt($requestParameter,$sbiKey);


                        return view('payment/sbiGateway', ['data'=> $data]);
                    }else{
                        echo "string 2";exit;
                        Session::flash('TranErrMessage', 'Invalid check in date');
                        Session::flash('alert-class', 'alert-danger');
                        return \Redirect::to(url('/').'/landscapes');
                    }
                }else{
                    echo "string 3";exit;
                    return \Redirect::to(url('/').'/landscapes');
                }
            }else{
                echo "string 4";exit;
                return \Redirect::to(url('/').'/landscapes');
            }
        }else{
            echo "string 5";exit;
            Session::flash('TranErrMessage', 'Available seats are being booked!! Please checks seats available and book faster.');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('/').'/landscapes');
        }

    }

    public function qrCode($type, $bookingId)
    {
        try{
            //get the booking details
            $getData = \App\TrailBooking::where('id', $bookingId)->get()->toArray();

            if (count($getData)) {
                $qrText = $getData[0]['display_id'] . '$$' .$getData[0]['number_of_trekkers']. '$$' . substr($getData[0]['checkIn'], 0, 10)  ;
                echo \QrCode::size(100)->generate($qrText);
            }else{
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
        // echo \QrCode::size(100)->generate('Make me into a QrCode!');
    }

    public function sbiResponseReceiver(Request $request)
    {
        // Array
        // (
        //     [encData] => 5g2udGl5k0h0cMmDXTFTHUEXHiTqQ418UpOawKZGlxSb2D2ironMsLbnaYgVA23mms2K77iIdjuvnSmgDpHIPqdkUL8+twSa8PqQq8k3WYRWVUP0OHZGioeWNuYFAEkmWEXMQNUq/RZL3FsJnwD9EfAwX1A/55gYHVLc7vsw4KU=
        //     [Bank_Code] => 1000205
        //     [merchIdVal] => 1000205
        // )
        $sbiKey = \Config::get('payment.sbiKey');

        $encResponse = $_POST["encData"];   //This is the response sent by the SBI Server
        $rcvdString = $this->_decrypt($encResponse, $sbiKey);
        $decryptValues = explode('|', $rcvdString);

        $orderStatus = $decryptValues[2];
        $userId = $decryptValues[6];
        $orderId = $decryptValues[0];

        // echo "<pre>"; print_r($decryptValues);exit;

        // update the row
        $updateContent = array();

        $updateContent['booking_status'] = ucwords(strtolower($orderStatus));
        $updateContent['gatewayResponse'] = $rcvdString;
        $updateContent['transaction_id'] = $decryptValues[1];
        // echo "<pre>"; print_r($updateContent);exit;

        $updateRow = \App\TrailBooking::where('id',$orderId)->update($updateContent);

        if ($orderStatus == 'SUCCESS') {

            // Send a mail to user account
            if ($userId) {
                $bookingData = \App\TrailBooking::where('id',$orderId)->get()->toArray();

                $trailData = \App\Trail::where('id',$bookingData[0]['trail_id'])->get()->toArray();

                // get the user details
                $userInfo = \App\User::where('id', $userId)->get()->toArray();

                // Send SMS
                $data['userInfo'] = $userInfo[0];
                $data['trailData'] = $trailData[0];
                $data['bookingData'] = $bookingData[0];

                $this->bookingSMS($data, 1);

                $bookingData[0]['trekkers_details'] = json_decode($bookingData[0]['trekkers_details'],true);

                $qrFileName = $bookingData[0]['display_id'].'.png';
                $qrText = $bookingData[0]['display_id'] . '$$' .$bookingData[0]['total_trekkers']. '$$' . $bookingData[0]['checkIn'] ;

                $this->sendTrailTicket($request, $orderId, 1);
                //Save the QR file
                // \QrCode::format('png')->generate($qrText, public_path().'/assets/img/qrcodes/'.$qrFileName);

                // $message = \View::make('payment.trailMailTemplate', ['bookingData' => $bookingData[0], 'trailData' => $trailData[0], 'qrFileName' => $qrFileName]);

                // $subject = "Ecotrail booking";
                // $sendMail = $this->sendEmail($userEmail, $data['userInfo']['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

                return view('payment/success', ['userEmail'=> $userInfo[0]['email']]);

            }
        }else{
                return view('payment/failure');
        }

    }


    public function responseReceiver(Request $request)
    {


        echo "<pre>"; print_r($_POST);
        exit;
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
        $updateContent['gatewayResponse'] = json_encode($responseArray);

        $updateRow = \App\TrailBooking::where('id',$orderId)->update($updateContent);

        if ($orderStatus == 'Success') {

            // Send a mail to user account
            if ($userEmail != '') {
                $bookingData = \App\TrailBooking::where('id',$orderId)->get()->toArray();

                $trailData = \App\Trail::where('id',$bookingData[0]['trail_id'])->get()->toArray();

                // get the user details
                $userInfo = \App\User::where('id', $bookingData[0]['user_id'])->get()->toArray();

                // Send SMS
                $data['userInfo'] = $userInfo[0];
                $data['trailData'] = $trailData[0];
                $data['bookingData'] = $bookingData[0];

                $this->bookingSMS($data, 1);

                $bookingData[0]['trekkers_details'] = json_decode($bookingData[0]['trekkers_details'],true);

                $qrFileName = $bookingData[0]['display_id'].'.png';
                $qrText = $bookingData[0]['display_id'] . '$$' .$bookingData[0]['total_trekkers']. '$$' . $bookingData[0]['checkIn'] ;

                $this->sendTrailTicket($request, $orderId, 1);
                //Save the QR file
                // \QrCode::format('png')->generate($qrText, public_path().'/assets/img/qrcodes/'.$qrFileName);

                // $message = \View::make('payment.trailMailTemplate', ['bookingData' => $bookingData[0], 'trailData' => $trailData[0], 'qrFileName' => $qrFileName]);

                // $subject = "Ecotrail booking";
                // $sendMail = $this->sendEmail($userEmail, $data['userInfo']['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

                return view('payment/success', ['userEmail'=> $userEmail]);

            }
        }else{
                return view('payment/failure');
        }

    }

    public function sendTrailTicket(Request $request, $bookingId, $requestFrom = 1)
    {
        try{
            $bookingData = \App\TrailBooking::where('id',$bookingId)->get()->toArray()[0];
            $trailData = \App\Trail::where('id',$bookingData['trail_id'])->get()->toArray()[0];
            $userInfo = \App\User::where('id', $bookingData['user_id'])->get()->toArray()[0];

            $bookingData['trekkers_details'] = json_decode($bookingData['trekkers_details'],true);


            if (!count($bookingData) || !count($trailData)) {
                Session::flash('bookingMess', 'Sorry could not process');
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            $qrFileName = $bookingData['display_id'].'.png';

            if(!file_exists(public_path().'/assets/img/qrcodes/'.$qrFileName)){
                $qrText = $bookingData['display_id'] . '$$' .$bookingData['total_trekkers']. '$$' . $bookingData['checkIn'] ;

                //Save the QR file
                \QrCode::format('png')->generate($qrText, public_path().'/assets/img/qrcodes/'.$qrFileName);

            }

            $message = \View::make('payment.trailMailTemplate', ['bookingData' => $bookingData, 'trailData' => $trailData, 'qrFileName' => $qrFileName]);

            $subject = "Myecotrip - Ecotrail booking";
            $sendMail = $this->sendEmail($userInfo['email'], $userInfo['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

            if ($requestFrom == 2) {
                Session::flash('bookingMess', 'Ticket resent successfully');
                Session::flash('alert-class', 'alert-success');
                return \Redirect::to(url('/') . '/userBookingHistory');

            }

            return true;
            // echo "<pre>";print_r($getBooking);exit();

        }catch(\Exception $e ){

            if ($requestFrom == 2) {
                Session::flash('bookingMess', 'Sorry could not process');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('/') . '/userBookingHistory');

            }

            return false;


        }

    }

}
