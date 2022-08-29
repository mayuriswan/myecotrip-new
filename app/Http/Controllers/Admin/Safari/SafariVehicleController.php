<?php

namespace App\Http\Controllers\Admin\Safari;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Session;

class SafariVehicleController extends Controller
{
    public function getsafariVehicles(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $safarivehicleData = \App\Safari\SafariVehicle::all()->toArray();

            foreach ($safarivehicleData as $index => $safarivehicleList){
                $safarilist = \App\Safari\Safari::where('id',$safarivehicleList['safari_id'])->get()->toArray();
                $transporttypes = \App\Transportation\TransportationTypes::where('id',$safarivehicleList['transportation_id'])->get()->toArray();
                $safarivehicleData[$index]['safariName'] = $safarilist[0]['name'];
                $safarivehicleData[$index]['transportationName'] = $transporttypes[0]['name'];
            }

            return view('Admin/safari/safarivehicles/index',['safarivehicleList'=> $safarivehicleData]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariVehicles'));
        }
    }

    public function addSafariVehicle(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $safarilist = \App\Safari\Safari::all()->toArray();
            $transporttypes = \App\Transportation\TransportationTypes::all()->toArray();

            return view('Admin/safari/safarivehicles/add', ['safariList'=> $safarilist,'transporttypesList'=>$transporttypes]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariVehicles'));
        }
    }




    public function createSafariVehicle(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();

        $validator = \Validator::make($request->all(),[
            'safari_id' => 'required',
            'transportation_id' => 'required',
            'vehicle_no' => 'required',
            'description' => 'required',
            'displayName' => 'required',
            'onlineBooking' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariVehicles'));

        }else {
            try {
                $safarivehiclelist = \App\Safari\SafariVehicle::whereRaw('LOWER(vehicle_no) = ?', [$content['vehicle_no']])->get()->toArray();

                if(count($safarivehiclelist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Vehicle is already existed!!";
                    Session::flash('message', 'Sorry this Vehicle is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/safariVehicles'));
                }

                $create  = \App\Safari\SafariVehicle::create($content);

                Session::flash('message', 'Safari added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariVehicles'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariVehicles'));
            }
        }
    }

    public function editSafariVehicle(Request $request)
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
            return \Redirect::to(url('admin/safariVehicles'));

        }else {
            try {
                $safarivehicleData = \App\Safari\SafariVehicle::where('id', [$content['id']])->get()->toArray();
                $safarilist = \App\Safari\Safari::where('id', $safarivehicleData[0]['safari_id'])->get()->toArray();
                $tranIds = explode(",",$safarilist[0]['transportation_id']);

                $transporttypeslist = \App\Transportation\TransportationTypes::whereIn('id', $tranIds)->get()->toArray();

                return view('Admin/safari/safarivehicles/edit',['safarivehicleList'=>$safarivehicleData[0],'safariList'=>$safarilist,'transporttypesList' =>$transporttypeslist]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariVehicles'));
            }
        }
    }

    public function updateSafariVehicle(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $safariId     = $content['safarivehicleId'];

        $validator = \Validator::make($request->all(), [
            'safari_id' => 'required',
            'transportation_id' => 'required',
            'vehicle_no' => 'required',
            'description' => 'required',
            'displayName' => 'required',
            'onlineBooking' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariVehicles'));

        }else {
            try {

                unset($content['_token']);
                unset($content['safarivehicleId']);

                $update  = \App\Safari\SafariVehicle::where('id', $safariId)->update($content);

                Session::flash('message', 'Safari Vehicle updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariVehicles'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariVehicles'));
            }
        }
    }


    public function deleteSafariVehicle(Request $request)
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
            return \Redirect::to(url('admin/safariVehicles'));

        }else {
            try {

                unset($content['_token']);
                unset($content['safarivehicleId']);

                $delete  = \App\Safari\SafariVehicle::where('id', $content['id'])->delete();

                Session::flash('message', 'Safari Vehicle deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariVehicles'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariVehicles'));
            }
        }
    }

}
