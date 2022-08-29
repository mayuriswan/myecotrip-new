<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class TimeSlotsController extends Controller
{
    public function getTimeSlots(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $getTimeSlots = \App\TimeSlots::all()->toArray();
            return view('Admin/timeslots/index',['timeSlotsList'=> $getTimeSlots]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/timeslots'));
        }
    }

    public function createTimeSlots(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content = $request->all();
        $validator = \Validator::make($request->all(),[
            'timeslots' => 'required' ,
            'isActive' => 'required' ,
        ]);
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/timeslots'));

        }else {
            try {
                $timeSlotsList = \App\TimeSlots::whereRaw('LOWER(timeslots) = ?', [$content['timeslots']])->get()->toArray();

                if(count($timeSlotsList) > 0)
                {
                        $failure['response']['message'] = "Sorry this Time Slot is already existed!!";
                        Session::flash('message', 'Sorry this Time Slot is already existed!!');
                        Session::flash('alert-class', 'alert-danger');

                        return \Redirect::to(url('admin/timeslots'));
                }
                $timeSlotsList = \App\TimeSlots::create($content);

                Session::flash('message', 'Time Slot added successfully');
                Session::flash('alert-class', 'alert-success');
                return \Redirect::to(url('admin/timeslots'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/timeslots'));
            }
        }
    }

    public function editTimeSlots(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id' => 'required' ,
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/timeslots'));

        }else {
            try {
                $timeslotsData = \App\TimeSlots::where('id', [$content['id']])->get()->toArray();

                return view('Admin/timeslots/edit')->with(array('timeslotsData'=>$timeslotsData[0]));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/timeslots'));
            }
        }
    }

    public function updateTimeSlots(Request $request){
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();

        $timeslotsId = $content['id'];

        $validator = \Validator::make($request->all(), [
            'timeslots' => 'required' ,
            'isActive' => 'required' ,
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/timeslots'));

        }else {

            try {
                unset($content['_token']);
                unset($content['id']);

                $updatetimeslotsData = \App\TimeSlots::where('id', $timeslotsId)->update($content);

                Session::flash('message', 'Time Slots updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/timeslots'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/timeslots'));
            }
        }
    }

    public function deleteTimeSlots(Request $request){
        $success = \Config::get('common.delete_success_response');
        $failure = \Config::get('common.upload_failure_response');

        $content      = $request->all();
        $timeslotsId = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required' ,
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/timeslots'));

        }else {

            try {
                unset($content['_token']);
                unset($content['id']);

                $updatetimeslotsData = \App\TimeSlots::where('id', $timeslotsId)->delete();

                Session::flash('message', 'Time Slot deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/timeslots'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/timeslots'));
            }
        }
    }
}
