<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class ParkingTypeController extends Controller
{
    public function getParkingType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $parkingTypeList = \App\BirdSanctuary\parkingType::all()->toArray();
                
            // echo "<pre>"; print_r($parkingTypeList); exit();
            return view('Admin/birdSanctuary/parkingType/index', ['parkingTypeList'=> $parkingTypeList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingType'));
        }
    }

    public function addParkingType(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

            return view('Admin/birdSanctuary/parkingType/add');
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingType'));
        }
    }

    public function createParkingType(Request $request)
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
            return \Redirect::to(url('admin/parkingType'));

        }else {
            try {
                $parkingTypelist = \App\BirdSanctuary\parkingType::where('type',$content['type'])
                                                                   ->get()->toArray();

                if(count($parkingTypelist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Parking Type is already existed!!";
                    Session::flash('message', 'Sorry this Parking Type is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/parkingType'));
                }
                else{
                    $create  = \App\BirdSanctuary\parkingType::create($content);

                    Session::flash('message', 'Parking Type added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/parkingType'));
                }
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingType'));
            }
        }
    }

    public function editParkingType(Request $request)
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
            return \Redirect::to(url('admin/parkingType'));

        }else {
            try {
                $parkingTypeData = \App\BirdSanctuary\parkingType::where('id', [$content['id']])->get()->toArray();

                return view('Admin/birdSanctuary/parkingType/edit',['parkingTypeData'=>$parkingTypeData[0]]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingType'));
            }
        }
    }

    public function updateParkingType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $parkingTypeId     = $content['parkingTypeId'];
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
            return \Redirect::to(url('admin/parkingType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['parkingTypeId']);

                $update  = \App\BirdSanctuary\parkingType::where('id', $parkingTypeId)->update($content);

                Session::flash('message', 'Parking Type updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/parkingType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingType'));
            }
        }
    }

    public function deleteParkingType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $parkingTypeId     = $content['id'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['id']);

                $delete  = \App\BirdSanctuary\parkingType::where('id', $parkingTypeId)->delete($content);

                Session::flash('message', 'Parking Type deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/parkingType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingType'));
            }
        }
    }

}
