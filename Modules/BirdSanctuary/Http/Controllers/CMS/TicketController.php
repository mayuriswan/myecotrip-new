<?php

namespace Modules\BirdSanctuary\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
       try {
            $birdSanctuaryId = $this->getLoggedInUserDetails($request, 'birdSanctuaryId');
            $checkDate = date("Y-m-d");

            $entryFee = [];
            $boatingPricing = [];

            //Get the active version
            $birdSanctuaryDetail = \App\BirdSanctuary\birdSanctuary::where('id',$birdSanctuaryId)->get()->toArray();

            $getEntryPricing = \App\BirdSanctuary\birdSanctuaryPrice::join('birdSanctuaryPricingMasters', 'birdSanctuaryEntryFee.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                ->where('birdSanctuary_id', $birdSanctuaryId)
                ->where('version', $birdSanctuaryDetail[0]['entrance_fee_version'])
                ->where('from_date','<=', $checkDate)
                ->where('to_date','>=', $checkDate)
                ->where('isActive', 1)
                ->select('birdSanctuaryPricingMasters.name', 'birdSanctuaryPricingMasters.backend_key', 'birdSanctuaryEntryFee.*')
                ->get()->toArray();

            if ($getEntryPricing) {

                //Get the boating pricing


                $birdSanctuaryName = $birdSanctuaryDetail[0]['name'];
                $boatingTypes = json_decode($birdSanctuaryDetail[0]['boat_types']);
                $hasBoating = false;

                \DB::enableQueryLog();
                //Get the pricing for each boating types
                $boatings = [];
                foreach ($boatingTypes as $key => $boatingType) {
                    $getBoatingPricing =  \App\BirdSanctuary\boatTypePrice::leftJoin('birdSanctuaryBoatType', 'birdSanctuaryBoatType.id','=','birdSanctuaryBoatTypePrice.boatType_id')
                            ->join('birdSanctuaryPricingMasters', 'birdSanctuaryBoatTypePrice.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                            ->where('version', $birdSanctuaryDetail[0]['boating_fee_version'])
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
                            ->where('version', $birdSanctuaryDetail[0]['camera_fee_version'])
                            ->where('from_date','<=', $checkDate)
                            ->where('to_date','>=', $checkDate)
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

                //get the current pricing version


                $getParkingPricing = \App\BirdSanctuary\parkingFee::
                    leftJoin('birdSanctuaryParkingVehicleType', 'birdSanctuaryParkingVehicleType.id','=', 'birdSanctuaryParkingFee.vehicletype_id')
                    ->where('birdSanctuary_id', $birdSanctuaryId)
                    ->where('version', $birdSanctuaryDetail[0]['parking_fee_version'])
                    ->where('from_date','<=', $checkDate)
                    ->where('to_date','>=', $checkDate)
                    ->where('birdSanctuaryParkingFee.isActive', 1)
                    ->select('birdSanctuaryParkingVehicleType.type as name', 'birdSanctuaryParkingVehicleType.shortDesc', 'birdSanctuaryParkingFee.id', 'birdSanctuaryParkingFee.price', 'birdSanctuaryParkingVehicleType.bill_name')
                    ->get()
                    ->toArray();


                $displayData['birdSanctuaryLogo'] = $birdSanctuaryDetail[0]['logo'];
                $displayData['travelDate'] = date("Y-m-d H:m:s");
                $displayData['birdSanctuaryName'] = $birdSanctuaryName;

                session(['bookingData' => $displayData]);
                // $hasBoating = false;
                // echo "<pre>"; print_r($getPricing);exit();

                return view('birdsanctuary::CMS.Ticket.issue', ['displayData' => $displayData, 'entryPricing' => $getEntryPricing, 'boatings' => $boatings, 'hasBoating' => $hasBoating, 'hasCameraTypes' => $hasCameraTypes, 'camers' => $camers, 'parkingPricing' => $getParkingPricing]);

            }else{
                \Session::flash('alert-danger', 'Sorry there is some problem in processing the request. Please contact our support team.');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        } catch (Exception $e) {
            \Session::flash('alert-danger', 'Sorry could not process !!');
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
        return view('birdsanctuary::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try{
            // echo "<pre>"; print_r($_POST);exit();

            $validator = \Validator::make($request->all(), [
                'entry'   => 'required',
            ]);

            if ($validator->fails()) {
                \Session::flash('alert-danger', $validator->errors());

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            $entryIds = array_keys($_POST['entry']);
            $cameraIds = [];
            $boatingIds = [];
            $entryCharges = 0;
            $cameraCharges = 0;
            $boatingCharges = 0;
            $totalCharges = 0;

            $bookingData['display_id'] = time();
            $bookingData['birdSanctuary_id'] = $this->getLoggedInUserDetails($request, 'birdSanctuaryId');
            $bookingData['user_id'] = $this->getLoggedInUserDetails($request, 'userId');
            $bookingData['date_of_booking'] = date("Y-m-d H:m:s");
            $bookingData['checkIn'] = date("Y-m-d");
            $bookingData['booking_source'] = 'Admin online';
            $bookingData['mode_of_payment'] = 'Cash';
            $bookingData['booking_status'] = 'Success';

            $bookingData['no_of_entranc_ticket'] = 0;
            $bookingData['entry_charges'] = 0;

            $bookingData['no_of_camera_ticket'] = 0;
            $bookingData['camera_charges'] = 0;

            $bookingData['no_of_boating_ticket'] = 0;
            $bookingData['boating_charges'] = 0;

            $bookingData['no_of_parking_ticket'] = 0;
            $bookingData['parking_charges'] = 0;

            $bookingData['total_charges'] = 0;


            //For entrance
            $getEntrancePricing = \App\BirdSanctuary\birdSanctuaryPrice::whereIn('id', $entryIds)->get()->toArray();

            foreach ($getEntrancePricing as $key => $entranceType) {
                if ($_POST['entry'][$entranceType['id']] > 0) {
                    $numbers = $_POST['entry'][$entranceType['id']];
                    $bookingData['no_of_entranc_ticket'] += $numbers;

                    $appendArray = ['id' => $entranceType['id'], 'price' => $entranceType['price'], 'numbers' => $numbers];

                    $bookingInfo['entrance'][] = $appendArray;
                    $bookingData['entry_charges'] += $entranceType['price'] * $numbers;
                    $bookingData['total_charges'] += $entranceType['price'] * $numbers;
                }
            }

            //For camera
            if (isset($_POST['camera'])) {
                $cameraIds = array_keys($_POST['camera']);

                $getCameraPricing =  \App\BirdSanctuary\cameraFee::whereIn('id', $cameraIds)->get()->toArray();

                foreach ($getCameraPricing as $key => $cameraType) {
                    if ($_POST['camera'][$cameraType['id']] > 0) {
                        $numbers = $_POST['camera'][$cameraType['id']];
                        $bookingData['no_of_camera_ticket'] += $numbers;

                        $appendArray = ['id' => $cameraType['id'], 'price' => $cameraType['price'], 'numbers' => $numbers];

                        $bookingInfo['camera'][] = $appendArray;
                        $bookingData['camera_charges'] += $cameraType['price'] * $numbers;
                        $bookingData['total_charges'] += $cameraType['price'] * $numbers;
                    }
                }

            }

            //For boating
            if (isset($_POST['boating'])) {
                $boatingIds = array_keys($_POST['boating']);

                $getBoatingPricing =  \App\BirdSanctuary\boatTypePrice::whereIn('id', $boatingIds)->get()->toArray();

                foreach ($getBoatingPricing as $key => $boatingType) {
                    if ($_POST['boating'][$boatingType['id']] > 0) {
                        $numbers = $_POST['boating'][$boatingType['id']];
                        $bookingData['no_of_boating_ticket'] += $numbers;

                        $appendArray = ['id' => $boatingType['id'], 'price' => $boatingType['price'], 'numbers' => $numbers];

                        $bookingInfo['boating'][] = $appendArray;
                        $bookingData['boating_charges'] += $boatingType['price'] * $numbers;
                        $bookingData['total_charges'] += $boatingType['price'] * $numbers;
                    }
                }

            }

            //For parking
            if (isset($_POST['parking'])) {
                $parkingIds = array_keys($_POST['parking']);

                $getParkingPricing =  \App\BirdSanctuary\parkingFee::whereIn('id', $parkingIds)->get()->toArray();

                foreach ($getParkingPricing as $key => $parkingType) {
                    if ($_POST['parking'][$parkingType['id']] > 0) {
                        $numbers = $_POST['parking'][$parkingType['id']];
                        $bookingData['no_of_parking_ticket'] += $numbers;

                        $appendArray = ['id' => $parkingType['id'], 'price' => $parkingType['price'], 'numbers' => $numbers];

                        $bookingInfo['parking'][] = $appendArray;
                        $bookingData['parking_charges'] += $parkingType['price'] * $numbers;
                        $bookingData['total_charges'] += $parkingType['price'] * $numbers;
                    }
                }

            }


            $bookingData['booking_info'] = json_encode($bookingInfo);
            $bookingData['amount_with_tax'] = $bookingData['total_charges'];
            // echo "<pre>$totalCharges"; print_r($bookingData);exit();

            $create = \App\BirdSanctuary\birdSanctuaryBookings::create($bookingData);

            if ($create) {
                // \Session::flash('alert-success', 'Booked successfully');

                // $data =  $request->session()->get('_previous');
                // return \Redirect::to($data['url']);

                return redirect()->route('book-ticket', ['id' => $create->id]);

            }else{
                \Session::flash('alert-danger', 'Sorry could not book ticket!!');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

        } catch (Exception $e) {
            \Session::flash('alert-danger', 'Sorry could not process. ' . $e->getMessage());

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $bookingId)
    {
        try{
            $bookingDetails   = \App\BirdSanctuary\birdSanctuaryBookings::where("id", $bookingId)->get()->toArray();

            if (!$bookingDetails) {
                \Session::flash('alert-danger', 'Sorry could not get booking details.');

                $data =  $request->session()->get('_previous');
                return redirect()->route('BSbookNow');
            }

            $bookingInfo = json_decode($bookingDetails[0]['booking_info'], true);

            foreach ($bookingInfo['entrance'] as $key => $entryTicket) {
                //Get the type
                $bookingInfo['entrance'][$key]['name'] = $this->getType($entryTicket['id']);
            }

            if ($bookingDetails[0]['no_of_camera_ticket']) {
                foreach ($bookingInfo['camera'] as $key => $ticket) {
                    //Get the type
                    $bookingInfo['camera'][$key]['name'] = $this->getCameraType($ticket['id']);
                }
            }

            if ($bookingDetails[0]['no_of_boating_ticket']) {
                foreach ($bookingInfo['boating'] as $key => $ticket) {
                    //Get the type
                    $bookingInfo['boating'][$key]['name'] = $this->getBoatingType($ticket['id']);
                }
            }

            if ($bookingDetails[0]['no_of_parking_ticket']) {
                foreach ($bookingInfo['parking'] as $key => $ticket) {
                    //Get the type
                    $bookingInfo['parking'][$key]['name'] = $this->getParkingType($ticket['id']);
                }
            }

            // echo "<pre>"; print_r($bookingInfo);exit();
            \Session::flash('alert-success', 'Booked successfully');

            return view('birdsanctuary::CMS.Ticket.view', ['displayData' => $bookingInfo, 'bookingData' => $bookingDetails[0]]);

        }catch (Exception $e) {
            \Session::flash('alert-danger', 'Sorry could not process. ' . $e->getMessage());

            $data =  $request->session()->get('_previous');
            return redirect()->route('BSbookNow');
        }
    }


    public function getType($id)
    {
        try{
            $getEntryPricing = \App\BirdSanctuary\birdSanctuaryPrice::join('birdSanctuaryPricingMasters', 'birdSanctuaryEntryFee.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                ->where('birdSanctuaryEntryFee.id', $id)
                ->select('birdSanctuaryPricingMasters.name')
                ->get()
                ->toArray();

            if ($getEntryPricing) {
                return $getEntryPricing[0]['name'];
            }else{
                return null;
            }

        }catch (Exception $e) {
            return null;
        }
    }

    public function getCameraType($id)
    {
        try{
            $getCameraPricing =  \App\BirdSanctuary\cameraFee::leftJoin('birdSanctuaryCameraType', 'birdSanctuaryCameraType.id','=','birdSanctuaryCameraFee.cameratype_id')
                            ->where('birdSanctuaryCameraFee.id', $id)
                            ->select('birdSanctuaryCameraType.type')
                            ->get()->toArray();

            if ($getCameraPricing) {
                return $getCameraPricing[0]['type'];
            }else{
                return null;
            }

        }catch (Exception $e) {
            return null;
        }
    }

    public function getBoatingType($id)
    {
        try{

             $getBoatingPricing =  \App\BirdSanctuary\boatTypePrice::leftJoin('birdSanctuaryBoatType', 'birdSanctuaryBoatType.id','=','birdSanctuaryBoatTypePrice.boatType_id')
                            ->join('birdSanctuaryPricingMasters', 'birdSanctuaryBoatTypePrice.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                            ->where('birdSanctuaryBoatTypePrice.id', $id)
                            ->select('birdSanctuaryBoatType.name as boat_name', 'birdSanctuaryPricingMasters.name')
                            ->get()->toArray();

            if ($getBoatingPricing) {
                return $getBoatingPricing[0]['boat_name']. ' : '.$getBoatingPricing[0]['name'];
            }else{
                return null;
            }

        }catch (Exception $e) {
            return null;
        }
    }

    public function getParkingType($id)
    {
        try{

            $getParkingPricing = \App\BirdSanctuary\parkingFee::
                    leftJoin('birdSanctuaryParkingVehicleType', 'birdSanctuaryParkingVehicleType.id','=', 'birdSanctuaryParkingFee.vehicletype_id')
                    ->where('birdSanctuaryParkingFee.id', $id)
                    ->select('birdSanctuaryParkingVehicleType.type')
                    ->get()
                    ->toArray();

            if ($getParkingPricing) {
                return $getParkingPricing[0]['type'];
            }else{
                return null;
            }

        }catch (Exception $e) {
            return null;
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        echo "stringeeee" ; exit;
        return view('birdsanctuary::edit');
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
}
