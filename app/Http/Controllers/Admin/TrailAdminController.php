<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;


class TrailAdminController extends Controller
{
    public function getTrailAdmins(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$trailAdminList = \App\TrailAdmin::all()->toArray();

            foreach ($trailAdminList as $index => $adminList) {
                // get the trail name
                $getName = \App\Trail::where('id',$adminList['trail_id'])->select('name')->get()->toArray();

                $trailAdminList[$index]['trailName'] = $getName[0]['name']; 
            }

        	return view('Admin/admins/trail', ['trailAdminList'=> $trailAdminList]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('getTrailAdmins');
        }
    }

    public function addTrailAdmin(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        try {
        	// get the trailList
        	$trailList = \App\Trail::all()->toArray();


        	return view('Admin/admins/addTrail', ['trailList'=> $trailList]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function createTrailAdmin(Request $request)
    {
    	$success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
        	'name' => 'required',
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('getTrailAdmins');
        }else{
            try{
            	unset($content['_token']);
            	unset($content['confirmPassword']);
            	// echo "<pre>";print_r($content);exit();

            	$checkEmail = \App\TrailAdmin::where('email',$content['email'])->where('trail_id',$content['trail_id'])->where('designation',$content['designation'])->get()->toArray();

            	if (count($checkEmail) > 0) {
        		 	Session::flash('message', 'Sorry!! This Email is already registred to this trail'); 
		            Session::flash('alert-class', 'alert-danger');

		            return redirect()->route('getTrailAdmins');
            	}else{
                    $content['password'] = md5($content['password']);
            		$create = \App\TrailAdmin::create($content);

            		Session::flash('message', 'Trail admin added successfully'); 
					Session::flash('alert-class', 'alert-success');

    				return redirect()->route('getTrailAdmins');
            	}

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not insert.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                return redirect()->route('getTrailAdmins');
            }
    	}
    }

    public function editTrailAdmin(Request $request)
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
            return redirect()->route('getTrailAdmins');

        }else{
            try{
                // Get the trail details
                $adminData = \App\TrailAdmin::where('id', [$content['id']])->get()->toArray();
                
                // get the trails
                $trialList = \App\Trail::all()->toArray();

                if(count($adminData) > 0){

                    return view('Admin/admins/editTrail')->with(array('adminData'=>$adminData[0], 'trialList' => $trialList));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again.');
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getTrailAdmins');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }
    }

    public function updateTrailAdmin(Request $request)
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
            return redirect()->route('getTrailAdmins');

        }else{
            try{
                $checkEmail = \App\TrailAdmin::where('email',$content['email'])->where('trail_id',$content['trail_id'])->where('designation',$content['designation'])->where('id','!=', $content['id'])->get()->toArray();

                if (count($checkEmail) > 0) {
                    Session::flash('message', 'Sorry!! This Email is already registred to this trail'); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getTrailAdmins');
                }else{

                    if ($content['password'] != '') {
                        $content['password'] = md5($content['password']);
                    }else{
                        unset($content['password']);
                    }

                    unset($content['_token']);
                    unset($content['confirmPassword']);

                    $create = \App\TrailAdmin::where('id',$content['id'])->update($content);

                    Session::flash('message', 'Trail admin updated successfully'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('getTrailAdmins');
                }
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }
    }

    public function deleteTrailAdmin(Request $request)
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
            return redirect()->route('getTrailAdmins');

        }else{
            try{
                // Get the ciecles details
                $trailData = \App\TrailAdmin::where('id', [$content['id']])->get()->toArray();

                if(count($trailData) > 0){
                    $deleteTrail = \App\TrailAdmin::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the records.'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('getTrailAdmins');

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getTrailAdmins');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }
    }

    public function trailBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('trailId')) {
            try {
                $numberOfTruckers = 0;
                $numberOfTruckersTom = 0;
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $trailId = $request->session()->get('trailId');

                // Todays dertails
                $getBooking = \App\TrailBooking::where('trail_id',$trailId)
                    ->where('checkIn',date("Y-m-d 00:00:00"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                    $getBooking[$index]['userData'] = $getName[0];
                    
                    if ($bookings['booking_status'] == "Success") {
                        $returnData["success"][] = $getBooking[$index];
                        $numberOfTruckers += $bookings['number_of_trekkers'];
                    }else{
                        $returnData["fail"][] = $getBooking[$index];
                    }                     
                }

                // Tomorrow details
                $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));
                $getTomBooking = \App\TrailBooking::where('trail_id',$trailId)
                                ->where('checkIn',$tomorrowDate)
                                ->where('booking_status','Success')
                                ->orderBy('id', 'DESC')
                                ->get()
                                ->toArray();

                foreach ($getTomBooking as $index => $bookingsTom) {

                    $numberOfTruckersTom += $bookingsTom['number_of_trekkers'];
                }

                // Orders placed today

                $getTodaysBooking = \App\TrailBooking::where('trail_id',$trailId)->whereDate('date_of_booking','=',date("Y-m-d"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                $todaysBooking = count($getTodaysBooking);

                // Get the maximum trekkers
                $maxTrekkers = \App\Trail::where('id',$trailId)->select('max_trekkers')->get()->toArray();

                $maxTrekkers = $maxTrekkers[0]['max_trekkers'];

                $dashboardfData['bookingsForToday']= $numberOfTruckers;
                $dashboardfData['bookingsForTom']= $numberOfTruckersTom;
                $dashboardfData['maxTrekkers']= $maxTrekkers;
                $dashboardfData['ordersPlacedToday']= $todaysBooking;

                // echo "<pre>";print_r($returnData);exit();
                return view('Admin/adminPages/trails/index', ['getBooking'=> $returnData,'dashboardfData' =>$dashboardfData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function TAtrailDetail(Request $request, $bookingId, $userId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('trailId')) {
            try {
                $trailId = $request->session()->get('trailId');

                // booking details
                $bookingData = \App\TrailBooking::where('id',$bookingId)->get()->toArray();
                $bookingData = $bookingData[0];

                $bookingData['trekkers_details'] = json_decode($bookingData
                    ['trekkers_details'],true);

                // Trail Details
                // $trailData = \App\Trail::where('id',$trailId)->get()->toArray();

                // User details
                $userData = \App\User::where('id',$userId)->get()->toArray();

                // echo "<pre>";print_r($bookingData);print_r($userData);exit();
                return view('Admin/adminPages/trails/bookingDetails', ['bookingData'=> $bookingData,'userData' =>$userData[0]]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function TApreBookings(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('trailId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $trailId = $request->session()->get('trailId');
                $tomorrowDate = date("Y-m-d 00:00:00", strtotime('tomorrow'));

                // Todays dertails
                $getBooking = \App\TrailBooking::where('trail_id',$trailId)
                    ->where('checkIn',$tomorrowDate)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                    $getBooking[$index]['userData'] = $getName[0];
                    
                    if ($bookings['booking_status'] == "Success") {
                        $returnData["success"][] = $getBooking[$index];
                    }else{
                        $returnData["fail"][] = $getBooking[$index];
                    }                     
                }

                return view('Admin/adminPages/trails/preBookings', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }

    public function placedToday(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('trailId')) {
            try {
                $returnData["success"] = [];
                $returnData["fail"] = [];

                $trailId = $request->session()->get('trailId');

                // Orders placed today

                $getBooking = \App\TrailBooking::where('trail_id',$trailId)->whereDate('date_of_booking','=',date("Y-m-d"))
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->toArray();

                foreach ($getBooking as $index => $bookings) {
                    // get the trail name
                    $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                    $getBooking[$index]['userData'] = $getName[0];
                    
                    if ($bookings['booking_status'] == "Success") {
                        $returnData["success"][] = $getBooking[$index];
                    }else{
                        $returnData["fail"][] = $getBooking[$index];
                    }                     
                }


                // echo "<pre>";print_r($returnData);exit();
                return view('Admin/adminPages/trails/placedToday', ['getBooking'=> $returnData]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }


    public function deleteTrailImages(Request $request, $imageId)
    {
        $content      = $request->all();

        try {
            $getRow = \App\TrailImages::where('id',$imageId)->get()->toArray();

            $deleteRow  = \App\TrailImages::where('id', $getRow[0]['id'])->delete();

            if (!$getRow[0]['s3_upload']) {
                $filepath = public_path().$getRow[0]['name'];
                unlink($filepath);
            }else{
                // Delete in S3
                $getFileName = explode('trailImages', $getRow[0]['name']);

                \Storage::disk('s3')->delete('/trailImages'. $getFileName[1]);

            }

            Session::flash('message', 'Image deleted successfully');
            Session::flash('alert-class', 'alert-success');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

}
