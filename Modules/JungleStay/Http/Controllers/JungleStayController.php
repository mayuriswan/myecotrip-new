<?php

namespace Modules\JungleStay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Session;

class JungleStayController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $data = \App\JungleStay\Stay::where('status', 1)->orderBy('display_order')->get()->toArray();
            // echo "<pre>"; print_r($data);exit();

            return view('junglestay::index',['data' => $data]);
        } catch (\Exception $e) {
            // echo "$e";exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('junglestay::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $jungleStayId, $jungleStayName)
    {
        try {
            $data = \App\JungleStay\Stay::where('id', $jungleStayId)->get()->toArray()[0];
            $data['incharger_details'] = explode(",", $data['incharger_details']);
            $roomTypes = json_decode($data['room_types']);

            //Room types
            $images = \App\JungleStay\Images::where('js_id', $jungleStayId)->where('status', 1)->get()->toArray();

            $rooms = \App\JungleStay\Rooms::join('js_room_types','js_room_types.id','js_rooms.js_type')
                        ->whereIn('js_type', $roomTypes)
                        ->where('js_id', $jungleStayId)
                        ->where('js_rooms.status', 1)
                        ->select('js_rooms.*','shortDesc', 'name')
                        // ->get()->toArray();
                        ->paginate(7);


            $amenities = \App\JungleStay\Amenities::where('status', 1)->get()->toArray();
            foreach ($amenities as $key => $value) {
                $amenitiesList[$value['id']] = $value;
            }
            // echo "<pre>"; print_r($rooms);exit();
            $rooms->withPath(url('/').'/jungle-stays/'.$jungleStayId.'/bandipur');

            session(['js-stay' => url('/jungle-stays/'. $jungleStayId .'/'. $jungleStayName)]);


            return view('junglestay::details',['data' => $data, 'images' => $images, 'rooms' => $rooms, 'amenities' => $amenitiesList]);
        } catch (\Exception $e) {
            // echo "$e";exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function checkAvailability(Request $request, $jsId)
    {
        try{
            // echo "<pre>"; print_r($_POST); exit;

            $validator = \Validator::make($request->all(), [
                'checkIn'   => 'required|date|date_format:Y-m-d|before:checkOut',
                'checkOut'   => 'required|date|date_format:Y-m-d|after:checkIn',
                'noOfAdults' => 'required',
                'nationality' => 'required'
            ]);

            if ($_POST['noOfAdults'] == '6+') {
                $_POST['noOfAdults'] = $_POST['noOfAdults2'];
            }

            if ($validator->fails()) {
                Session::flash('valMessage', 'Sorry, Could not process. Please try once again !!');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to($request->session()->get('js-stay'));
            }

            //User check
            $checkAccountVerification = 0;
            if ($request->session()->get('userId')) {
                //Check user has verified his email / phone no
                $userId = $request->session()->get('userId');
                $checkAccountVerification = $this->checkAccountVerification($userId);
            }

            $startDate = $_POST['checkIn'];
            $endDate = $_POST['checkOut'];

            //Booked list
            $getBookedList = \App\JungleStay\Rooms::join('js_booking_details as details', 'details.room_id', 'js_rooms.id')
                            ->join('js_bookings as booking','booking.id', 'details.booking_id')
                            ->where('booking.js_id', $jsId)
                            ->where(function($query) use ($startDate){
                                     $query->where('check_in', '<=', "$startDate");
                                     $query->where('check_out', '>', "$startDate");
                                     $query->where(function($query){
                                         $query->where('details.booking_status', 'Success')
                                         ->orWhere('details.booking_status', 'Waiting');
                                     });
                                 })
                            ->orWhere(function($query) use ($endDate){
                                      $query->where('check_in', '<', "$endDate");
                                      $query->where('check_out', '>=', "$endDate");
                                      $query->where(function($query){
                                          $query->where('details.booking_status', 'Success')
                                          ->orWhere('details.booking_status', 'Waiting');
                                     });
                                  })
                            ->orWhere(function($query) use ($startDate, $endDate){
                                       $query->where('check_in', '>=', "$startDate");
                                       $query->where('check_out', '<', "$endDate");
                                       $query->where(function($query){
                                           $query->where('details.booking_status', 'Success')
                                           ->orWhere('details.booking_status', 'Waiting');
                                       });
                                   })
                            ->groupBy('details.room_id')
                            ->select('js_rooms.*', \DB::raw('SUM(details.no_of_rooms) as bookedRooms'))
                            // ->having('js_rooms.no_of_rooms','>', \DB::raw('SUM(details.no_of_rooms)'))
                            ->get()->toArray();

            $bookedRooms = $this->idNameFormat($getBookedList, 'bookedRooms');
            // echo "<pre>"; print_r($bookedRooms); exit;

            $data['stayDetails'] = \App\JungleStay\Stay::where('id', $jsId)->get()->toArray()[0];
            $roomTypes = json_decode($data['stayDetails']['room_types']);

            $roomsList = \App\JungleStay\Rooms::join('js_room_types','js_room_types.id','js_rooms.js_type')
                        ->whereIn('js_type', $roomTypes)
                        ->where('js_id', $jsId)
                        ->where('js_rooms.status', 1)
                        ->select('js_rooms.*','shortDesc', 'name')
                        ->get()->toArray();

            $availabelRooms = [];
            $maxAdultCapacity = 0;
            foreach ($roomsList as $key => $room) {
                $availabeRooms = $room['no_of_rooms'];
                if (isset($bookedRooms[$room['id']])) {
                    $availabeRooms -= $bookedRooms[$room['id']];
                }

                if ($availabeRooms > 0) {
                    $room['availabeRooms'] = $availabeRooms;
                    $availabelRooms[] = $room;
                    $maxAdultCapacity = $availabeRooms * $room['max_capacity'];
                }
            }

            if($maxAdultCapacity < $_POST['noOfAdults']){
                Session::flash('valMessage', 'Sorry, Jungle Stays not available for the selected number of Adults.');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to($request->session()->get('js-stay'));
            }

            $roomIds = array_column($availabelRooms, 'id');

            if (!count($roomIds)) {
                Session::flash('valMessage', 'Sorry, Jungle Stays are not Available for the selected date.');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to($request->session()->get('js-stay'));
            }

            //Room pricing
            $getPricing = \App\JungleStay\RoomPricing::whereIn('room_id', $roomIds)
                            ->where('pricing_id', $_POST['nationality'])
                            ->where('status', 1)->get()->toArray();
            $roomPricing = $this->idArrayFormat($getPricing, 'room_id');

            $amenities = \App\JungleStay\Amenities::where('status', 1)->get()->toArray();
            foreach ($amenities as $key => $value) {
                $amenitiesList[$value['id']] = $value;
            }

            session(['js-booking-info' => ['post'=> $_POST, 'roomsIds' => $roomIds, 'stayDetails' => $data['stayDetails'] ]]);
            // echo "<pre>"; print_r($data); exit;

            return view('junglestay::rooms-list',['rooms' => $availabelRooms, 'data' => $data,'roomPricing' => $roomPricing,
                        'post' => $_POST, 'amenities' => $amenitiesList, 'accountVerification' => $checkAccountVerification]);

        } catch (\Error $e) {
            // echo "$e";exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function getGuestDetails(Request $request, $jsId)
    {
        // echo "<pre>"; print_r($_POST); exit;
        try {
            if (!$request->session()->get('js-booking-info')) {
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            if (!$request->session()->get('userId')){
                Session::flash('valMessage', 'Sorry, Could not process your request. Please try once again');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to($request->session()->get('js-stay'));
            }

            $_POST['selectedRooms'] = array_keys(array_filter($_POST['noOfRooms']));


            $postData = $request->session()->get('js-booking-info');
            $postData['selectedRooms'] = $_POST['selectedRooms'];
            $postData['roomCounts'] = $_POST['noOfRooms'];
            $postData['noOfDays'] = $this->dateDiffInDays($postData['post']['checkIn'],$postData['post']['checkOut']);

            session(['js-booking-info' => $postData]);

            $rooms = \App\JungleStay\Rooms::join('js_room_types','js_room_types.id','js_rooms.js_type')
                        ->whereIn('js_rooms.id', $_POST['selectedRooms'])
                        ->select('js_rooms.*','shortDesc', 'name')
                        ->get()->toArray();

            $data['entryFee'] = \App\JungleStay\EntryPricing::where('js_id', $jsId)
                                ->where('pricing_id', $postData['post']['nationality'])
                                ->get()->last()->toArray();

            //Room pricing
            $getPricing = \App\JungleStay\RoomPricing::whereIn('room_id', $_POST['selectedRooms'])
                            ->where('pricing_id', $postData['post']['nationality'])
                            ->where('status', 1)->get()->toArray();
            $roomPricing = $this->idArrayFormat($getPricing, 'room_id');
            // echo "<pre>"; print_r($roomPricing); exit;

            $data['stayAmout'] = 0;
            foreach ($roomPricing as $key => $value) {
                if ($_POST['noOfRooms'][$value['room_id']]) {
                    $data['stayAmout'] += $_POST['noOfRooms'][$value['room_id']] * $value['price'] * $postData['noOfDays'];
                }
            }

            $gstPercentage = config('junglestay.js-gst-percentage');

            $data['stayAmoutGst'] = ($gstPercentage / 100) * $data['stayAmout'];

            $data['totalStayFee'] = $data['stayAmout'] + $data['stayAmoutGst'];
            $data['totalEntryFee'] = $postData['post']['nationality'] * $data['entryFee']['price'];

            // echo "<pre>"; print_r($postData); exit;

            //Service charges
            $internetHandlingCharge = config('junglestay.internetHandlingCharge');
            $paymentGatewayCharge = config('junglestay.paymentGatewayCharge');
            $gstCharge = config('junglestay.gstCharge');

            $totalPayable = $data['totalStayFee'] + $data['totalEntryFee'];
            $IHC = ($internetHandlingCharge / 100 ) * $totalPayable;
            $GST = ($gstCharge / 100 ) * $IHC;
            $PG = ($paymentGatewayCharge / 100 ) * ($totalPayable + $IHC + $GST);

            $data['serviceCharge'] = round($IHC + $GST + $PG, 2);

            //Amenities
            $amenities = \App\JungleStay\Amenities::where('status', 1)->get()->toArray();
            foreach ($amenities as $key => $value) {
                $amenitiesList[$value['id']] = $value;
            }

            //Parking
            $parkingList = \App\JungleStay\Parking::join('js_parking_types','js_parking_types.id','js_parking.vehicle_id')
                        ->where('js_parking.js_id', $jsId)
                        ->where('status', 1)
                        ->select('js_parking.*', 'type')
                        ->get()->toArray();

            // echo "<pre>"; print_r($rooms); exit;

            return view('junglestay::guest-details',['rooms' => $rooms, 'data' => $data, 'roomPricing' => $roomPricing, 'amenities' => $amenitiesList, 'parkingList' => $parkingList, 'noOfDays' => $postData['noOfDays']]);

        } catch (\Error $e) {
            // echo "$e";exit;
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }

    }

    public function initiateBooking(Request $request, $jsId)
    {
        // echo "<pre>"; print_r($_POST); exit;
        try {
            $availability = $this->confirmAvailability($request, $jsId);

            if (!$availability or !$request->session()->get('userId')) {
                Session::flash('valMessage', 'Sorry, Could not process. Please try once again !!');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to($request->session()->get('js-stay'));
            }

            $validator = \Validator::make($request->session()->get('js-booking-info')['post'], [
                'checkIn'   => 'required|date|date_format:Y-m-d|before:checkOut',
                'checkOut'   => 'required|date|date_format:Y-m-d|after:checkIn',
            ]);

            if ($validator->fails()) {
                Session::flash('valMessage', 'Sorry, Could not process. Please try once again !!');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to($request->session()->get('js-stay'));
            }


            $userId = $request->session()->get('userId');
            $sessionData = $request->session()->get('js-booking-info');

            //Service charges
            $internetHandlingCharge = config('junglestay.internetHandlingCharge');
            $paymentGatewayCharge   = config('junglestay.paymentGatewayCharge');
            $gstCharge              = config('junglestay.gstCharge');
            $gstPercentage          = config('junglestay.js-gst-percentage');
            $gstParking             = config('junglestay.js-gst-parking');


            $bookingInit = array();
            $bookingInit['js_id'] = $jsId;
            $bookingInit['user_id'] = $userId;
            $bookingInit['date_of_booking'] = date("Y-m-d H:i:s");
            $bookingInit['check_in'] = $sessionData['post']['checkIn'] ;
            $bookingInit['check_out'] = $sessionData['post']['checkOut'] ;
            $bookingInit['booking_status'] = 'Waiting';
            $bookingInit['total_vehicles'] = 0;
            $bookingInit['parking_amount'] = 0;
            $bookingInit['entry_amount'] = 0;
            $bookingInit['parking_gst'] = 0;
            $bookingInit['total_guests'] = 0;

            //Room pricing
            $postData = $request->session()->get('js-booking-info');
            // echo "<pre>"; print_r($postData); exit;

            $getPricing = \App\JungleStay\RoomPricing::whereIn('room_id', $sessionData['selectedRooms'])
                            ->where('pricing_id', $sessionData['post']['nationality'])
                            ->where('status', 1)->get()->toArray();
            $roomPricing = $this->idArrayFormat($getPricing, 'room_id');


            $stayAmout = 0;
            foreach ($roomPricing as $key => $value) {
                if ($postData['roomCounts'][$value['room_id']]) {
                    $stayAmout += $postData['roomCounts'][$value['room_id']] * $value['price'] * $postData['noOfDays'];
                }
            }

            $stayAmoutGst = ($gstPercentage / 100) * $stayAmout;
            $bookingInit['stay_amount'] = $stayAmout + $stayAmoutGst;
            // echo "<pre>"; print_r($roomPricing); exit;

            //Parking price
            $parkingList = \App\JungleStay\Parking::join('js_parking_types','js_parking_types.id','js_parking.vehicle_id')
                        ->where('js_parking.js_id', $jsId)
                        ->where('status', 1)
                        ->select('js_parking.*', 'type')
                        ->get()->toArray();
            $parkingPricing = $this->idArrayFormat($parkingList, 'id');


            $vehicleInfo = [];
            $bookingInit['parking_amount'] = 0;
            if (isset($_POST['parking'])) {
                foreach ($_POST['parking'] as $key => $vehicle) {
                    if ($vehicle['count']) {
                        $bookingInit['total_vehicles'] += $vehicle['count'];

                        $append = [];
                        $append['vehicle_id'] = $parkingPricing[$vehicle['pricing_id']]['vehicle_id'];
                        $append['pricing_id'] = $vehicle['pricing_id'];
                        $append['price'] = $parkingPricing[$vehicle['pricing_id']]['price'];
                        $append['count'] = $vehicle['count'];

                        $vehicleInfo[] = $append;

                        $bookingInit['parking_amount'] += $vehicle['count'] * $parkingPricing[$vehicle['pricing_id']]['price'] * $postData['noOfDays'];
                    }
                }
            }


            if ($bookingInit['parking_amount']) {
                $bookingInit['parking_gst'] = ($gstParking / 100) * $bookingInit['parking_amount'];
                $bookingInit['parking_amount'] += $bookingInit['parking_gst'];
            }

            $bookingInit['vehicle_details'] = json_encode($vehicleInfo);

            //Entry pricing
             $entryFee = \App\JungleStay\EntryPricing::where('js_id', $jsId)
                                 ->where('pricing_id', $sessionData['post']['nationality'])
                                 ->get()->last()->toArray();
            $bookingDetails = [];

            foreach ($_POST['detail'] as $roomId => $guestDetails) {
                    $roomDetails = [];
                    $bookingInit['total_guests'] += count($guestDetails);

                    $roomPrice = $roomPricing[$roomId]['price'] * $postData['noOfDays'] * $postData['roomCounts'][$roomId];
                    $roomDetails['gst_amount']  = ($gstPercentage / 100 ) * $roomPrice;
                    $roomDetails['total_amount'] =  $roomPrice + $roomDetails['gst_amount'];
                    $roomDetails['room_id'] = $roomId;
                    $roomDetails['total_guests'] = count($guestDetails);
                    $roomDetails['pricing_id'] = $roomPricing[$roomId]['id'];
                    $roomDetails['booking_status'] = 'Waiting';
                    $roomDetails['no_of_rooms'] = $postData['roomCounts'][$roomId];


                    $guestList = [];
                    foreach ($guestDetails as $key => $value) {
                        $guest = $value;
                        $guest['entrance_pricing_id'] = $entryFee['id'];
                        $guest['entry_fee'] = $entryFee['price'];

                        $bookingInit['entry_amount'] += $entryFee['price'];

                        $guestList[] = $guest;

                    }
                    $roomDetails['guest_details'] = json_encode($guestList);

                    $bookingDetails[] = $roomDetails;
            }

            $totalPayable = $bookingInit['stay_amount'] + $bookingInit['entry_amount'] + $bookingInit['parking_amount'];

            //Service Charge
            $IHC = ($internetHandlingCharge / 100 ) * $totalPayable;
            $GST = ($gstCharge / 100 ) * $IHC;
            $PG = ($paymentGatewayCharge / 100 ) * ($totalPayable + $IHC + $GST);

            $bookingInit['transactional_amount'] = round($IHC + $GST + $PG, 2);
            $bookingInit['total_amount'] = $totalPayable + $bookingInit['transactional_amount'];

            // echo "<pre>"; print_r($bookingInit);print_r($bookingDetails);exit;

            $placeOrder = \App\JungleStay\Booking::create($bookingInit);

            $bookingDetails = array_map(function($arr) use ($placeOrder){
                return $arr + ['booking_id' => $placeOrder->id];
            }, $bookingDetails);

            // echo "<pre>"; print_r($bookingInit);print_r($bookingDetails);exit;

            \App\JungleStay\BookingDetail::insert($bookingDetails);

            $orderId = $placeOrder->id;
            $displayId = \App\JungleStay\Booking::where('id', $orderId)->pluck('display_id')[0];


            $redirectUrl = url('/').'/jungle-stays/response-receiver';

            $paymentData = [];
            $paymentData['order_id']        = $displayId;
            $paymentData['userId']          = $userId;
            $paymentData['amount']          = $bookingInit['total_amount'];
            $paymentData['redirect_url']    = $redirectUrl;
            $paymentData['cancel_url']      = $redirectUrl;
            $paymentData['merchant_param1'] = $orderId;
            $paymentData['merchant_param2'] = $displayId;

            $data = $this->initPaymentTran($paymentData);

            // echo "<pre>"; print_r($data);exit;

            if ($data == 0) {
                Session::flash('valMessage', 'Sorry, Could not process. Please try once again !!');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to($request->session()->get('js-stay'));
            }else{
                return view('payment/requestHandler', ['data'=> $data]);
            }

        } catch (\Error $e) {
            // echo "$e"; exit;
            Session::flash('valMessage', 'Sorry, Could not process. Please try once again !!');
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to($request->session()->get('js-stay'));

        }
    }

    public function responseReceiver(Request $request)
    {
        $workingKey = \Config::get('common.workingKey');
        $accessCode = \Config::get('common.accessCode');
        $merchantId = \Config::get('common.merchantId');

        // TODO: Uncomment this
        $encResponse = $_POST["encResp"];   //This is the response sent by the CCAvenue Server
        $rcvdString = $this->decrypt($encResponse, $workingKey);

        // Success response
        // $rcvdString = "order_id=1568827600&tracking_id=308005436552&bank_ref_no=1568827681812&order_status=Success&failure_message=&payment_mode=Net Banking&card_name=AvenuesTest&status_code=null&status_message=Y¤cy=INR&amount=3050.30&billing_name=Vinay A N&billing_address=8th main road&billing_city=Bangalore&billing_state=KARNATAKA&billing_zip=560054&billing_country=India&billing_tel=08861422700&billing_email=seo.manju@gmail.com&delivery_name=&delivery_address=&delivery_city=&delivery_state=&delivery_zip=&delivery_country=&delivery_tel=&merchant_param1=25&merchant_param2=1568827600&merchant_param3=&merchant_param4=&merchant_param5=&vault=N&offer_type=null&offer_code=null&discount_value=0.0&mer_amount=3050.30&eci_value=null&retry=N&response_code=0&billing_notes=&trans_date=18/09/2019 22:58:03&bin_country=";

        //Failure response
        // $rcvdString = "order_id=1568827709&tracking_id=308005436553&bank_ref_no=1568827789202&order_status=Failure&failure_message=&payment_mode=Net Banking&card_name=AvenuesTest&status_code=null&status_message=N¤cy=INR&amount=3951.23&billing_name=Vinay A N&billing_address=16 Second floor Central Street Kumara park west&billing_city=Bangalore&billing_state=Karnataka&billing_zip=560020&billing_country=India&billing_tel=8861422700&billing_email=vinayan17@gmail.com&delivery_name=&delivery_address=&delivery_city=&delivery_state=&delivery_zip=&delivery_country=&delivery_tel=&merchant_param1=26&merchant_param2=1568827709&merchant_param3=&merchant_param4=&merchant_param5=&vault=N&offer_type=null&offer_code=null&discount_value=0.0&mer_amount=3951.23&eci_value=null&retry=N&response_code=0&billing_notes=&trans_date=18/09/2019 22:59:50&bin_country=";

        $orderStatus = "";
        $userEmail = "";
        $orderAmount = "";

        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);

        // echo "<pre>"; print_r($decryptValues); exit;
        $keysNeeded = ['tracking_id','bank_ref_no','order_status','failure_message','payment_mode','card_name','trans_date'];
        // response to array
        $responseArray = array();
        foreach ($decryptValues as $key => $value) {
            $slipt = explode('=', $value);

            if (in_array($slipt[0], $keysNeeded)) {
                $responseArray[$slipt[0]] = $slipt[1];
            }
        }

        $updateContent = array();

        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($information[0] == 'order_status')
                $orderStatus = $information[1];

            if ($information[0] == 'billing_email')
                $userEmail = $information[1];

            if ($information[0] == 'amount')
                $orderAmount = $information[1];

            if ($information[0] == 'tracking_id')
                $updateContent['tracking_id'] = $information[1];

            if ($information[0] == 'bank_ref_no')
                $updateContent['bank_ref_no'] = $information[1];

            if ($information[0] == 'merchant_param1')
                $orderId = $information[1];

            if ($information[0] == 'merchant_param2')
                $displayId = $information[1];
        }

        // update the row
        $updateContent['booking_status'] = $orderStatus;
        $updateContent['gateway_response'] = json_encode($responseArray);

        //// TODO: delete it
        // $orderId = 13;

        $updateRow = \App\JungleStay\Booking::where('id',$orderId)->update($updateContent);
        \App\JungleStay\BookingDetail::where('booking_id', $orderId)->update(['booking_status' => $orderStatus]);

        if ($orderStatus == 'Success') {

            // Send a mail to user account
            if ($userEmail != '') {
                $noOfRooms = \App\JungleStay\BookingDetail::where('booking_id',$orderId)->get()->toArray();
                $bookingData = \App\JungleStay\Booking::where('id',$orderId)->get()->toArray()[0];

                $bookingData['noOfRooms']  = array_sum(array_map(function($item) {
                    return $item['no_of_rooms'];
                }, $noOfRooms));

                $stayData = \App\JungleStay\Stay::where('id',$bookingData['js_id'])->get()->toArray()[0];

                // get the user details
                $userInfo = \App\User::where('id', $bookingData['user_id'])->get()->toArray()[0];

                // Send SMS
                $data['userInfo'] = $userInfo;
                $data['stayData'] = $stayData;
                $data['bookingData'] = $bookingData;
                $data['roomDetails'] = $noOfRooms;

                //Send Booking SMS
                $this->bookingSMS($data, 4);

                $qrFileName = $bookingData['display_id'].'.png';
                $qrText = $bookingData['display_id'] . '$$' .$bookingData['total_guests'];

                $this->sendStayTicket($request, $orderId, 1);

                $request->session()->forget('js-booking-info');
                return view('payment/success', ['userEmail'=> $userEmail]);

            }
        }else{
                $request->session()->forget('js-booking-info');
                return view('payment/failure');
        }

    }

    public function sendStayTicket(Request $request, $bookingId, $requestFrom = 1)
    {
        try{
            $noOfRooms = \App\JungleStay\BookingDetail::join('js_rooms', 'js_rooms.id', 'js_booking_details.room_id')
                        ->join('js_room_types','js_room_types.id','js_rooms.js_type')
                        ->where('booking_id',$bookingId)
                        ->select('js_booking_details.*', 'name')
                        ->get()
                        ->toArray();


            $bookingData = \App\JungleStay\Booking::where('id',$bookingId)->get()->toArray()[0];
            $bookingData['noOfRooms'] = count($noOfRooms);

            $stayData = \App\JungleStay\Stay::where('id',$bookingData['js_id'])->get()->toArray()[0];

            // get the user details
            $userInfo = \App\User::where('id', $bookingData['user_id'])->get()->toArray()[0];

            $qrFileName = $bookingData['display_id'].'.png';

            //Save the QR file
            // if(!file_exists(public_path().'/assets/img/qrcodes/js/'.$qrFileName)){
            //     $qrText = $bookingData['display_id'] . '$$' .$bookingData['total_guests'] ;
            //     \QrCode::format('png')->generate($qrText, public_path().'/assets/img/qrcodes/js/'.$qrFileName);
            // }

            //Parking
            $parkingList = \App\JungleStay\Parking::join('js_parking_types','js_parking_types.id','js_parking.vehicle_id')
                        ->where('js_parking.js_id', $bookingData['js_id'])
                        ->select('js_parking.*', 'type')
                        ->get()->toArray();

            $vehiclePricing = $this->idArrayFormat($parkingList, 'id');

            // echo "<pre>"; print_r($noOfRooms);exit;
            // return view('junglestay::mail-template',['bookingData' => $bookingData, 'stayData' => $stayData, 'rooms' => $noOfRooms, 'vehiclePricing' => $vehiclePricing]);


            $message = \View::make('junglestay::mail-template',['bookingData' => $bookingData, 'stayData' => $stayData, 'rooms' => $noOfRooms, 'vehiclePricing' => $vehiclePricing]);
            // $userInfo['email'] = 'vinayan17@gmail.com';

            $subject = "Myecotrip - Jungle Stay Booking";
            $sendMail = $this->sendEmail($userInfo['email'], $userInfo['first_name'],[], $subject, $message, [], ['myecotrip17@gmail.com']);

            if ($requestFrom == 2) {
                Session::flash('bookingMess', 'Ticket resent successfully');
                Session::flash('alert-class', 'alert-success');
                return \Redirect::to(url('/') . '/userBookingHistory');

            }

            return true;
            // echo "<pre>";print_r($getBooking);exit();

        }catch(\Exception $e ){
            // echo "$e"; exit;
            if ($requestFrom == 2) {
                Session::flash('bookingMess', 'Sorry could not process');
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('/') . '/userBookingHistory');

            }
            return false;
        }

    }


    public function confirmAvailability(Request $request, $jsId)
    {
        try{
            // echo "<pre>"; print_r($request->session()); exit;
            $postData = $request->session()->get('js-booking-info');
            $startDate = $postData['post']['checkIn'];
            $endDate = $postData['post']['checkOut'];
            $rooms = [];

            $getBookedList = \App\JungleStay\Rooms::join('js_booking_details as details', 'details.room_id', 'js_rooms.id')
                        ->join('js_bookings as booking','booking.id', 'details.booking_id')
                        ->where('booking.js_id', $jsId)
                        ->whereIn('js_rooms.id', $postData['selectedRooms'])
                        ->where(function($query) use ($startDate){
                            $query->where('check_in', '<=', "$startDate");
                            $query->where('check_out', '>', "$startDate");
                            $query->where('details.booking_status', 'Success');
                         })
                        ->orWhere(function($query) use ($endDate){
                            $query->where('check_in', '<', "$endDate");
                            $query->where('check_out', '>=', "$endDate");
                            $query->where('details.booking_status', 'Success');
                         })
                        ->orWhere(function($query) use ($startDate, $endDate){
                            $query->where('check_in', '>=', "$startDate");
                            $query->where('check_out', '<', "$endDate");
                            $query->where('details.booking_status', 'Success');
                        })
                        ->groupBy('details.room_id')
                        ->select('js_rooms.*', \DB::raw('SUM(details.no_of_rooms) as bookedRooms'))
                        // ->having('js_rooms.no_of_rooms','>', \DB::raw('SUM(details.no_of_rooms)'))
                        ->get()->toArray();

            $bookedRooms = $this->idNameFormat($getBookedList, 'bookedRooms');

            $data['stayDetails'] = \App\JungleStay\Stay::where('id', $jsId)->get()->toArray()[0];
            $roomTypes = json_decode($data['stayDetails']['room_types']);

            $roomsList = \App\JungleStay\Rooms::join('js_room_types','js_room_types.id','js_rooms.js_type')
                        ->whereIn('js_rooms.id', $postData['selectedRooms'])
                        ->select('js_rooms.*','shortDesc', 'name')
                        ->get()->toArray();

            $foundOtherBooking = false;
            foreach ($roomsList as $key => $room) {
                if (isset($bookedRooms[$room['id']])) {
                    if ($room['no_of_rooms'] < $postData['roomCounts'][$room['id']] + $bookedRooms[$room['id']]) {
                        $foundOtherBooking = true;
                    }
                }
            }


            if ($foundOtherBooking) {
                //Some other booking was found for the rooms selected for the selected dates
                return false;
            }else {
                return true;
            }
        }catch (\Exception $e) {
            echo "$e"; exit;
            return false;
        }

    }

    public function addGuest($count, $index, $roomId)
    {
        return view('junglestay::add-guest',['count' => $count, 'index' => $index, 'roomId' => $roomId]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('junglestay::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkAvailabilityParticalBooking()
    {
        try{
            // echo "<pre>"; print_r($_POST); exit;
            $checkIn = $_POST['checkIn'];
            $checkOut = $_POST['checkOut'];

            $getAvailabeRooms = \DB::select( \DB::raw("SELECT
                            *
                        FROM
                            js_rooms
                        WHERE id not in
                        	(SELECT notAvailable.id FROM
                                (SELECT
                                  rooms.id, SUM(details.total_guests) as totalGuests, max_capacity
                                FROM
                                  js_rooms as rooms
                                JOIN js_booking_details as details ON details.room_id = rooms.id
                                JOIN js_bookings as booking ON booking.id = details.booking_id

                                WHERE
                                (booking.check_in<= '$checkIn' and booking.check_out > '$checkIn' and (booking.booking_status = 'Success' or booking.booking_status = 'Waiting'))
                                OR
                                (booking.check_in< '$checkOut'  and booking.check_out>= '$checkOut ' and (booking.booking_status = 'Success' or booking.booking_status = 'Waiting'))
                                OR
                                (booking.check_in>= '$checkIn' and booking.check_out< '$checkOut' and (booking.booking_status = 'Success' or booking.booking_status = 'Waiting'))
                                GROUP By rooms.id
                                Having max_capacity = totalGuests) as notAvailable
                            )"));

            $getAvailabeRooms = json_encode($getAvailabeRooms);
            $availabeRooms = json_decode($getAvailabeRooms,true);

            $getPartiallyBooked = \DB::select( \DB::raw("SELECT
                      rooms.id, SUM(details.total_guests) as totalGuests, max_capacity, (max_capacity - SUM(details.total_guests) ) as remaining
                    FROM
                      js_rooms as rooms
                    JOIN js_booking_details as details ON details.room_id = rooms.id
                    JOIN js_bookings as booking ON booking.id = details.booking_id

                    WHERE
                      (booking.check_in<= '$checkIn' and booking.check_out > '$checkIn' and (booking.booking_status = 'Success' or booking.booking_status = 'Waiting'))
                      OR
                      (booking.check_in< '$checkOut'  and booking.check_out>= '$checkOut ' and (booking.booking_status = 'Success' or booking.booking_status = 'Waiting'))
                      OR
                      (booking.check_in>= '$checkIn' and booking.check_out< '$checkOut' and (booking.booking_status = 'Success' or booking.booking_status = 'Waiting'))
                    GROUP By rooms.id
                    Having max_capacity != totalGuests"));


            $getPartiallyBooked = json_encode($getPartiallyBooked);
            $partiallyBooked = json_decode($getPartiallyBooked,true);

            $formatedData = [];
            if (count($partiallyBooked)) {
                foreach ($partiallyBooked as $key => $value) {
                    $formatedData[$value['id']] = $value;
                }
            }

            echo "<pre>"; print_r($formatedDataz); exit;

        } catch (\Exception $e) {
            echo "$e";exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }
}
