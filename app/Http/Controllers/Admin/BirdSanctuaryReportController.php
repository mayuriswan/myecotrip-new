<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class BirdSanctuaryReportController extends Controller
{
	public function birdSanctuaryBookingReports(Request $request)
    {
        if ($request->session()->get('userId')) {
            try {
                //Get the bird sanctory list
                $getRow = \App\BirdSanctuary\birdSanctuary::where('isActive', 1)->select('id','name')->orderBy('name')->get()->toArray();

                foreach ($getRow as $key => $sanctory) {
                    $sanctoryList[$sanctory['id']] = $sanctory['name'];
                }

                // echo "<pre>";print_r($sanctoryList);exit();
                return view('Admin/adminPages/superAdmin/reports/birdSanctuary', ['sanctoryList'=> $sanctoryList]);

            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('myAdminHome');
            }
        }else{
            Session::flash('message', 'Session out');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('myAdminHome');
        }
    }

    public function downloadBirdSanctoryReport(Request $request)
    {
        $content = $_POST;
        $getMonthYear = explode("-", $content['selectMonth']);

        //Days of the month
        $monthsDays=array();
        $month = $getMonthYear[1];
        $year = $getMonthYear[0];

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

        // echo "<pre>"; print_r($boatingPricing);exit();

        try {

            $startDate = $content['selectMonth'].'-01';
            $endDate = $content['selectMonth'].'-31';

            // $getRow = \App\BirdSanctuary\birdSanctuaryBookings::whereBetween('date_of_booking', array($startDate, $endDate))

            $getRow = \App\BirdSanctuary\birdSanctuaryBookings::whereDate('date_of_booking','>=',$startDate)
                ->whereDate('date_of_booking','<=',$endDate)
                ->whereIn('birdSanctuary_id', $content['birdSanctuaryIds'])
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

                            $grandTotalRow[$key2.":".$name] = $row['numbers'];
                            $grandTotalRow[$key2.":".$name.' Total'] += $amount;
                        }

                    }
                }

                $outputArray[$dateOfBooking]['checkIn'] = $records['checkIn'];
                $outputArray[$dateOfBooking]['display_id'] = $records['display_id'];
                $outputArray[$dateOfBooking]['total_charges'] += $records['total_charges'];
                $outputArray[$dateOfBooking]['service_charges'] += $records['service_charges'];
                $outputArray[$dateOfBooking]['gst_charges'] += $records['gst_charges'];
                $outputArray[$dateOfBooking]['amount_with_tax'] += $records['amount_with_tax'];
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
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
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

}
