<?php

namespace App\Http\Controllers\Admin\JungleStay;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;


class JungleStayLandscapeController extends Controller
{
    public function getJungleStayLandscapes(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$landscapelist = \App\JungleStay\JungleStayLandscape::all()->toArray();

        	return view('Admin/jungleStay/junglestaylandscape/index', ['landscapeList'=> $landscapelist]);
        } catch (Exception $e) {
        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayLandscapes'));
        }
    }

    public function createJungleStayLandscape(Request $request)
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
            return \Redirect::to(url('admin/jungleStayLandscapes'));
            
        }else{
            try{
                // check for the email already exist
                $checkLandscape = \App\JungleStay\JungleStayLandscape::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkLandscape) > 0){
                    $failure['response']['message'] = "Sorry this landscape is exist already!!";
                    Session::flash('message', 'Sorry this landscape is exist already!!'); 
					Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/jungleStayLandscapes'));
                }else{

                	// Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/junglestaylandscape/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/junglestaylandscape/'.$destinationFileName;
                    $file->move($destinationPath,$destinationFileName);
                    
                    $content['logo'] = $pathToSacveInDB;

                    $create  = \App\JungleStay\JungleStayLandscape::create($content);

                    Session::flash('message', 'Landscape added successfully'); 
					Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/jungleStayLandscapes'));
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayLandscapes'));
            }
        }

    	// return redirect()->route('getLandscapes', ['id' => 1]);
    }

    public function editJungleStayLandscape(Request $request)
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
            return \Redirect::to(url('admin/jungleStayLandscapes'));
        }else{
            try{
                // Get the ciecles details
                $landscapeData = \App\JungleStay\JungleStayLandscape::where('id', [$content['id']])->get()->toArray();

                // echo "<pre>";print_r($landscapeData);exit(); 
                if(count($landscapeData) > 0){
                	$landscapeData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                    return view('Admin/jungleStay/junglestaylandscape/edit')->with(array('landscapeData'=>$landscapeData[0]));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/jungleStayLandscapes'));
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayLandscapes'));
            }
        }
    }

    public function updateJungleStayLandscape(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();
        $landscapeId  = $content['landscapeId'];

        $validator = \Validator::make($request->all(), [
            'landscapeId'   => 'required',
            'name'   => 'required',

        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayLandscapes'));
        }else{
            try{

            	if (isset($content['logo'])) {

            		// Get the record to delete the existing file
                    $getRow = \App\JungleStay\JungleStayLandscape::where('id',$landscapeId)->get()->toArray();


                    // Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/junglestaylandscape/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/junglestaylandscape/'.$destinationFileName;
                    $copyFile = $file->move($destinationPath,$destinationFileName);
                    
                    if ($copyFile) {
                        $filepath = \Config::get('common.myecotripHTML').'public'.$getRow[0]['logo'];
                        unlink($filepath);
                    }
                    
                    $content['logo'] = $pathToSacveInDB;
                }

                unset($content['_token']);
                unset($content['landscapeId']);

                $updateLandscape = \App\JungleStay\JungleStayLandscape::where('id', $landscapeId)->update($content);

                Session::flash('message', 'Landscape updated successfully'); 
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStayLandscapes'));

            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayLandscapes'));
            }
        }
    }

    public function deleteJungleStayLandscape(Request $request)
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
            return redirect()->route('jungleStayLandscapes');

        }else{
            try{
                // Get the ciecles details
                $landscapeData = \App\JungleStay\JungleStayLandscape::where('id', [$content['id']])->get()->toArray();

                if(count($landscapeData) > 0){
                    $updateLandscape = \App\JungleStay\JungleStayLandscape::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the landscape.'); 
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/jungleStayLandscapes'));

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/jungleStayLandscapes'));
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayLandscapes'));
            }
        }
    }
}
