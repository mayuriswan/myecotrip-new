<?php

namespace App\Http\Controllers\Admin\Safari;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class SafariTimeslotsTransportationtypeController extends Controller
{
    public function getSafariTimeslotsTransportationtype(Request $request){

        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        try{
            $getSafariTimeslotsTransportationtype = \App\Safari\SafariNumbers::all()->toArray();
            $output = array();
            foreach ($getSafariTimeslotsTransportationtype as $index => $getData){
                $safarilist = \App\Safari\Safari::where('id',$getData['safari_id'])->get()->toArray();
                $transporttypes = \App\Transportation\TransportationTypes::where('id',$getData['transportation_id'])->get()->toArray();
                $timeSlotsData = \App\TimeSlots::where('id',$getData['timeslot_id'])->get()->toArray();

                // echo "<pre>";print_r($timeSlotsData);exit();
                $getVehicleCount = \App\Safari\SafariNumbers::where('safari_id', $getData['safari_id'])
                    ->where('transportation_id', $getData['transportation_id'])
                    ->where('timeslot_id', $getData['timeslot_id'])
                    ->get()->toArray();
                $vehicleCounts = [$getData['safari_id'].$getData['transportation_id'].$getData['timeslot_id']];

                $output[$vehicleCounts[0]] = count($getVehicleCount);
                $output[$vehicleCounts[0]] = array();

                $output[$vehicleCounts[0]]['safariId'] = $safarilist[0]['id'];
                $output[$vehicleCounts[0]]['safariName'] = $safarilist[0]['name'];
                $output[$vehicleCounts[0]]['transportationId'] =  $transporttypes[0]['id'];
                $output[$vehicleCounts[0]]['transportationName'] =  $transporttypes[0]['name'];
                $output[$vehicleCounts[0]]['timeslotsId'] = $timeSlotsData[0]['id'];
                $output[$vehicleCounts[0]]['timeslots'] = $timeSlotsData[0]['timeslots'];
                $output[$vehicleCounts[0]]['vehicle'] = count($getVehicleCount);
            }
            return view('Admin/safari/safaritimeslotstranspotype/index',['output'=> $output]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
        }
    }

    public function addSafariTimeslotsTransportationtype(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        try {
            $safarilist = \App\Safari\Safari::all()->toArray();
            $timeSlotslist = \App\TimeSlots::all()->toArray();

            return view('Admin/safari/safaritimeslotstranspotype/add', ['safariData'=> $safarilist,'timeSlotsData'=>$timeSlotslist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
        }
    }

    public function getTransportationVehicle($safari_id,$transportation_id,$timeslot_id){

        /*$vehiclelist = \App\Safari\SafariVehicle::where('safari_id',$safari_id)->
        where('transportation_id',$transportation_id)->get()->toArray();

        foreach ($vehiclelist as $index => $vehicle){
            $vehiclelist[$index]['id'] =  $vehicle['id'];
            $vehiclelist[$index]['vehicle_no'] =  $vehicle['vehicle_no'];
        }
        if(empty($vehiclelist)){
            $vehiclelist = 'No Vehicle Found';
        }
        return view('Admin/safari/safaritimeslotstranspotype/dynamic', ['vehicleList'=>$vehiclelist]);*/

        $vehicleTransportlist = \App\Safari\SafariNumbers::where('safari_id',$safari_id)
            ->where('transportation_id',$transportation_id)
            ->where('timeslot_id',[$timeslot_id])
            ->get()->toArray();

        $vehicleArr = array();
        foreach ($vehicleTransportlist as $index => $tranportvehicles){
            $vehicleArr[$index]['vehicle_id'] = $tranportvehicles['vehicle_id'];
        }

        $vehiclelist = \App\Safari\SafariVehicle::where('safari_id',$safari_id)
            ->where('transportation_id',$transportation_id)
            ->whereNotIn('id',$vehicleArr)
            ->get()->toArray();

        foreach ($vehiclelist as $index => $vehicle){
            $vehiclelist[$index]['id'] =  $vehicle['id'];
            $vehiclelist[$index]['vehicle_no'] =  $vehicle['vehicle_no'];
        }
        if(empty($vehiclelist)){
            $vehiclelist = 'No Vehicle Found';
        }
        return view('Admin/safari/safaritimeslotstranspotype/dynamic', ['vehicleList'=>$vehiclelist]);
    }

    public function createSafariTimeslotsTransportationtype(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'safari_id'   => 'required',
            'transportation_id'   => 'required',
            'timeslot_id'   => 'required',
            'vehicle_id'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));

        }else {
            try {
                $safariTimeslotsTransportationtypelist = \App\Safari\SafariNumbers::where('safari_id',$content['safari_id'])->
                where('transportation_id',$content['transportation_id'])->
                where('vehicle_id',$content['vehicle_id'])->
                where('timeslot_id',$content['timeslot_id'])->get()->toArray();

                if(count($safariTimeslotsTransportationtypelist) > 0)
                {
                    $failure['response']['message'] = "Sorry this is already existed!!";
                    Session::flash('message', 'Sorry this Safari is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
                }

                foreach ($content['vehicle_id'] as $id) {
                    $content['vehicle_id'] = $id;
                    $create  = \App\Safari\SafariNumbers::create($content);
                }

                Session::flash('message', 'Safari added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
            }
        }
    }

    public function editTimeSafariTimeslotsTransportationtype(Request $request,$safariId, $transportationId, $timeslotsId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [

        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));

        }else {
            try{
                $safariData = \App\Safari\Safari::all()->toArray();
                $timeSlotsData = \App\TimeSlots::all()->toArray();
                $transporttypeslist = \App\Transportation\TransportationTypes::where('id',$transportationId)->get()->toArray();

                $allVehicles = \App\Safari\SafariVehicle::where('safari_id',$safariId)
                    ->where('transportation_id',$transportationId)->get()->toArray();

                $getOldVehicles = \App\Safari\SafariNumbers::where('safari_id', $safariId)
                    ->where('transportation_id',$transportationId)
                    ->where('timeslot_id',$timeslotsId)
                    ->get()->toArray();

                foreach ($getOldVehicles as $vehicle){
                    $oldVehicles[] = $vehicle['vehicle_id'];
                }

                $hiddenVehicles = implode(",", $oldVehicles);

                $requestData = array();
                $requestData['safariId'] = $safariId;
                $requestData['transportationId'] = $transportationId;
                $requestData['timeslotsId'] = $timeslotsId;

                return view('Admin/safari/safaritimeslotstranspotype/edit', ['hiddenVehicles'=>$hiddenVehicles, 'transporttypeslist'=>$transporttypeslist,'requestData'=>$requestData,'safariData'=> $safariData,'timeSlotsData'=>$timeSlotsData,'allVehicles'=>$allVehicles,'oldVehicles'=>$oldVehicles]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
            }
        }
    }

    public function updateSafariTimeslotsTransportationtype(Request $request){
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'safari_id'   => 'required',
            'transportation_id'   => 'required',
            'timeslot_id'   => 'required',
            'vehicle_id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));

        }else {
            try {
                $oldVehicleArr = explode(",", $content['oldVehicles']);
                $toRemove= array_diff($oldVehicleArr,$content['vehicle_id']);
                $toInsert = array_diff($content['vehicle_id'],$oldVehicleArr);

                foreach ($toRemove as $id) {
                    $delete = \App\Safari\SafariNumbers::where('safari_id',$content['safari_id'])->
                    where('transportation_id',$content['transportation_id'])->
                    where('vehicle_id',$id)->
                    where('timeslot_id',$content['timeslot_id'])->delete();
                }

                unset($content['_token']);
                unset($content['oldVehicles']);

                foreach ($toInsert as $id) {
                    $content['vehicle_id'] = $id;
                    $create  = \App\Safari\SafariNumbers::create($content);
                }

                Session::flash('message', 'Safari Count updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
            }
        }
    }

    public function deleteSafariTimeslotsTransportationtype(Request $request){
        $success = \Config::get('common.delete_success_response');
        $failure = \Config::get('common.upload_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));

        }else {
            try {

                unset($content['_token']);
                $delete  = \App\Safari\SafariNumbers::where('id', $content['id'])->delete();

                Session::flash('message', 'Safari Count deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTimeslotsTransportationtype'));
            }
        }
    }

}
