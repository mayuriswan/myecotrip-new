<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class AgentAdminController extends Controller
{
	public function userDetails($bookingId)
	{
		$userData = [];
		$getBooking = \App\AgentBooking::where('id',$bookingId)
                    ->select('trekkers_details')
                    ->get()
                    ->toArray();

        $requeredKeys = ['name', 'phone_no'];
        $trekkerDetails = json_decode($getBooking[0]['trekkers_details'], true);

        if (count($trekkerDetails) > 0) {
	        $primaryPass = $trekkerDetails[0];

	        foreach ($requeredKeys as $key) {
	        	if (isset($primaryPass[$key])) {
		        	$userData[$key] = $primaryPass[$key];
	        	}else{
	    		   	$userData[$key] = ''; 		
	        	}
	        }
        }else{
        	foreach ($requeredKeys as $key) {
	    		   	$userData[$key] = ''; 		
	        }
        }
        // echo "<pre>";print_r($userData);exit();
        return $userData;
	}	

    public function agentBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                $numberOfTruckers = 0;
                $numberOfTruckersTom = 0;
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $agentId = $request->session()->get('userId');

                // Todays dertails
                $getBooking = \App\AgentBooking::where('user_id',$agentId)
                    ->where('checkIn',date("Y-m-d 00:00:00"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the user data
                    $getName = $this->userDetails($bookings['id']);

                    // get the trail name
	                $getTrailName = \App\Trail::where('id',$bookings['user_id'])->get()->toArray();

	                $getBooking[$index]['userData'] = $getName;
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
                $getTomBooking = \App\AgentBooking::where('user_id',$agentId)
                                ->where('checkIn',$tomorrowDate)
                                ->where('booking_status','Success')
                                ->orderBy('id', 'DESC')
                                ->get()
                                ->toArray();

                foreach ($getTomBooking as $index => $bookingsTom) {

                    $numberOfTruckersTom += $bookingsTom['number_of_trekkers'];
                }

                // Orders placed today

                $getTodaysBooking = \App\AgentBooking::where('user_id',$agentId)->whereDate('date_of_booking','=',date("Y-m-d"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                $todaysBooking = count($getTodaysBooking);

                // Get the maximum trekkers
                $maxTrekkers = \App\Trail::where('id',$agentId)->select('max_trekkers')->get()->toArray();

                $maxTrekkers = $maxTrekkers[0]['max_trekkers'];

                $dashboardfData['bookingsForToday']= $numberOfTruckers;
                $dashboardfData['bookingsForTom']= $numberOfTruckersTom;
                $dashboardfData['maxTrekkers']= $maxTrekkers;
                $dashboardfData['ordersPlacedToday']= $todaysBooking;

                // echo "<pre>";print_r($returnData);exit();
                return view('Admin/adminPages/agents/index', ['getBooking'=> $returnData,'dashboardfData' =>$dashboardfData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                $data =  $request->session()->get('_previous');
            	return \Redirect::to($data['url']);
            }
        }else{
            return redirect()->route('agentHome');
        }
    }

    public function agentPreBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $agentId = $request->session()->get('userId');
                $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));

                // Todays dertails
                $getBooking = \App\AgentBooking::where('user_id',$agentId)
                    ->where('checkIn',$tomorrowDate)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = $this->userDetails($bookings['id']);

                    $getBooking[$index]['userData'] = $getName;
                    
                    if ($bookings['booking_status'] == "Success") {
                        $returnData["success"][] = $getBooking[$index];
                    }else{
                        $returnData["fail"][] = $getBooking[$index];
                    }                     
                }

                // echo "<pre>";print_r($returnData);exit();
                return view('Admin/adminPages/agents/preBookings', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                $data =  $request->session()->get('_previous');
        		return \Redirect::to($data['url']);
            }
        }else{
            return redirect()->route('agentHome');
        }
    }

    public function placedToday(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $agentId = $request->session()->get('userId');

                // Orders placed today

                $getBooking = \App\AgentBooking::where('user_id',$agentId)->whereDate('date_of_booking','=',date("Y-m-d"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = $this->userDetails($bookings['id']);

                    $getBooking[$index]['userData'] = $getName;
                    
                    if ($bookings['booking_status'] == "Success") {
                        $returnData["success"][] = $getBooking[$index];
                    }else{
                        $returnData["fail"][] = $getBooking[$index];
                    }                     
                }


                // echo "<pre>";print_r($returnData);exit();
                return view('Admin/adminPages/agents/placedToday', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                $data =  $request->session()->get('_previous');
        		return \Redirect::to($data['url']);
            }
        }else{
            return redirect()->route('agentHome');
        }
    }

    public function trailDetail(Request $request, $bookingId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {

                // booking details
                $bookingData = \App\AgentBooking::where('id',$bookingId)->get()->toArray();
                $bookingData = $bookingData[0];

                $bookingData['trekkers_details'] = json_decode($bookingData
                    ['trekkers_details'],true);

                // Trail Details
                $trailData = \App\Trail::where('id',$bookingData['trail_id'])->select('name')->get()->toArray();

                $bookingData['trailName'] = $trailData[0]['name'];

                // echo "<pre>";print_r($bookingData);print_r($trailData);exit();
                return view('Admin/adminPages/agents/bookingDetails', ['bookingData'=> $bookingData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }else{
            return redirect()->route('agentHome');
        }
    }
}
