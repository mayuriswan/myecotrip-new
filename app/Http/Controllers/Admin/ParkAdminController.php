<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class ParkAdminController extends Controller
{
    public function getParkAdmins(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$parkAdminList = \App\ParkAdmin::all()->toArray();

            foreach ($parkAdminList as $index => $adminList) {
                // get the park name
                $getName = \App\Parks::where('id',$adminList['park_id'])->select('name')->get()->toArray();

                $parkAdminList[$index]['parkName'] = $getName[0]['name']; 
            }

        	return view('Admin/admins/Park/park', ['parkAdminList'=> $parkAdminList]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('getParkAdmins');
        }
    }

    public function addParkAdmin(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        try {
        	// get the parkList
        	$parkList = \App\Parks::all()->toArray();


        	return view('Admin/admins/Park/addPark', ['parkList'=> $parkList]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }


    public function createParkAdmin(Request $request)
    {
    	$success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
        	'email' => 'required',
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('getParkAdmins');
        }else{
            try{
            	unset($content['_token']);
            	unset($content['confirmPassword']);
            	// echo "<pre>";print_r($content);exit();

            	$checkEmail = \App\ParkAdmin::where('email',$content['email'])->where('designation',$content['designation'])->get()->toArray();

            	if (count($checkEmail) > 0) {
        		 	Session::flash('message', 'Sorry!! This Email is already registred to this park'); 
		            Session::flash('alert-class', 'alert-danger');

		            return redirect()->route('getParkAdmins');
            	}else{
                    $content['password'] = md5($content['password']);
            		$create = \App\ParkAdmin::create($content);

            		Session::flash('message', 'Admin added successfully'); 
					Session::flash('alert-class', 'alert-success');

    				return redirect()->route('getParkAdmins');
            	}

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not insert.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                return redirect()->route('getParkAdmins');
            }
    	}
    }

    public function editParkAdmin(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('getParkAdmins');

        }else{
            try{
                // Get the trail details
                $adminData = \App\ParkAdmin::where('id', [$content['id']])->get()->toArray();
                
                // get the trails
                $parkList = \App\Parks::all()->toArray();

                if(count($adminData) > 0){

                    return view('Admin/admins/Park/editPark')->with(array('adminData'=>$adminData[0], 'parkList' => $parkList));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again.');
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getParkAdmins');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getParkAdmins');
            }
        }
    }

    public function updateParkAdmin(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content = $request->all();

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
            'id' => 'required'
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('getParkAdmins');

        }else{
            try{
                $checkEmail = \App\ParkAdmin::where('email',$content['email'])->where('designation',$content['designation'])->where('id','!=', $content['id'])->get()->toArray();

                if (count($checkEmail) > 0) {
                    Session::flash('message', 'Sorry!! This Email is already registred'); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getParkAdmins');
                }else{

                    if ($content['password'] != '') {
                        $content['password'] = md5($content['password']);
                    }else{
                        unset($content['password']);
                    }

                    unset($content['_token']);
                    unset($content['confirmPassword']);

                    $create = \App\ParkAdmin::where('id',$content['id'])->update($content);

                    Session::flash('message', 'Admin data updated successfully'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('getParkAdmins');
                }
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getParkAdmins');
            }
        }
    }

    public function deletePrailAdmin(Request $request)
    {
        $success = \Config::get('common.delete_success_response');
        $failure = \Config::get('common.delete_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('getParkAdmins');

        }else{
            try{
                // Get the ciecles details
                $trailData = \App\ParkAdmin::where('id', [$content['id']])->get()->toArray();

                if(count($trailData) > 0){
                    $deleteTrail = \App\ParkAdmin::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the records.'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('getParkAdmins');

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getParkAdmins');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getParkAdmins');
            }
        }
    }

    public function parksTrails(Request $request)
    {
        $traillist = [];
        $parkId = $request->session()->get('parkId');

        // get the trails assoiated with park
        $getTrails = \App\Trail::where('park_id',$parkId)->select('id')->get()->toArray();
        foreach ($getTrails as $index => $trails) {
            $traillist[] = $trails['id'];
        }

        return $traillist;
    }

    public function parkBookings(Request $request)
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

            
            // get the trails assoiated with park
            $traillist = $this->parksTrails($request);

            // Todays dertails
            $getBooking = \App\TrailBooking::whereIn('trail_id',$traillist)
                ->where('checkIn',date("Y-m-d 00:00:00"))
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
            $getTomBooking = \App\TrailBooking::whereIn('trail_id',$traillist)
                            ->where('checkIn',$tomorrowDate)
                            ->where('booking_status','Success')
                            ->orderBy('id', 'DESC')
                            ->get()
                            ->toArray();

            // Orders placed today

            $getTodaysBooking = \App\TrailBooking::whereIn('trail_id',$traillist)->whereDate('date_of_booking','=',date("Y-m-d"))
                ->orderBy('id', 'DESC')
                ->get()
                ->toArray();

            $todaysBooking = count($getTodaysBooking);


            $dashboardfData['bookingsForToday']= count($returnData['success']);
            $dashboardfData['bookingsForTom']= count($getTomBooking);
            $dashboardfData['ordersPlacedToday']= $todaysBooking;

            // echo "<pre>";print_r($dashboardfData);exit();
            return view('Admin/adminPages/parkAdmin/bookings/index', ['getBooking'=> $returnData,'dashboardfData' =>$dashboardfData]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('parkAdminHome');
        }
    }

    public function PAtrailDetail(Request $request, $bookingId, $userId)
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
                return view('Admin/adminPages/parkAdmin/bookings/bookingDetails', ['bookingData'=> $bookingData,'userData' =>$userData[0]]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('parkAdminHome');
            }
        }else{
            return redirect()->route('parkAdminHome');
        }
    }

    public function PApreBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                // get the trails assoiated with park
                $traillist = $this->parksTrails($request);

                $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));

                // Todays dertails
                $getBooking = \App\TrailBooking::whereIn('trail_id',$traillist)
                    ->where('checkIn',$tomorrowDate)
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

                return view('Admin/adminPages/parkAdmin/bookings/preBookings', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('parkAdminHome');
            }
        }else{
            return redirect()->route('parkAdminHome');
        }
    }

    public function PAplacedToday(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                // get the trails assoiated with park
                $traillist = $this->parksTrails($request);

                // Orders placed today

                $getBooking = \App\TrailBooking::whereIn('trail_id',$traillist)
                    ->whereDate('date_of_booking','=',date("Y-m-d"))
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
                return view('Admin/adminPages/parkAdmin/bookings/placedToday', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('parkAdminHome');
            }
        }else{
            return redirect()->route('parkAdminHome');
        }
    }

    public function PASearchedBookings(Request $request)
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

                // get the trails assoiated with park
                $traillist = $this->parksTrails($request);

                $startDate = $content['selectYear'].'-'.$content['selectMonth'].'-01';
                $endDate = $content['selectYear'].'-'.$content['selectMonth'].'-31';
                // Orders placed today

                $getBooking = \App\TrailBooking::whereIn('trail_id',$traillist)
                    ->whereDate('checkIn','>=',$startDate)
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
                return view('Admin/adminPages/parkAdmin/bookings/searchBooking', ['getBooking'=> $returnData, 'selectedDate' => $content]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('parkAdminHome');
            }
        }
    }

    public function parksTrailsWithName($request)
    {
        $returnData = [];
        $traillist = [];
        $trailIds = [];
        $parkId = $request->session()->get('parkId');

        // get the trails assoiated with park
        $getTrails = \App\Trail::where('park_id',$parkId)->select('id','name')->get()->toArray();
        foreach ($getTrails as $index => $trails) {
            $trailIds[] = $trails['id'];
            $traillist[$trails['id']] = $trails['name'];
        }

        $allValue = implode(',', $trailIds);

        $returnData['traillist'] = $traillist;
        $returnData['allValue'] = $allValue;
        return $returnData;
    }

    public function PAbookingReports(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                // get the trails assoiated with park
                $returnData = $this->parksTrailsWithName($request);

                // echo "<pre>";print_r($traillist);exit();
                return view('Admin/adminPages/parkAdmin/reports/index', ['traillist'=> $returnData['traillist'], 'allValue' => $returnData['allValue']]);
                        
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('parkAdminHome');
            }
        }
    }
}
