<?php

namespace Modules\BirdSanctuary\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        // echo "<pre>";print_r($request->session()->get('birdSanctuaryId')); exit;
        return view('birdsanctuary::CMS.SuperAdmin.Reports.monthly-tickets');
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
        try {
            $content = $_POST;
            $content['birdSanctuaryIds'] = $request->session()->get('birdSanctuaryId');

    		$getMonthYear = explode("-", $content['selectMonth']);

    		//Days of the month
    		$monthsDays=array();
    		$month = $getMonthYear[1];
    		$year = $getMonthYear[0];

            // echo "string"; exit;
    		for($d=1; $d<= cal_days_in_month(CAL_GREGORIAN, $month, $year) ; $d++)
    		{
    		    $time=mktime(12, 0, 0, $month, $d, $year);
    		    if (date('m', $time)==$month)
    		        $monthsDays[]=date('Y-m-d', $time);
    		}

    		$arrayWithKeys = [];
    		$arrayWithKeys['date_of_booking'] = 0;


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
    			// 		$arrayWithKeys['BO:'. $value['name']] = 0;
    			// 		$arrayWithKeys['BO:'. $value['name']] = 0;
    			// }
    		}

    		$arrayWithKeys['total_charges'] = 0;
    		$arrayWithKeys['service_charges'] = 0;
    		$arrayWithKeys['gst_charges'] = 0;
    		$arrayWithKeys['amount_with_tax'] = 0;

    		$grandTotalRow = $arrayWithKeys;
    		$grandTotalRow['date_of_booking'] = "Grand total";

    		// echo "<pre>"; print_r($arrayWithKeys);exit();

    		foreach ($monthsDays as $key => $value) {
    			$outputArray[$value] = $arrayWithKeys;
    			$outputArray[$value]['date_of_booking'] = $value;
    		}

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

    		// echo "<pre>"; print_r($content['selectMonth']);exit();
			$startDate = $content['selectMonth'].'-01';
		    $endDate = $this->firstDayOfNextMonth($startDate);

            $getRow = \App\BirdSanctuary\birdSanctuaryBookings::whereBetween('date_of_booking', array($startDate, $endDate))
				->where('birdSanctuary_id', $content['birdSanctuaryIds'])
				->where('booking_status', 'Success')
				->get()->toArray();


			// echo "<pre>"; print_r($getRow);exit();

			$mainKeys = ['CA' => 'camera', 'BO' => 'boating', 'PA' => 'parking' , 'EN' => 'entrance'];

			foreach ($getRow as $key => $records) {
				$bookingInfo = json_decode($records['booking_info'], true);

				$getDateOfBooking = explode(" ", $records['date_of_booking']) ;
				$dateOfBooking =  $getDateOfBooking[0];

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

							$outputArray[$dateOfBooking][$key2.":".$name] += $row['numbers'];
							$outputArray[$dateOfBooking][$key2.":".$name.' Total'] += $amount;

							$grandTotalRow[$key2.":".$name] += $row['numbers'];
							$grandTotalRow[$key2.":".$name.' Total'] += $amount;
						}

					}
				}

				$outputArray[$dateOfBooking]['total_charges'] += $records['total_charges'];
				$outputArray[$dateOfBooking]['service_charges'] += $records['service_charges'];
				$outputArray[$dateOfBooking]['gst_charges'] += $records['gst_charges'];
				$outputArray[$dateOfBooking]['amount_with_tax'] += $records['amount_with_tax'];

                $grandTotalRow['total_charges'] += $records['total_charges'];
                $grandTotalRow['service_charges'] += $records['service_charges'];
                $grandTotalRow['gst_charges'] += $records['gst_charges'];
				$grandTotalRow['amount_with_tax'] += $records['amount_with_tax'];

			}

			// array_unshift($grandTotalRow , 'Grand Total');
			$outputArray[] = $grandTotalRow;
			// echo "<pre>"; print_r($outputArray);exit();

			if (count($outputArray) > 0) {
		    	$fileName = 'Report_'.$content['selectMonth'];
		    	$this->downloadAsXlsx($fileName, $outputArray);
		    }else{
		    	Session::flash('message', 'Sorry could not process. No data');
	            Session::flash('alert-class', 'alert-danger');

	            $data =  $request->session()->get('_previous');
            	return \Redirect::to($data['url']);
	        }

        } catch (Exception $e) {
            \Session::flash('alert-danger', 'Sorry could not process !!');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function requiredFormat($input, $inputType)
	{
		$returnData = [];

		foreach ($input as $key => $value) {
			// if ($inputType == 'boating') {
			// 	$returnData[$value['id']] = $value['boat_name'].':'.$value['name'];
			// }else{
				$returnData[$value['id']] = $value['name'];
			// }
		}

		return $returnData;
	}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('birdsanctuary::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
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
