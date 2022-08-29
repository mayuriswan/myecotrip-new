<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
    	// $request->session()->flush();
        $request->session()->forget('userId');
    	$adminTypes = \App\AdminType::where('status', 1)->get()->toArray();
    	return view('Admin/login', ['adminTypes'=> $adminTypes]);
    }

    public function parkLogin(Request $request)
    {
        // $request->session()->flush();
        $request->session()->forget('userId');
        return view('Admin/parkLogin');
    }

    public function circleLogin(Request $request)
    {
        // $request->session()->flush();
        $request->session()->forget('userId');
        return view('Admin/circleLogin');
    }

    public function myAdminLogin(Request $request)
    {
        // $request->session()->flush();
        $request->session()->forget('userId');
        return view('Admin/myAdminLogin');
    }

    public function agentLogin(Request $request)
    {
        // $request->session()->flush();
        $request->session()->forget('userId');
        return view('Admin/agentLogin');
    }

    public function doLogin(Request $request)
    {
    	$success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
        	'adminType' => 'required',
        	'email' => 'required',
        	'password' => 'required',
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('adminHome');
        }else{
            try{
            	$adminType = $content['adminType'];
                session(['adminType' => $adminType]);
                
            	switch ($adminType) {
    	       		case '1':
    	       			$login = $this->trailAdminLogin($request, $content);
    	       			if ($login['status']) {
                            return redirect()->route('trailBookings');
    	       				// return view('Admin/adminPages/trails/index');
    	       			}else{
    	       				Session::flash('message', $login['message']); 
			                Session::flash('alert-class', 'alert-danger');  
			                
			                return redirect()->route('adminHome');
    	       			}
    	       			break;
    	       		case '2':
        	       		if ($content['email'] == 'admin@myecotrip.com' && $content['password'] == 'CaDJzE8y8r3rGufG') {
        	       			
        	       			// Set user session data
    		                session(['userId' => 'Admin']);
    		                session(['adminName' => 'Admin']);
    		                session(['trailId' => 0]);

                            return view('Admin/adminPages/superAdmin/index');

        	       		}elseif ($content['email'] == 'admin@myecotrip.com' && $content['password'] == 'vinay') {
                            
                            // Set user session data
                            session(['userId' => 'Admin']);
                            session(['adminName' => 'Admin']);
                            session(['trailId' => 0]);

                            return redirect('cms');

                            // return view('cms::superAdmin.index');

                        }else{
        	       			Session::flash('message', 'Invalid User'); 
    		                Session::flash('alert-class', 'alert-danger');  
    		                
    		                return redirect()->route('adminHome');
        	       		}
    	       			break;
    	       	}       	

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not process.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                return redirect()->route('adminHome');
            }
    	}
    }

    public function trailAdminLogin(Request $request, $inputData)
    {
    	$status = [];

    	// check for the email already exist
        $checkEmail = \App\TrailAdmin::where('email',$inputData['email'])->get()->toArray();

        if(count($checkEmail) > 0){
            $password = md5($inputData['password']);  

            $checkUser  = \App\TrailAdmin::where('email',$inputData['email'])
                                    ->where('password', $password)
                                    ->get()
                                    ->toArray();

            if (count($checkUser) > 0) {

                // Set user session data
                session(['userId' => $checkUser[0]['id']]);
                session(['adminName' => $checkUser[0]['name']]);
                session(['trailId' => $checkUser[0]['trail_id']]);

                $status['status'] = 1;
                $status['message'] = '';
                return $status;
            }else{
                $message = "Sorry credentials did not match !!";

                $status['status'] = 0;
                $status['message'] = $message;

                return $status;
            }
        }else{
            $message = "Sorry this email is not registered !!";
            $status['status'] = 0;
            $status['message'] = $message;
            return $status;
        }
    }

    public function doParkLogin(Request $request)
    {
        $request->session()->forget('userId');

        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('parkLogout');
        }else{
            try{
                $login = $this->parkAdminLogin($request, $content);
                if ($login['status']) {
                    return redirect()->route('parkBookings');
                }else{
                    Session::flash('message', $login['message']); 
                    Session::flash('alert-class', 'alert-danger');  
                    
                    return redirect()->route('parkLogout');
                }

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not process.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                return redirect()->route('parkLogout');
            }
        }
    }

    public function parkAdminLogin(Request $request, $inputData)
    {
        $status = [];

        // check for the email already exist
        $checkEmail = \App\ParkAdmin::where('email',$inputData['email'])->get()->toArray();

        if(count($checkEmail) > 0){
            $password = md5($inputData['password']);  

            $checkUser  = \App\ParkAdmin::where('email',$inputData['email'])
                                    ->where('password', $password)
                                    ->get()
                                    ->toArray();

            if (count($checkUser) > 0) {

                // Set user session data
                session(['userId' => $checkUser[0]['id']]);
                session(['adminName' => $checkUser[0]['name']]);
                session(['parkId' => $checkUser[0]['park_id']]);

                $status['status'] = 1;
                $status['message'] = '';
                return $status;
            }else{
                $message = "Sorry credentials did not match !!";

                $status['status'] = 0;
                $status['message'] = $message;

                return $status;
            }
        }else{

            $message = "Sorry this email is not registered !!";
            
            $status['status'] = 0;
            $status['message'] = $message;

            return $status;
        }
    }

    public function doCircleLogin(Request $request)
    {
        $request->session()->forget('userId');

        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('circleLogout');
        }else{
            try{
                $login = $this->circleAdminLogin($request, $content);
                if ($login['status']) {
                    return redirect()->route('circleBookings');
                }else{
                    Session::flash('message', $login['message']); 
                    Session::flash('alert-class', 'alert-danger');  
                    
                    return redirect()->route('circleLogout');
                }

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not process.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                return redirect()->route('circleLogout');
            }
        }
    }

    public function circleAdminLogin(Request $request, $inputData)
    {
        $status = [];

        // check for the email already exist
        $checkEmail = \App\CircleAdmin::where('email',$inputData['email'])->get()->toArray();

        if(count($checkEmail) > 0){
            $password = md5($inputData['password']);  

            $checkUser  = \App\CircleAdmin::where('email',$inputData['email'])
                                    ->where('password', $password)
                                    ->get()
                                    ->toArray();

            if (count($checkUser) > 0) {

                // Set user session data
                session(['userId' => $checkUser[0]['id']]);
                session(['adminName' => $checkUser[0]['name']]);
                session(['circleId' => $checkUser[0]['circle_id']]);

                $status['status'] = 1;
                $status['message'] = '';
                return $status;
            }else{
                $message = "Sorry credentials did not match !!";

                $status['status'] = 0;
                $status['message'] = $message;

                return $status;
            }
        }else{

            $message = "Sorry this email is not registered !!";
            
            $status['status'] = 0;
            $status['message'] = $message;

            return $status;
        }
    }

    public function doMyAdminLogin(Request $request)
    {
        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $content      = $request->all();

        if ($content['email'] == 'myAdmin@myecotrip.com' && $content['password'] == 'myAdmin') {
                        
            // Set user session data
            session(['userId' => 'myAdmin']);
            session(['adminName' => 'Admin']);
            session(['trailId' => 0]);

            return view('Admin/adminPages/myAdmin/index');
        }else{
            Session::flash('message', 'Invalid User'); 
            Session::flash('alert-class', 'alert-danger');  
            
            return redirect()->route('agentlogout');
        }
    }

    public function doAgentLogin(Request $request)
    {
        $request->session()->forget('userId');

        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('agentlogout');
        }else{
            try{
                $login = $this->checkAgent($request, $content);
                if ($login['status']) {
                    return redirect()->route('agentBookings');
                }else{
                    Session::flash('message', $login['message']); 
                    Session::flash('alert-class', 'alert-danger');  
                    
                    return redirect()->route('agentlogout');
                }

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not process.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                
                return redirect()->route('agentlogout');
            }
        }
    }

    public function checkAgent(Request $request, $inputData)
    {
        $status = [];

        // check for the email already exist
        $checkEmail = \App\Agents::where('email',$inputData['email'])->get()->toArray();

        if(count($checkEmail) > 0){
            $password = md5($inputData['password']);  

            $checkUser  = \App\Agents::where('email',$inputData['email'])
                                    ->where('password', $password)
                                    ->get()
                                    ->toArray();

            if (count($checkUser) > 0) {

                // Set user session data
                session(['userId' => $checkUser[0]['id']]);
                session(['adminName' => $checkUser[0]['name']]);
                session(['email' => $checkUser[0]['email']]);

                $status['status'] = 1;
                $status['message'] = '';
                return $status;
            }else{
                $message = "Sorry credentials did not match !!";

                $status['status'] = 0;
                $status['message'] = $message;

                return $status;
            }
        }else{

            $message = "Sorry this email is not registered !!";
            
            $status['status'] = 0;
            $status['message'] = $message;

            return $status;
        }
    }
}
