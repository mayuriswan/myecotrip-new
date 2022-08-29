<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;


class LandscapeController extends Controller
{
    public function getLandscapes(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$landscapelist = \App\Landscape::all()->toArray();

        	return view('Admin/landscape/index', ['landscapeList'=> $landscapelist]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('landscape');
        }
    }

    public function createLandscape(Request $request)
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
            return redirect()->route('landscape');
            
        }else{
            try{
                // check for the email already exist
                $checkLandscape = \App\Landscape::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkLandscape) > 0){
                    $failure['response']['message'] = "Sorry this landscape is exist already!!";
                    Session::flash('message', 'Sorry this landscape is exist already!!'); 
					Session::flash('alert-class', 'alert-danger');

    				return redirect()->route('landscape');
                }else{

                	// Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/landscape/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/landscape/'.$destinationFileName;
                    $file->move($destinationPath,$destinationFileName);
                    
                    $content['logo'] = $pathToSacveInDB;

                    $create  = \App\Landscape::create($content);

                    Session::flash('message', 'Landscape added successfully'); 
					Session::flash('alert-class', 'alert-success');

    				return redirect()->route('landscape');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('landscape');
            }
        }

    	// return redirect()->route('getLandscapes', ['id' => 1]);
    }

    public function editLandscapes(Request $request)
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
            return redirect()->route('landscape');
        }else{
            try{
                // Get the ciecles details
                $landscapeData = \App\Landscape::where('id', [$content['id']])->get()->toArray();

                // echo "<pre>";print_r($landscapeData);exit(); 
                if(count($landscapeData) > 0){
                	$landscapeData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                    return view('Admin/landscape/edit')->with(array('landscapeData'=>$landscapeData[0]));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('landscape');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('landscape');
            }
        }
    }

    public function updateLandscape(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();
        $landscapeId  = $content['landscapeId'];

        $validator = \Validator::make($request->all(), [
            'landscapeId'   => 'required',
            'name'   => 'required',
            'status'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('landscape');
        }else{
            try{

            	if (isset($content['logo'])) {

            		// Get the record to delete the existing file
                    $getRow = \App\Landscape::where('id',$landscapeId)->get()->toArray();


                    // Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/landscape/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/landscape/'.$destinationFileName;
                    $copyFile = $file->move($destinationPath,$destinationFileName);
                    
                    if ($copyFile) {
                        $filepath = public_path().$getRow[0]['logo'];
                        unlink($filepath);
                    }
                    
                    $content['logo'] = $pathToSacveInDB;
                }

                unset($content['_token']);
                unset($content['landscapeId']);

                $updateLandscape = \App\Landscape::where('id', $landscapeId)->update($content);

                Session::flash('message', 'Landscape updated successfully'); 
                Session::flash('alert-class', 'alert-success');

                return redirect()->route('landscape');
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('landscape');
            }
        }
    }

    public function deleteLandscape(Request $request)
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
            return redirect()->route('landscape');

        }else{
            try{
                // Get the ciecles details
                $landscapeData = \App\Landscape::where('id', [$content['id']])->get()->toArray();

                if(count($landscapeData) > 0){
                    $updateLandscape = \App\Landscape::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the landscape.'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('landscape');

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('landscape');
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('landscape');
            }
        }
    }
}
