<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class ParkingVehicleTypeController extends Controller
{
    public function getParkingVehicleType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $parkingVehicleTypeList = \App\BirdSanctuary\parkingVehicleType::all()->toArray();
            
            // echo "<pre>"; print_r($parkingVehicleTypeList);exit();
            return view('Admin/birdSanctuary/parkingVehicleType/index', ['parkingVehicleTypeList'=> $parkingVehicleTypeList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingVehicleType'));
        }
    }

    public function addParkingVehicleType(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

            return view('Admin/birdSanctuary/parkingVehicleType/add');
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingVehicleType'));
        }
    }

    public function createParkingVehicleType(Request $request)
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
            return \Redirect::to(url('admin/parkingVehicleType'));

        }else {
            try {
                $parkingVehicleTypelist = \App\BirdSanctuary\parkingVehicleType::where('type',$content['type'])
                                                                   ->get()->toArray();

                if(count($parkingVehicleTypelist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Vehicle Type is already existed!!";
                    Session::flash('message', 'Sorry this Vehicle Type is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/parkingVehicleType'));
                }
                else{
                    $create  = \App\BirdSanctuary\parkingVehicleType::create($content);

                    Session::flash('message', 'Vehicle Type added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/parkingVehicleType'));
                }
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingVehicleType'));
            }
        }
    }

    public function editParkingVehicleType(Request $request)
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
            return \Redirect::to(url('admin/parkingVehicleType'));

        }else {
            try {
                $parkingVehicleTypeData = \App\BirdSanctuary\parkingVehicleType::where('id', [$content['id']])->get()->toArray();

                return view('Admin/birdSanctuary/parkingVehicleType/edit',['parkingVehicleTypeData'=>$parkingVehicleTypeData[0]]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingVehicleType'));
            }
        }
    }

    public function updateParkingVehicleType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $parkingVehicleTypeId     = $content['parkingVehicleTypeId'];
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
            return \Redirect::to(url('admin/parkingVehicleType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['parkingVehicleTypeId']);

                $update  = \App\BirdSanctuary\parkingVehicleType::where('id', $parkingVehicleTypeId)->update($content);

                Session::flash('message', 'Vehicle Type updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/parkingVehicleType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingVehicleType'));
            }
        }
    }

    public function deleteParkingVehicleType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $parkingVehicleTypeId     = $content['id'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingVehicleType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['id']);

                $delete  = \App\BirdSanctuary\parkingVehicleType::where('id', $parkingVehicleTypeId)->delete($content);

                Session::flash('message', 'Vehicle Type deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/parkingVehicleType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingVehicleType'));
            }
        }
    }

}
