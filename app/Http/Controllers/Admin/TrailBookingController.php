<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class TrailBookingController extends Controller
{
    public function SAtrailBookings(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $returnData["success"] = [];
        $returnData["fail"] = [];

        try {
            $numberOfTruckers = 0;
            $numberOfTruckersTom = 0;
            $returnData["success"] = [];
            $returnData["fail"] = [];

            // Todays dertails
            $getBooking = \App\TrailBooking::where('checkIn',date("Y-m-d 00:00:00"))
                ->orderBy('id', 'DESC')
                ->get()
                ->toArray();

            foreach ($getBooking as $index => $bookings) {
                // get the trail name
                $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                // get the trail name
                $getTrailName = \App\Trail::where('id',$bookings['trail_id'])->get()->toArray();

                $getBooking[$index]['userData'] = $getName[0];
                $getBooking[$index]['trailName'] = $getTrailName[0]['name'];
                
                if ($bookings['booking_status'] == "Success") {
                    $returnData["success"][] = $getBooking[$index];
                    $numberOfTruckers += $bookings['number_of_trekkers'];
                }else{
                    $returnData["fail"][] = $getBooking[$index];
                }                     
            }

            // Tomorrow details
            $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));
            $getTomBooking = \App\TrailBooking::where('checkIn',$tomorrowDate)
                            ->where('booking_status','Success')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->toArray();

            // Orders placed today

            $getTodaysBooking = \App\TrailBooking::whereDate('date_of_booking','=',date("Y-m-d"))
                ->orderBy('id', 'DESC')
                ->get()
                ->toArray();

            $todaysBooking = count($getTodaysBooking);


            $dashboardfData['bookingsForToday']= count($returnData['success']);
            $dashboardfData['bookingsForTom']= count($getTomBooking);
            $dashboardfData['ordersPlacedToday']= $todaysBooking;

            // echo "<pre>";print_r($returnData);exit();
            return view('Admin/adminPages/superAdmin/bookings/index', ['getBooking'=> $returnData,'dashboardfData' =>$dashboardfData]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('getTrailAdmins');
        }
    }

    public function SAtrailDetail(Request $request, $bookingId, $userId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {

                // booking details
                $bookingData = \App\TrailBooking::where('id',$bookingId)->get()->toArray();
                $bookingData = $bookingData[0];

                $bookingData['trekkers_details'] = json_decode($bookingData
                    ['trekkers_details'],true);

                // Trail Details
                $trailData = \App\Trail::where('id',$bookingData['trail_id'])->select('name')->get()->toArray();

                $bookingData['trailName'] = $trailData[0]['name'];

                // User details
                $userData = \App\User::where('id',$userId)->get()->toArray();

                // echo "<pre>";print_r($bookingData);print_r($trailData);exit();
                return view('Admin/adminPages/superAdmin/bookings/bookingDetails', ['bookingData'=> $bookingData,'userData' =>$userData[0]]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function SApreBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));

                // Todays dertails
                $getBooking = \App\TrailBooking::where('checkIn',$tomorrowDate)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                    // echo "<pre>"; print_r($getBooking);exit();
                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                    // Trail Details
                    $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();
                    
                    $getBooking[$index]['userData'] = $getName[0];
                    $getBooking[$index]['trailName'] = $trailData[0]['name'];

                    if ($bookings['booking_status'] == "Success") {
                        $returnData["success"][] = $getBooking[$index];
                    }else{
                        $returnData["fail"][] = $getBooking[$index];
                    }                     
                }

                return view('Admin/adminPages/superAdmin/bookings/preBookings', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function SAplacedToday(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                // Orders placed today

                $getBooking = \App\TrailBooking::whereDate('date_of_booking','=',date("Y-m-d"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                    // Trail Details
                    $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();
                    
                    $getBooking[$index]['userData'] = $getName[0];
                    $getBooking[$index]['trailName'] = $trailData[0]['name'];

                    if ($bookings['booking_status'] == "Success") {
                        $returnData["success"][] = $getBooking[$index];
                    }else{
                        $returnData["fail"][] = $getBooking[$index];
                    }                     
                }


                // echo "<pre>";print_r($returnData);exit();
                return view('Admin/adminPages/superAdmin/bookings/placedToday', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function getSearchedBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'selectMonth' => 'required',
            'selectYear' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            
            $data =  $request->session()->get('_previous');

            return \Redirect::to($data['url']);
        }else{
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $startDate = $content['selectYear'].'-'.$content['selectMonth'].'-01';
                $endDate = $content['selectYear'].'-'.$content['selectMonth'].'-31';
                // Orders placed today

                $getBooking = \App\TrailBooking::whereDate('checkIn','>=',$startDate)
                    ->whereDate('checkIn','<=',$endDate)
                    ->where('booking_status', 'Success')
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                    // Trail Details
                    $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();
                    
                    $getBooking[$index]['userData'] = $getName[0];
                    $getBooking[$index]['trailName'] = $trailData[0]['name'];

                    $returnData["success"][] = $getBooking[$index];
                                         
                }


                // echo "<pre>";print_r($getBooking);exit();
                return view('Admin/adminPages/superAdmin/bookings/searchBooking', ['getBooking'=> $returnData, 'selectedDate' => $content]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }
    }
}
