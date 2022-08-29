<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class CircleController extends Controller
{
    public function getCircles(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$circlelist = \App\Circle::all()->toArray();

        	return view('Admin/circles/index', ['circleList'=> $circlelist]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('getCircles');
        }
    }

    public function addCircle(Request $request)
    {
    	$success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('getCircles');
            
        }else{
            try{
                // check for the email already exist
                $checkCircle = \App\Circle::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkCircle) > 0){
                    $failure['response']['message'] = "Sorry this circle is exist already!!";
                    Session::flash('message', 'Sorry this circle is exist already!!'); 
					Session::flash('alert-class', 'alert-danger');

    				return redirect()->route('getCircles');
                }else{
                    $create  = \App\Circle::create($content);

                    Session::flash('message', 'Circle added successfully'); 
					Session::flash('alert-class', 'alert-success');

    				return redirect()->route('getCircles');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getCircles');
            }
        }

    	// return redirect()->route('getCircles', ['id' => 1]);
    }

    public function editCircles(Request $request)
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
            return redirect()->route('getCircles');
        }else{
            try{
                // Get the ciecles details
                $circleData = \App\Circle::where('id', [$content['id']])->get()->toArray();

                if(count($circleData) > 0){
                    return view('Admin/circles/edit')->with(array('circleData'=>$circleData[0]));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getCircles');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getCircles');
            }
        }
    }

    public function updateCircle(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'circleId'   => 'required',
            'name'   => 'required',

        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('getCircles');
        }else{
            try{

                // check for the email already exist
                $checkCircle = \App\Circle::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkCircle) > 0){
                    $failure['response']['message'] = "Sorry this circle is exist already!!";
                    Session::flash('message', 'Sorry this circle is exist already!!'); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getCircles');
                }else{
                    $updateCircle = \App\Circle::where('id', [$content['circleId']])->update(array('name'=>$content['name']));

                    Session::flash('message', 'Circle updated successfully'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('getCircles');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getCircles');
            }
        }
    }

    public function deleteCircle(Request $request)
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
            return redirect()->route('getCircles');

        }else{
            try{
                // Get the ciecles details
                $circleData = \App\Circle::where('id', [$content['id']])->get()->toArray();

                if(count($circleData) > 0){
                    $updateCircle = \App\Circle::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the circle.'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('getCircles');

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getCircles');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getCircles');
            }
        }
    }
}
