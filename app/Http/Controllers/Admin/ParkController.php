<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class ParkController extends Controller
{
    public function getParks(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$parkslist = \App\Parks::all()->toArray();

        	return view('Admin/parks/index', ['parkslist'=> $parkslist]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('getParks');
        }
    }

    public function addPark(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
       
        try {
            // get the parklist
            $circleList = \App\Circle::all()->toArray();

            return view('Admin/parks/add', ['circleList'=> $circleList]);
        }catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('getParks');
        }
    }
    public function createPark(Request $request)
    {
    	$success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('getParks');
        }else{
            try{

                // check for the email already exist
                $checkPark = \App\Parks::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkPark) > 0){                    

                    $failure['response']['message'] = "Sorry this park exist already!!";
                    Session::flash('message', 'Sorry this circle is exist already!!'); 
					Session::flash('alert-class', 'alert-danger');

    				return redirect()->route('getParks');
                }else{

                    // Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/parks/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/parks/'.$destinationFileName;
                    $file->move($destinationPath,$destinationFileName);
                    
                    $content['logo'] = $pathToSacveInDB;

                    $create  = \App\Parks::create($content);

                    Session::flash('message', 'Park added successfully'); 
					Session::flash('alert-class', 'alert-success');

    				return redirect()->route('getParks');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not insert.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getParks');
            }
        }
    }

    public function editPark(Request $request)
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
            return redirect()->route('getParks');

        }else{
            try{
                // Get the ciecles details
                $parkData = \App\Parks::where('id', [$content['id']])->get()->toArray();
                
                if(count($parkData) > 0){
                    $parkData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');

                    return view('Admin/parks/edit')->with(array('parkData'=>$parkData[0]));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again.');
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getParks');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getParks');
            }
        }
    }

    public function updatePark(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();
        $parkId = $content['parkId'];

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
        ]);

                    // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('getParks');

        }else{
            try{

                if (isset($content['logo'])) {

                    // Get the record to delete the existing file
                    $getRow = \App\Parks::where('id',$parkId)->get()->toArray();

                    // Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/parks/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/parks/'.$destinationFileName;
                    $copyFile = $file->move($destinationPath,$destinationFileName);
                    
                    if ($copyFile) {
                        $filepath = public_path().$getRow[0]['logo'];
                        unlink($filepath);
                    }
                    
                    $content['logo'] = $pathToSacveInDB;
                }

                unset($content['_token']);
                unset($content['parkId']);

                $update  = \App\Parks::where('id',$parkId)->update($content);

                Session::flash('message', 'Updated successfully'); 
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('getParks');                   

                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getParks');
            }
        }
    }

    public function deletePark(Request $request)
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
            return redirect()->route('getParks');

        }else{
            try{
                // Get the ciecles details
                $parkData = \App\Parks::where('id', [$content['id']])->get()->toArray();

                if(count($parkData) > 0){
                    $deletePark = \App\Parks::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the records.'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('getParks');

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('getParks');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('getParks');
            }
        }
    }
}
