<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class CameraTypeController extends Controller
{
    public function getCameraType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $cameraTypeList = \App\BirdSanctuary\cameraType::all()->toArray();

            return view('Admin/birdSanctuary/cameraType/index', ['cameraTypeList'=> $cameraTypeList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraType'));
        }
    }

    public function addCameraType(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            return view('Admin/birdSanctuary/cameraType/add');
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraType'));
        }
    }

    public function createCameraType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'type'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraType'));

        }else {
            try {
                $cameraTypelist = \App\BirdSanctuary\cameraType::where('type',$content['type'])
                                                                   ->get()->toArray();

                if(count($cameraTypelist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Camera Type is already existed!!";
                    Session::flash('message', 'Sorry this Camera Type is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/cameraType'));
                }
                else{
                    $create  = \App\BirdSanctuary\cameraType::create($content);

                    Session::flash('message', 'Camera Type added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/cameraType'));
                }
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraType'));
            }
        }
    }

    public function editCameraType(Request $request)
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

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraType'));

        }else {
            try {
                $cameraTypeData = \App\BirdSanctuary\cameraType::where('id', [$content['id']])->get()->toArray();

                return view('Admin/birdSanctuary/cameraType/edit',['cameraTypeData'=>$cameraTypeData[0]]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraType'));
            }
        }
    }

    public function updateCameraType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $cameraTypeId     = $content['cameraTypeId'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'type'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['cameraTypeId']);

                $update  = \App\BirdSanctuary\cameraType::where('id', $cameraTypeId)->update($content);

                Session::flash('message', 'Camera Type updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/cameraType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraType'));
            }
        }
    }

    public function deleteCameraType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $cameraTypeId     = $content['id'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['id']);

                $delete  = \App\BirdSanctuary\cameraType::where('id', $cameraTypeId)->delete($content);

                Session::flash('message', 'Camera Type deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/cameraType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraType'));
            }
        }
    }

}
