<?php

namespace App\Http\Controllers\MobileApps\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BirdSanctuaryController extends Controller
{

    public function doLogin(Request $request)
    {
        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $contentJson = $request->getcontent();
        $content     = json_decode($contentJson,true);

        $email      = $content['email'];
        $password   = $content['password'];

        $getUser = \App\BirdSanctuary\BirdSanctuaryAdmin::where('email',$email)->get()->toArray();
            
        if (count($getUser) > 0) {
            if ($getUser[0]['password'] == md5($password)) {
                unset($getUser[0]['password']);
               $success['content'] = $getUser[0];
               return \Response::json($success);
            }else{
                return \Response::json($failure);
            }
        }else{
            return \Response::json($failure);
        }
    }

    public function getPricing(Request $request, $birdSanctuaryId)
    {
	 	$success = \Config::get('common.retrieve_success_response');
    	$failure = \Config::get('common.retrieve_failure_response');
    	try {
    		//{"entrance":[{"type":1,"name":"Indian Adult","price":70.00,"shortDesc":"/ Person"},{"type":2,"name":"Foreign Adult","price":400.00,"shortDesc":"/ Person"},{"type":3,"name":"Indian Child","price":10.00,"shortDesc":"/ Child"},{"type":4,"name":"Foreign Child","price":400.00,"shortDesc":"/ Child"},{"type":5,"name":"Primary School Students","price":18.00,"shortDesc":"/ Student"},{"type":6,"name":"High school / College Students","price":35.00,"shortDesc":"/ Student"},{"type":7,"name":"Teachers / Lecturers","price":35.00,"shortDesc":"/ Person"}],"camera":[{"type":1,"name":"Less than 200 MM Lens","price":100.00,"shortDesc":"/ Camera"},{"type":2,"name":"More than 200 MM Lens","price":500.00,"shortDesc":"/ Camera"}],"parking":[{"type":1,"name":"Cycle","price":5.00,"shortDesc":"/ Vehicle"},{"type":2,"name":"Motorcycle / Scooter","price":15.00,"shortDesc":"/ Vehicle"},{"type":3,"name":"Autorickshaw","price":20.00,"shortDesc":"/ Vehicle"},{"type":4,"name":"Car / Jeep","price":50.00,"shortDesc":"/ Vehicle"},{"type":5,"name":"TT / Van / Mini bus","price":100.00,"shortDesc":"/ Vehicle"},{"type":6,"name":"Bus","price":150.00,"shortDesc":"/ Vehicle"}],"boating":[{"type":1,"name":"Normal Boat","full_booking":0,"pricing":[{"type":1,"name":"Indian Adult","price":70.00,"shortDesc":"/ Person"},{"type":2,"name":"Foreign Adult","price":400.00,"shortDesc":"/ Person"},{"type":3,"name":"Indian Child","price":30.00,"shortDesc":"/ Child"},{"type":4,"name":"Foreign Child","price":400.00,"shortDesc":"/ Child"},{"type":5,"name":"Primary School Students","price":18.00,"shortDesc":"/ Student"},{"type":6,"name":"High school / College Students","price":35.00,"shortDesc":"/ Student"},{"type":7,"name":"Teachers / Lecturers","price":35.00,"shortDesc":"/ Person"}]},{"type":2,"name":"Full Boat","full_booking":1,"pricing":[{"type":1,"name":"Indian","price":1500.00,"shortDesc":"/ Boat"},{"type":2,"name":"Foreigner","price":3000.00,"shortDesc":"/ Boat"}]},{"type":3,"name":"Photography Boat","pricing":[{"type":1,"name":"Indian","price":1500.00,"shortDesc":"/ Boat"},{"type":2,"name":"Foreigner","price":3000.00,"shortDesc":"/ Boat"}]}]}


    		$output['entrance'] = $this->entrancePricing($birdSanctuaryId);
    		$output['camera'] = $this->cameraPricing($birdSanctuaryId);
    		$output['parking'] = $this->parkingPricing($birdSanctuaryId);
    		$output['boating'] = $this->boatingPricing($birdSanctuaryId);
    		$success['content'] = $output;

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
            $checkDupliacte = \App\BirdSanctuary\birdSanctuaryBookings::where('display_id', $data['display_id'])->get()->count();

            if(!$checkDupliacte){
            	$bookingInfo = $data['booking_info'];

            	$data['booking_info'] = json_encode($bookingInfo);
            	$data['device_info'] = json_encode($data['device_info']);

            	//Check entrance data
            	$data['entry_charges'] 			= 0;
            	$data['parking_charges'] 		= 0;
            	$data['camera_charges'] 		= 0;
            	$data['boating_charges'] 		= 0;
            	$data['total_charges'] 		= 0;


            	$data['no_of_entranc_ticket'] 	= 0;
            	$data['no_of_parking_ticket'] 	= 0;
            	$data['no_of_camera_ticket'] 	= 0;
            	$data['no_of_boating_ticket'] 	= 0;

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
