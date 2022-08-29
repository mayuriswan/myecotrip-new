<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CronController extends Controller
{
    public function smsReport(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
                // Tomorrow details
                $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));
                $smsDate = date("D, d-m-Y", strtotime('tomorrow'));
                $tomorrowsmsDate = date("jS F Y", strtotime($smsDate));

                $trailList = \App\Trail::where('status', 1)->select('id','name','park_id')->get()->toArray();
                $output = [];
                foreach ($trailList as $id => $trails) {
                    $appendArray = $trails;
                    $numberOfTrekkers = \App\TrailBooking::where('trail_id', $trails['id'])
                                                    ->where('booking_status','Success')
                                                    ->where('checkIn',$tomorrowDate)
                                                    ->sum('total_trekkers');

                    if ($numberOfTrekkers == null) {
                        $numberOfTrekkers = 0;
                    }

                    // Send sms to trail admins
                    $getAdminDetails = \App\TrailAdmin::where('trail_id',$trails['id'])
                                                    ->where('status',1)
                                                    ->select('name','phone_no')->get()->toArray();

                    foreach ($getAdminDetails as $admin) {

                        $msg = "Dear ".$admin['name'] .", We have received $numberOfTrekkers bookings for ".$appendArray["name"]." trek on $smsDate. Please login into www.myecotrip.com/admin for booking details. Thank you.";
                        $this->sendSMS($admin['phone_no'],$msg);

                    }

                    $appendArray['bookings'] = $numberOfTrekkers;

                    $output[$trails['park_id']][] = $appendArray;
                }

                // Park Admin
                $parkList = \App\Parks::select('id','name','circle_id','name')->get()->toArray();

                // get parks
                foreach ($parkList as $id => $park) {
                    $parkBooking = 0;
                    if (isset($output[$park['id']])) {
                        $circleArray[$park['circle_id']][$park['id']] = $output[$park['id']];

                        foreach ($output[$park['id']] as $key => $value) {
                            $parkBooking += $value['bookings'];
                        }

                    }

                    $circleArray[$park['circle_id']][$park['id']]['booking'] =  $parkBooking;

                    // Send sms to Park admins
                    $getAdminDetails = \App\ParkAdmin::where('park_id',$park['id'])
                                                    ->where('status',1)
                                                    ->select('name','phone_no')->get()->toArray();

                    foreach ($getAdminDetails as $admin) {
                        $msg = "Dear ".$admin['name'] .", We have received $parkBooking bookings for treks in ".$park['name']." Division on $smsDate. Please login into www.myecotrip.com/parkAdmin for booking details. Thank you.";

                        $this->sendSMS($admin['phone_no'],$msg);

                    }

                }

                $totalBookings = 0;
                // Circle Admin
                foreach ($circleArray as $circleId => $value2) {
                    $circleBookings = 0;
                    foreach ($value2 as $key => $parks) {
                        $circleBookings += $parks['booking'];
                    }

                    $totalBookings += $circleBookings;

                    // circle details
                    $circleDetails = \App\Circle::where('id',$circleId)->select('name')->get()->toArray();

                    $getAdminDetails = \App\CircleAdmin::where('circle_id',$circleId)
                                                    ->where('status',1)
                                                    ->select('name','phone_no')->get()->toArray();

                    foreach ($getAdminDetails as $admin) {
                        $msg = "Dear ".$admin['name'] .", We have received $circleBookings bookings for treks in ".$circleDetails[0]['name']." on $smsDate. Please to http://bit.ly/2eXskVa for booking details. Thank you.";

                        $this->sendSMS($admin['phone_no'],$msg);

                    }
                }

                // Myecotrip Admin
                $getAdminDetails = \App\MyAdmins::where('status',1)
                                                 ->select('name','phone_no')->get()->toArray();

                $msg = "Dear Sir, We have received $totalBookings bookings for EcoTrails on $smsDate. Please login into www.myecotrip.com/admin for booking details. Thank you.";


                foreach ($getAdminDetails as $admin) {
                    $this->sendSMS($admin['phone_no'],$msg);
                    $this->writeLog('SMSreports.log', $admin['phone_no'] . " : " . $e->getMessage() );
                }

                // Trinity admins
                $trinityAdmins = \Config::get('common.smsReports');

                foreach ($trinityAdmins as $phoneNo) {
                    $this->sendSMS($phoneNo,$msg);
                }

                echo "Done";

            } catch (Exception $e) {
                $this->writeLog('SMSreports.log', $e->getMessage() );
        }
    }

    public function trailEmailReports(Request $request)
    {
        // Tomorrow details
        $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));
        $fileDate = date("Y-m-d", strtotime('tomorrow'));
        $pathToDownload = \Config::get('common.trailReportExports');

        // Trail Details
        $trailData = \App\Trail::select('id','name')->get()->toArray();
        foreach ($trailData as $key => $trail) {
            $trailName = $trail['name'];
            $trailId = $trail['id'];

            $outputArray = $this->getOutputArrayBs($tomorrowDate, $trailId);

            // print_r($outputArray);exit();
            if (count($outputArray) > 0) {
                $fileName = $trailName.'_'.$fileDate;
                $download = $this->downloadAsXlsxForReport($fileName, $outputArray, $pathToDownload);

                // Send sms to trail admins
                $getAdminDetails = \App\TrailAdmin::where('trail_id',$trail['id'])
                                                ->where('status',1)
                                                ->select('name','email')->get()->toArray();

                foreach ($getAdminDetails as $admin) {
                    $email = $admin['email'];
                    $toName = $admin['name'];
                    $ccTo = [];
                    $subject = \Config::get('common.trailAdminEmailSubject') . $fileDate;
                    $body = "Dear $toName, <br /> PFA for the booking details.";
                    $attachement['path'] = $pathToDownload.$fileName.'.xlsx';
                    $attachement['name'] = $fileName;

                    $attachements[] = $attachement;

                    $this->sendEmail($email, $toName, $ccTo, $subject, $body, $attachements);

                    $this->writeLog('SMSreports.log', $email . " : " . $attachement['path'] );
                    // Delete file
                    \File::delete($attachement['path']);
                }
            }
        }

        echo "Done";
    }

    public function downloadAsXlsxForReport($fileName, $data, $pathToDownload)
    {

        return \Excel::create($fileName, function($excel) use ($data) {
            $excel->sheet('Items', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->store('xlsx', $pathToDownload);

    }

    public function getOutputArrayBs($date, $traillist)
    {
        $outputArray = [];
        $Items = [];


        $getBooking = \App\TrailBooking::where('trail_id',$traillist)
                    ->where('checkIn',$date)
                    ->where('booking_status', 'Success')
                    ->get()
                    ->toArray();

        foreach ($getBooking as $index => $bookings) {
            // get the trail name
            $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

            // Trail Details
            $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();

            $getBooking[$index]['user'] = $getName[0]['first_name'];
            $getBooking[$index]['phone_no'] = $getName[0]['contact_no'];
            $getBooking[$index]['email'] = $getName[0]['email'];
            $getBooking[$index]['trailName'] = $trailData[0]['name'];

            $unsetItems = ['user_id','trail_id','amountWithTax','booking_status', 'gatewayResponse','gatewayResponse','created_at','updated_at','amount'];

            foreach ($unsetItems as $unsetKeys) {
                unset($getBooking[$index][$unsetKeys]);
            }
            $Items[] = $getBooking[$index];

        }

        $addPassengersData = $this->addPassengersData($Items);

        $downloadKeys = ['SlNo'=>'id','bookingId'=>'display_id','name'=>'name','age'=>'age','sex'=>'sex','user'=>'user','Trail'=>'trailName','phone_no'=>'phone_no','email'=>'email','Date of booking'=>'date_of_booking','checkIn'=>'checkIn'];

        $outputArray = [];
        foreach ($addPassengersData as  $index => $value) {
            foreach ($downloadKeys as $displayKey => $dbKey) {
                $outputArray[$index][$displayKey] = $value[$dbKey];
            }
        }

        // echo "<pre>";print_r($outputArray);exit();
        return $outputArray;
    }

    public function addPassengersData($bookingData)
    {
        $returnArray = [];
        foreach ($bookingData as $key => $bookings) {
            $commonData = $bookings;
            $trekkersDetails = json_decode($bookings['trekkers_details'],true);
            $noOfTrekkers = $bookings['number_of_trekkers'];

            unset($commonData['trekkers_details']);
            unset($commonData['number_of_trekkers']);
            $commonData['checkIn'] = substr($commonData['checkIn'],0,10);

            foreach ($trekkersDetails as $key => $passenger) {
                $record = $commonData;
                $record['name']  = $passenger['name'];
                $record['age']  = $passenger['age'];
                $record['sex']  = $passenger['sex'];

                $returnArray[] = $record;
            }
        }

        return $returnArray;
    }

    public function bsDialySmsReport(Request $request)
    {
        $arrayWithKeys = [];

        $birdSanctuaryPricingMasters = \App\BirdSanctuary\birdSanctuaryPricingMasters::all()->toArray();

        foreach ($birdSanctuaryPricingMasters as $key => $value) {
            $arrayWithKeys['ENT:'. $value['bill_name']] = 0;
            $arrayWithKeys['ENT:'. $value['bill_name']. "-Total"] = 0;
        }

        $parkingMaster = \App\BirdSanctuary\parkingVehicleType::all()->toArray();

        foreach ($parkingMaster as $key => $value) {
            $arrayWithKeys['PRK:'. $value['bill_name']] = 0;
            $arrayWithKeys['PRK:'. $value['bill_name']. "-Total"] = 0;
        }

        $cameraMaster = \App\BirdSanctuary\cameraType::all()->toArray();

        foreach ($cameraMaster as $key => $value) {
            $arrayWithKeys['CMR:'. $value['bill_name']] = 0;
            $arrayWithKeys['CMR:'. $value['bill_name']. "-Total"] = 0;
        }

        $boatingMaster = \App\BirdSanctuary\boatType::all()->toArray();

        foreach ($boatingMaster as $key => $value) {
            if (!$value['full_booking']) {
                foreach ($birdSanctuaryPricingMasters as $key => $pricingMast) {
                    $arrayWithKeys['BTG:'.$pricingMast['bill_name']] = 0;
                    $arrayWithKeys['BTG:'.$pricingMast['bill_name']. "-Total"] = 0;
                }
            }else{
                    $arrayWithKeys['BTG:'] = 0;
                    $arrayWithKeys['BTG:'. "-Total"] = 0;
            }
        }

        $arrayWithKeys['Amount'] = 0;

        $grandTotalRow = $arrayWithKeys;

        //Get the masters of Entrance, Camera, Parking, Boating
        $getEntryPricing = \App\BirdSanctuary\birdSanctuaryPrice::join('birdSanctuaryPricingMasters', 'birdSanctuaryEntryFee.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                ->select('birdSanctuaryPricingMasters.bill_name as name', 'birdSanctuaryEntryFee.id')
                ->get()
                ->toArray();

        $entryPricing  = $this->requiredFormat($getEntryPricing, 'entry');

        $getCameraPricing =  \App\BirdSanctuary\cameraFee::leftJoin('birdSanctuaryCameraType', 'birdSanctuaryCameraType.id','=','birdSanctuaryCameraFee.cameratype_id')
                            ->select('birdSanctuaryCameraType.bill_name as name', 'birdSanctuaryCameraFee.id')
                            ->get()->toArray();

        $cameraPricing  = $this->requiredFormat($getCameraPricing, 'camera');

        $getBoatingPricing =  \App\BirdSanctuary\boatTypePrice::leftJoin('birdSanctuaryBoatType', 'birdSanctuaryBoatType.id','=','birdSanctuaryBoatTypePrice.boatType_id')
                            ->join('birdSanctuaryPricingMasters', 'birdSanctuaryBoatTypePrice.pricing_master_id', '=', 'birdSanctuaryPricingMasters.id')
                            ->select('birdSanctuaryBoatType.name as boat_name', 'birdSanctuaryPricingMasters.bill_name as name', 'birdSanctuaryBoatTypePrice.id')
                            ->get()->toArray();

        $boatingPricing  = $this->requiredFormat($getBoatingPricing, 'boating');

        $getParkingPricing = \App\BirdSanctuary\parkingFee::
                    leftJoin('birdSanctuaryParkingVehicleType', 'birdSanctuaryParkingVehicleType.id','=', 'birdSanctuaryParkingFee.vehicletype_id')
                    ->select('birdSanctuaryParkingVehicleType.bill_name as name', 'birdSanctuaryParkingFee.id')
                    ->get()
                    ->toArray();
        $parkingPricing  = $this->requiredFormat($getParkingPricing, 'parking');

        // echo "<pre>"; print_r($arrayWithKeys);exit();

        try {

            $date  = date("Y-m-d");
            // $date  = "2018-10-01";
            $arrayWithKeys['Date'] = $date;


            $getRow = \App\BirdSanctuary\birdSanctuaryBookings::whereDate('date_of_booking','=',$date)
                ->where('birdSanctuary_id', 1)
                ->where('booking_status', 'Success')
                ->get()->toArray();

            // echo "<pre>"; print_r($boatingPricing);exit();


            $mainKeys = ['CMR' => 'camera', 'BTG' => 'boating', 'PRK' => 'parking' , 'ENT' => 'entrance'];
            foreach ($mainKeys as $key2 => $index) {
                $arrayWithKeys[$key2.":Count"] = 0;
                $arrayWithKeys[$key2.":Amount"] = 0 ;
            }

            foreach ($getRow as $key => $records) {
                $bookingInfo = json_decode($records['booking_info'], true);

                $getDateOfBooking = explode(" ", $records['date_of_booking']) ;
                $dateOfBooking =  $getDateOfBooking[0];

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

                            $arrayWithKeys[$key2.":".$name] += $row['numbers'];
                            $arrayWithKeys[$key2.":".$name.'-Total'] += $amount;

                            $arrayWithKeys[$key2.":Count"] += $row['numbers'];
                            $arrayWithKeys[$key2.":Amount"] += $amount;

                            $arrayWithKeys["Amount"] += $amount;

                        }

                    }
                }
            }

            // array_unshift($grandTotalRow , 'Grand Total');
            // $outputArray[] = $grandTotalRow;
            // echo "<pre>"; print_r($arrayWithKeys);exit();

            $msg = \Config::get('SMSmessages.birdSanctuarybookingReport');

            foreach ($arrayWithKeys as $key => $value) {
                $msg = str_replace("#$key#", $arrayWithKeys[$key], $msg);
            }

            $bsAdmins = \Config::get('common.bsSmsReport');

            foreach ($bsAdmins as $key => $phoneNo) {
                $this->sendSMS($phoneNo,$msg);
            }

           return true;

        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function bsDialySyncAlert(Request $request)
    {
        $msg = \Config::get('SMSmessages.birdSanctuarySyncAlert');

        $bsAdmins = \Config::get('common.birdSanctuarySyncAlert');
        // $bsAdmins = ['8861422700'];
        // dd($bsAdmins);
        foreach ($bsAdmins as $key => $phoneNo) {
            $this->sendSMS($phoneNo,$msg);
        }

       return true;

    }

    public function requiredFormat($input, $inputType)
    {
        $returnData = [];

        foreach ($input as $key => $value) {
            $returnData[$value['id']] = $value['name'];
        }

        return $returnData;
    }

}
