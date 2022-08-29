<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class BSTimeSlotsController extends Controller
{
    public function getBSTimeSlots(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $getTimeSlots = \App\BirdSanctuary\birdSanctuaryTimeSlots::all()->toArray();

            return view('Admin/birdSanctuary/BStimeslots/index',['timeSlotsList'=> $getTimeSlots]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/BStimeslots'));
        }
    }

    public function createBSTimeSlots(Request $request){
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
            return \Redirect::to(url('admin/BStimeslots'));

        }else {
            try {
                $timeSlotsList = \App\BirdSanctuary\birdSanctuaryTimeSlots::whereRaw('LOWER(timeslots) = ?', [$content['timeslots']])->get()->toArray();

                if(count($timeSlotsList) > 0)
                {
                        $failure['response']['message'] = "Sorry this Time Slot is already existed!!";
                        Session::flash('message', 'Sorry this Time Slot is already existed!!');
                        Session::flash('alert-class', 'alert-danger');

                        return \Redirect::to(url('admin/BStimeslots'));
                }
                $timeSlotsList = \App\BirdSanctuary\birdSanctuaryTimeSlots::create($content);

                Session::flash('message', 'Time Slot added successfully');
                Session::flash('alert-class', 'alert-success');
                return \Redirect::to(url('admin/BStimeslots'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslots'));
            }
        }
    }

    public function editBSTimeSlots(Request $request){
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
            return \Redirect::to(url('admin/BStimeslots'));

        }else {
            try {
                $timeslotsData = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id', [$content['id']])->get()->toArray();

                return view('Admin/birdSanctuary/BStimeslots/edit')->with(array('timeslotsData'=>$timeslotsData[0]));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslots'));
            }
        }
    }

    public function updateBSTimeSlots(Request $request){
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
            return \Redirect::to(url('admin/BStimeslots'));

        }else {

            try {
                unset($content['_token']);
                unset($content['id']);

                $updatetimeslotsData = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id', $timeslotsId)->update($content);

                Session::flash('message', 'Time Slots updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/BStimeslots'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslots'));
            }
        }
    }

    public function deleteBSTimeSlots(Request $request){
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
            return \Redirect::to(url('admin/BStimeslots'));

        }else {

            try {
                unset($content['_token']);
                unset($content['id']);

                $deletetimeslotsData = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id', $timeslotsId)->delete();

                Session::flash('message', 'Time Slot deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/BStimeslots'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslots'));
            }
        }
    }
}
