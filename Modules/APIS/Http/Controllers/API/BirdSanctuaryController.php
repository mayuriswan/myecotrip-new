<?php

namespace Modules\APIS\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BirdSanctuaryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('apis::index');
        
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('apis::create');
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
    public function show($id)
    {
        return view('apis::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('apis::edit');
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

    public function getPricing(Request $request, $birdSanctuaryId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        try {

            $birdSanctuary = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->get()->toArray();

            if (!count($birdSanctuary)) {
                $failure['message'] = $e->getMessage();
                return \Response::json($failure);
            }

            $charges = json_decode($birdSanctuary[0]['charges']);
            $output = [];

            if (in_array(1, $charges)) {
                $append['name'] = 'Entrance';
                $append['alias'] = 'ENT';
                $append['chargeId'] = 1;
                $append['data'] = $this->entrancePricing($birdSanctuaryId);

                $output[] = $append;
            }

            if (in_array(2, $charges)) {
                $append['name'] = 'Camera';
                $append['alias'] = 'CMR';
                $append['chargeId'] = 2;
                $append['data'] = $this->cameraPricing($birdSanctuaryId);

                $output[] = $append;
            }

            if (in_array(3, $charges)) {
                $append['name'] = 'Parking';
                $append['alias'] = 'PRK';
                $append['chargeId'] = 3;
                $append['data'] = $this->parkingPricing($birdSanctuaryId);

                $output[] = $append;
            }

            if (in_array(4, $charges)) {
                $append['name'] = 'Boating';
                $append['alias'] = 'BTG';
                $append['chargeId'] = 4;
                $append['data'] = $this->boatingPricing($birdSanctuaryId);

                $output[] = $append;
            }

            $success['content'] = $output;
            // echo "<pre>"; print_r($charges);exit;

            return \Response::json($success);


        } catch (\Exception $e) {
            $failure['message'] = $e->getMessage();
            return \Response::json($failure);

        }
    }

    public function boatingPricing($birdSanctuaryId)
    {
        //get the current pricing version
        $currentVersion = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->select('boating_fee_version')->get()->toArray();

        $checkDate = date("Y-m-d");

        $getPricing = \App\BirdSanctuary\boatTypePrice::
            leftJoin('birdSanctuaryBoatType', 'birdSanctuaryBoatType.id','=', 'birdSanctuaryBoatTypePrice.boatType_id')
            ->leftJoin('birdSanctuaryPricingMasters', 'birdSanctuaryPricingMasters.id', '=', 'birdSanctuaryBoatTypePrice.pricing_master_id')
            ->where('birdSanctuary_id', $birdSanctuaryId)
            ->where('version', $currentVersion[0]['boating_fee_version'])
            ->where('from_date','<=', $checkDate)
            ->where('to_date','>=', $checkDate)
            ->where('birdSanctuaryBoatTypePrice.isActive', 1)
            ->select('birdSanctuaryBoatType.name as boatType', 'birdSanctuaryBoatType.shortDesc', 'birdSanctuaryBoatType.full_booking', 'birdSanctuaryBoatTypePrice.id', 'birdSanctuaryBoatTypePrice.price','birdSanctuaryPricingMasters.name', 'birdSanctuaryPricingMasters.bill_name')
            ->get()
            ->toArray();

        return $getPricing;
    }

    public function parkingPricing($birdSanctuaryId)
    {
        //get the current pricing version
        $currentVersion = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->select('parking_fee_version')->get()->toArray();

        $checkDate = date("Y-m-d");

        $getPricing = \App\BirdSanctuary\parkingFee::
            leftJoin('birdSanctuaryParkingVehicleType', 'birdSanctuaryParkingVehicleType.id','=', 'birdSanctuaryParkingFee.vehicletype_id')
            ->where('birdSanctuary_id', $birdSanctuaryId)
            ->where('version', $currentVersion[0]['parking_fee_version'])
            ->where('from_date','<=', $checkDate)
            ->where('to_date','>=', $checkDate)
            ->where('birdSanctuaryParkingFee.isActive', 1)
            ->select('birdSanctuaryParkingVehicleType.type as name', 'birdSanctuaryParkingVehicleType.shortDesc', 'birdSanctuaryParkingFee.id', 'birdSanctuaryParkingFee.price', 'birdSanctuaryParkingVehicleType.bill_name')
            ->get()
            ->toArray();

        return $getPricing;
    }

    public function cameraPricing($birdSanctuaryId)
    {
        //get the current pricing version
        $currentVersion = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->select('camera_fee_version')->get()->toArray();

        $checkDate = date("Y-m-d");

        $getPricing = \App\BirdSanctuary\cameraFee::
            leftJoin('birdSanctuaryCameraType', 'birdSanctuaryCameraType.id','=', 'birdSanctuaryCameraFee.cameratype_id')
            ->where('birdSanctuary_id', $birdSanctuaryId)
            ->where('version', $currentVersion[0]['camera_fee_version'])
            ->where('from_date','<=', $checkDate)
            ->where('to_date','>=', $checkDate)
            ->where('birdSanctuaryCameraFee.isActive', 1)
            ->select('birdSanctuaryCameraType.type as name', 'birdSanctuaryCameraType.shortDesc', 'birdSanctuaryCameraFee.id', 'birdSanctuaryCameraFee.price','birdSanctuaryCameraType.bill_name')
            ->get()
            ->toArray();

        return $getPricing;
    }

    public function entrancePricing($birdSanctuaryId)
    {
        //get the current pricing version
        $currentVersion = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->select('entrance_fee_version')->get()->toArray();

        $checkDate = date("Y-m-d");

        $getEntryPricing = \App\BirdSanctuary\birdSanctuaryPrice::
            leftJoin('birdSanctuaryPricingMasters', 'birdSanctuaryPricingMasters.id','=', 'birdSanctuaryEntryFee.pricing_master_id')
            ->where('birdSanctuary_id', $birdSanctuaryId)
            ->where('version', $currentVersion[0]['entrance_fee_version'])
            ->where('from_date','<=', $checkDate)
            ->where('to_date','>=', $checkDate)
            ->where('isActive', 1)
            ->select('birdSanctuaryPricingMasters.name', 'birdSanctuaryPricingMasters.shortDesc', 'birdSanctuaryEntryFee.id', 'birdSanctuaryEntryFee.price', 'birdSanctuaryPricingMasters.bill_name')
            ->orderBy('birdSanctuaryPricingMasters.display_order')
            ->get()
            ->toArray();

        return $getEntryPricing;
    }

    public function syncTickets(Request $request)
    {
        $success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');
        try {

            $content_json = $request->getContent();
            $data      = json_decode($content_json, true);


             $validator = \Validator::make($request->all(), [
                'display_id' => 'required',
                'date_of_booking' => 'required',
                'checkIn' => 'required',
                'user_id' => 'required',
                'birdSanctuary_id' => 'required',
                'device_info' => 'required',
                'booking_info' => 'required'
            ]);

            if ($validator->fails()) {
                $failure['message'] = $validator->errors();
                return \Response::json($failure);
            }

            //Check for the duplicate
            $checkDupliacte = \App\BirdSanctuary\birdSanctuaryBookings::
                where('ticket_sequence', $data['ticket_sequence'])
                ->where('user_id',$data['user_id'] )
                ->get()->count();

            if(!$checkDupliacte){
                $bookingInfo = $data['booking_info'];

                $data['booking_info'] = json_encode($bookingInfo);
                $data['device_info'] = json_encode($data['device_info']);

                //Check entrance data
                $data['entry_charges']          = 0;
                $data['parking_charges']        = 0;
                $data['camera_charges']         = 0;
                $data['boating_charges']        = 0;
                $data['total_charges']      = 0;


                $data['no_of_entranc_ticket']   = 0;
                $data['no_of_parking_ticket']   = 0;
                $data['no_of_camera_ticket']    = 0;
                $data['no_of_boating_ticket']   = 0;

                foreach ($bookingInfo['entrance'] as $key => $entryTicket) {
                    $data['no_of_entranc_ticket']  += $entryTicket['numbers'];
                    $data['entry_charges'] += $entryTicket['price'] * $entryTicket['numbers'] ;
                }

                if (isset($bookingInfo['camera'])) {
                    foreach ($bookingInfo['camera'] as $key => $ticket) {
                        $data['no_of_camera_ticket']  += $ticket['numbers'];
                        $data['camera_charges'] += $ticket['price'] * $ticket['numbers'] ;
                    }
                }

                if (isset($bookingInfo['parking'])) {
                    foreach ($bookingInfo['parking'] as $key => $ticket) {
                        $data['no_of_parking_ticket']  += $ticket['numbers'];
                        $data['parking_charges'] += $ticket['price'] * $ticket['numbers'] ;
                    }
                }

                if (isset($bookingInfo['boating'])) {
                    foreach ($bookingInfo['boating'] as $key => $ticket) {
                        $data['no_of_boating_ticket']  += $ticket['numbers'];
                        $data['boating_charges'] += $ticket['price'] * $ticket['numbers'] ;
                    }
                }

                $totalArray = ['entry_charges', 'parking_charges', 'camera_charges','boating_charges'];

                foreach ($totalArray as $key => $value) {
                    $data['total_charges'] += $data[$value];
                }

                $data['amount_with_tax'] = $data['total_charges'];
                $data['mode_of_payment'] = 'Cash';
                $data['booking_source'] = 'Offline';
                $data['booking_status'] = 'Success';


                $insert = \App\BirdSanctuary\birdSanctuaryBookings::create($data);

                if ($insert) {
                    return \Response::json($success);
                }else{
                    return \Response::json($failure);
                }

            }else{
                $failure['message'] = 'Duplicate sync!!';
                return \Response::json($success);
            }

            return \Response::json($success);
        } catch (\Exception $e) {
            $failure['message'] = $e->getMessage();
            return \Response::json($failure);

        }
    }

    public function requiredFormat($input, $inputType)
    {
        $returnData = [];

        foreach ($input as $key => $value) {
            // if ($inputType == 'boating') {
            //  $returnData[$value['id']] = $value['boat_name'].':'.$value['name'];
            // }else{
                $returnData[$value['id']] = $value['name'];
            // }
        }

        return $returnData;
    }

    public function dayReport(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{

            $content_json = $request->getContent();
            $data      = json_decode($content_json, true);

            $entranceMaster = \App\BirdSanctuary\birdSanctuaryEntryTypes::where('type',1)->get()->toArray();

            foreach ($entranceMaster as $key => $value) {
                $arrayWithKeys['EN:'. $value['name']] = 0;
                $arrayWithKeys['EN:'. $value['name']. " Total"] = 0;
            }

            $parkingMaster = \App\BirdSanctuary\parkingVehicleType::all()->toArray();

            foreach ($parkingMaster as $key => $value) {
                $arrayWithKeys['PA:'. $value['type']] = 0;
                $arrayWithKeys['PA:'. $value['type']. " Total"] = 0;
            }

            $cameraMaster = \App\BirdSanctuary\cameraType::all()->toArray();

            foreach ($cameraMaster as $key => $value) {
                $arrayWithKeys['CA:'. $value['type']] = 0;
                $arrayWithKeys['CA:'. $value['type']. " Total"] = 0;
            }

            $boatingMaster = \App\BirdSanctuary\boatType::all()->toArray();
            $birdSanctuaryPricingMasters = \App\BirdSanctuary\birdSanctuaryPricingMasters::all()->toArray();

            foreach ($boatingMaster as $key => $value) {
                // if (!$value['full_booking']) {
                    foreach ($birdSanctuaryPricingMasters as $key => $pricingMast) {
                        $arrayWithKeys['BO:'.$pricingMast['name']] = 0;
                        $arrayWithKeys['BO:'.$pricingMast['name']. " Total"] = 0;
                    }
                // }else{
                //      $arrayWithKeys['BO:'. $value['name']] = 0;
                //      $arrayWithKeys['BO:'. $value['name']] = 0;
                // }
            }

            $arrayWithKeys['checkIn'] = 0;
            $arrayWithKeys['display_id'] = 0;
            $arrayWithKeys['total_charges'] = 0;
            $arrayWithKeys['service_charges'] = 0;
            $arrayWithKeys['gst_charges'] = 0;
            $arrayWithKeys['amount_with_tax'] = 0;

            $outputArray = $arrayWithKeys;
            $startDate = $data['date'];
        // echo "<pre>"; print_r($outputArray);exit();


            //Get the masters of Entrance, Camera, Parking, Boating
            $getEntryPricing = \App\BirdSanctuary\birdSanctuaryPrice::join('birdSanctuaryPricingMasters', 'birdSanctuaryEntryFee.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                    ->select('birdSanctuaryPricingMasters.name', 'birdSanctuaryEntryFee.id')
                    ->get()
                    ->toArray();

            $entryPricing  = $this->requiredFormat($getEntryPricing, 'entry');

            $getCameraPricing =  \App\BirdSanctuary\cameraFee::leftJoin('birdSanctuaryCameraType', 'birdSanctuaryCameraType.id','=','birdSanctuaryCameraFee.cameratype_id')
                                ->select('birdSanctuaryCameraType.type as name', 'birdSanctuaryCameraFee.id')
                                ->get()->toArray();

            $cameraPricing  = $this->requiredFormat($getCameraPricing, 'camera');

            $getBoatingPricing =  \App\BirdSanctuary\boatTypePrice::leftJoin('birdSanctuaryBoatType', 'birdSanctuaryBoatType.id','=','birdSanctuaryBoatTypePrice.boatType_id')
                                ->join('birdSanctuaryPricingMasters', 'birdSanctuaryBoatTypePrice.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                                ->select('birdSanctuaryBoatType.name as boat_name', 'birdSanctuaryPricingMasters.name', 'birdSanctuaryBoatTypePrice.id')
                                ->get()->toArray();

            $boatingPricing  = $this->requiredFormat($getBoatingPricing, 'boating');

            $getParkingPricing = \App\BirdSanctuary\parkingFee::
                        leftJoin('birdSanctuaryParkingVehicleType', 'birdSanctuaryParkingVehicleType.id','=', 'birdSanctuaryParkingFee.vehicletype_id')
                        ->select('birdSanctuaryParkingVehicleType.type as name', 'birdSanctuaryParkingFee.id')
                        ->get()
                        ->toArray();
            $parkingPricing  = $this->requiredFormat($getParkingPricing, 'parking');


            $getRow = \App\BirdSanctuary\birdSanctuaryBookings::whereDate('date_of_booking', '=', $startDate)
                ->where('birdSanctuary_id', 1)
                ->where('user_id', $data['userId'])
                ->where('booking_status','Success')
                ->get()->toArray();


            // echo "<pre>"; print_r($getRow);exit();

            $mainKeys = ['CA' => 'camera', 'BO' => 'boating', 'PA' => 'parking' , 'EN' => 'entrance'];

            foreach ($getRow as $key => $records) {
                $bookingInfo = json_decode($records['booking_info'], true);

                $getDateOfBooking = explode(" ", $records['date_of_booking']) ;

                // echo "<pre>"; print_r($outputArray[$dateOfBooking]);exit();

                foreach ($mainKeys as $key2 => $index) {
                    if (isset($bookingInfo[$index])) {
                        foreach ($bookingInfo[$index] as $key3 => $row) {
                            $amount = $row['numbers'] * $row['price'];

                            if ($index == 'entrance') {
                                $name = $entryPricing[$row['id']];
                            }elseif($index == 'camera'){
                                $name = $cameraPricing[$row['id']];

                            }elseif($index == 'boating'){
                                $name = $boatingPricing[$row['id']];

                            }elseif($index == 'parking'){
                                $name = $parkingPricing[$row['id']];
                            }

                            $outputArray[$key2.":".$name] += $row['numbers'];
                            $outputArray[$key2.":".$name.' Total'] += $amount;

                            // $grandTotalRow[$key2.":".$name] = $row['numbers'];
                            // $grandTotalRow[$key2.":".$name.' Total'] += $amount;
                        }

                    }
                }

                $outputArray['checkIn'] = $records['checkIn'];
                $outputArray['display_id'] = $records['display_id'];
                $outputArray['total_charges'] += $records['total_charges'];
                $outputArray['service_charges'] += $records['service_charges'];
                $outputArray['gst_charges'] += $records['gst_charges'];
                $outputArray['amount_with_tax'] += $records['amount_with_tax'];
            }

            // echo "<pre>"; print_r($getRow);exit();

            if (count($outputArray) > 0) {
                $success['data'] = $outputArray;
                return \Response::json($success);

            }else{
                $failure['message'] =  'Sorry could not process. No data';
                return \Response::json($failure);
            }
        }catch (\Exception $e) {
            echo "$e";exit;
            $failure['message'] = $e->getMessage();
            return \Response::json($failure);
        }
    }

}
