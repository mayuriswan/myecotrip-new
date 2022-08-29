<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class MyAdminController extends Controller
{
    public function myAdmins(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$adminList = \App\MyAdmins::all()->toArray();

        	return view('Admin/admins/MyAdmin/index', ['adminList'=> $adminList]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
			
			$data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);        }
    }

    public function addMyAdmin(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        try {
        	return view('Admin/admins/MyAdmin/add');
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function createMyAdmin(Request $request)
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

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }else{
            try{
            	unset($content['_token']);
            	unset($content['confirmPassword']);
            	// echo "<pre>";print_r($content);exit();

            	$checkEmail = \App\MyAdmins::where('email',$content['email'])->get()->toArray();

            	if (count($checkEmail) > 0) {
        		 	Session::flash('message', 'Sorry!! This Email is already registred'); 
		            Session::flash('alert-class', 'alert-danger');

		            $data =  $request->session()->get('_previous');
            		return \Redirect::to($data['url']);
            	}else{
                    $content['password'] = md5($content['password']);
            		$create = \App\MyAdmins::create($content);

            		Session::flash('message', 'Admin added successfully'); 
					Session::flash('alert-class', 'alert-success');

    				$data =  $request->session()->get('_previous');
            		return \Redirect::to($data['url']);
            	}

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not insert.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                $data =  $request->session()->get('_previous');
        		return \Redirect::to($data['url']);
            }
    	}
    }

    public function editMyAdmin(Request $request)
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
            $data =  $request->session()->get('_previous');
			return \Redirect::to($data['url']);

        }else{
            try{
                // Get the trail details
                $adminData = \App\MyAdmins::where('id', [$content['id']])->get()->toArray();
                

                if(count($adminData) > 0){

                    return view('Admin/admins/MyAdmin/edit')->with(array('adminData'=>$adminData[0]));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again.');
                    Session::flash('alert-class', 'alert-danger');

                    $data =  $request->session()->get('_previous');
					return \Redirect::to($data['url']);
                }
                
            }catch(\Exception $e ){
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                $data =  $request->session()->get('_previous');
				return \Redirect::to($data['url']);
            }
        }
    }

    public function updateMyAdmin(Request $request)
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
            $data =  $request->session()->get('_previous');
			return \Redirect::to($data['url']);

        }else{
            try{
                $checkEmail = \App\MyAdmins::where('email',$content['email'])->where('id','!=', $content['id'])->get()->toArray();

                if (count($checkEmail) > 0) {
                    Session::flash('message', 'Sorry!! This Email is already registred'); 
                    Session::flash('alert-class', 'alert-danger');

                    $data =  $request->session()->get('_previous');
					return \Redirect::to($data['url']);
                }else{

                    if ($content['password'] != '') {
                        $content['password'] = md5($content['password']);
                    }else{
                        unset($content['password']);
                    }

                    unset($content['_token']);
                    unset($content['confirmPassword']);

                    $create = \App\MyAdmins::where('id',$content['id'])->update($content);

                    Session::flash('message', 'Admin data updated successfully'); 
                    Session::flash('alert-class', 'alert-success');

                    $data =  $request->session()->get('_previous');
					return \Redirect::to($data['url']);
                }
            }catch(\Exception $e ){
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                $data =  $request->session()->get('_previous');
				return \Redirect::to($data['url']);
            }
        }
    }

    public function deleteMyAdmin(Request $request)
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
            $data =  $request->session()->get('_previous');
			return \Redirect::to($data['url']);

        }else{
            try{
                // Get the ciecles details
                $trailData = \App\MyAdmins::where('id', [$content['id']])->get()->toArray();

                if(count($trailData) > 0){
                    $deleteTrail = \App\MyAdmins::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the records.'); 
                    Session::flash('alert-class', 'alert-success');

                    $data =  $request->session()->get('_previous');
					return \Redirect::to($data['url']);

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    $data =  $request->session()->get('_previous');
					return \Redirect::to($data['url']);
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                $data =  $request->session()->get('_previous');
				return \Redirect::to($data['url']);
            }
        }
    }
}
