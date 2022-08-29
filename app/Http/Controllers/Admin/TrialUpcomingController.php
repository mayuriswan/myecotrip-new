<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class TrialUpcomingController extends Controller
{
    public function trailUpcoming(Request $request)			
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
        	$datalist = \App\TrialUpcoming::all()->toArray();
        	return view('Admin/trails/upComing', ['upcomingList'=> $datalist]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function createTrailUpcoming(Request $request)
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
            
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
            
        }else{
            try{
                // check for the email already exist
                $check = \App\TrialUpcoming::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($check) > 0){
                    $failure['response']['message'] = "Sorry this trail exist already!!";
                    Session::flash('message', 'Sorry this circle is exist already!!'); 
					Session::flash('alert-class', 'alert-danger');

    				$data =  $request->session()->get('_previous');
            		return \Redirect::to($data['url']);
                }else{
                    $create  = \App\TrialUpcoming::create($content);

                    Session::flash('message', 'Trail added successfully'); 
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

    	// return redirect()->route('getCircles', ['id' => 1]);
    }

    public function editTrailUpcoming(Request $request, $upComingId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        try{
            // Get the ciecles details
            $circleData = \App\TrialUpcoming::where('id', $upComingId)->get()->toArray();

            if(count($circleData) > 0){
                return view('Admin/trails/editUpcoming')->with(array('upcomingData'=>$circleData[0]));
            }else{
                Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
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

    public function updateTrailUpcoming(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
            'name'   => 'required',

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

              //   // check for the email already exist
              //   $check = \App\TrialUpcoming::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

              //   if(count($check) > 0){
              //       Session::flash('message', 'Sorry this trail exist already!!'); 
              //       Session::flash('alert-class', 'alert-danger');

              //       $data =  $request->session()->get('_previous');
            		// return \Redirect::to($data['url']);
              //   }else{
            	unset($content['_token']);
                $updateCircle = \App\TrialUpcoming::where('id', [$content['id']])->update($content);

                Session::flash('message', 'Trial updated successfully'); 
                Session::flash('alert-class', 'alert-success');

                $data =  $request->session()->get('_previous');
        		return \Redirect::to($data['url']);
                // }
                
            }catch(\Exception $e ){

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                $data =  $request->session()->get('_previous');
            	return \Redirect::to($data['url']);
            }
        }
    }

    public function deleteTrailUpcoming(Request $request, $id)
    {
        $success = \Config::get('common.delete_success_response');
        $failure = \Config::get('common.delete_failure_response');

        try{
            // Get the ciecles details
            $rowData = \App\TrialUpcoming::where('id', $id)->get()->toArray();

            if(count($rowData) > 0){
                $updateCircle = \App\TrialUpcoming::where('id', $id)->delete();

                Session::flash('message', 'Successfully deleted'); 
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
