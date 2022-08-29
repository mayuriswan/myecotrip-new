<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class BSTimeSlotsMappingController extends Controller
{
    public function getBSTimeSlotsMapping(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $getTimeSlotsMapping = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::all()->toArray();
            foreach ($getTimeSlotsMapping as $index => $timeSlotsMapping) {
            	$getBirdSanctuary = \App\BirdSanctuary\birdSanctuary::where('id',$timeSlotsMapping['birdSanctuary_id'])->get()->toArray();
            	$getBoatType = \App\BirdSanctuary\boatType::where('id',$timeSlotsMapping['boatType_id'])->get()->toArray();
                $getTimeSlots = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id',$timeSlotsMapping['timeslots_id'])->get()->toArray();
				
				$getTimeSlotsMapping[$index]['birdSanctuaryName'] = $getBirdSanctuary[0]['name'];
                $getTimeSlotsMapping[$index]['boatName'] = $getBoatType[0]['name'];
				$getTimeSlotsMapping[$index]['timeslots'] = $getTimeSlots[0]['timeslots'];         														              														  	 
            }

            return view('Admin/birdSanctuary/BStimeslotsMapping/index',['timeSlotsList'=> $getTimeSlotsMapping]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/BStimeslotsMapping'));
        }
    }

    public function addBSTimeSlotsMapping(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
          	$getBirdSanctuary = \App\BirdSanctuary\birdSanctuary::all()->toArray();

            return view('Admin/birdSanctuary/BStimeslotsMapping/add',['birdSanctuarylist'=> $getBirdSanctuary]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/BStimeslotsMapping'));
        }
    }

    public function getBoatTimeSlots(Request $request, $birdSanctuaryId, $boatTypeId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $timeslots = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('birdSanctuary_id',$birdSanctuaryId)
                                                        ->where('boatType_id',$boatTypeId)->get()->toArray();

            foreach ($timeslots as $index => $timeslotslist) {
                $timeslotsvalue = \App\BirdSanctuary\birdSanctuaryTimeSlots::where('id',$timeslotslist['timeslots_id'])
                                                                             ->get()->toArray();
                $timeslots[$index]['timeslots'] = $timeslotsvalue[0]['timeslots'];                                                              
            }

            return view('Admin/birdSanctuary/BStimeslotsMapping/dynamic',['timeslots'=> $timeslots]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/BStimeslotsMapping'));
        }
    }

	public function createBSTimeSlotsMapping(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content = $request->all();
        $validator = \Validator::make($request->all(),[
            'birdSanctuary_id' => 'required',
            'boatType_id' => 'required',
            'timeslots_id' => 'required',
            'isActive' => 'required' ,
        ]);
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/BStimeslotsMapping'));

        }else {
            try {
                $timeSlotsList = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('birdSanctuary_id',$content['birdSanctuary_id'])
            																	  ->where('boatType_id',$content['boatType_id'])	
                                                                                  ->where('timeslots_id',$content['timeslots_id'])  
            																	  ->get()->toArray();

                if(count($timeSlotsList) > 0)
                {
                        $failure['response']['message'] = "Sorry this Time Slot is already existed!!";
                        Session::flash('message', 'Sorry this Time Slot is already existed!!');
                        Session::flash('alert-class', 'alert-danger');

                        return \Redirect::to(url('admin/BStimeslotsMapping'));
                }
                $timeSlotsList = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::create($content);

                Session::flash('message', 'Time Slot added successfully');
                Session::flash('alert-class', 'alert-success');
                return \Redirect::to(url('admin/BStimeslotsMapping'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslotsMapping'));
            }
        }
    }

	public function editBSTimeSlotsMapping(Request $request){
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
            return \Redirect::to(url('admin/BStimeslotsMapping'));

        }else {
            try {
            	$getBirdSanctuary = \App\BirdSanctuary\birdSanctuary::all()->toArray();
          		$getBirdSanctuaryTimeSlots = \App\BirdSanctuary\birdSanctuaryTimeSlots::all()->toArray();
                $getBirdSanctuaryBoatTypes = \App\BirdSanctuary\boatType::all()->toArray();
                $timeslotsMappingData = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('id', [$content['id']])->get()->toArray();

                return view('Admin/birdSanctuary/BStimeslotsMapping/edit')->with(array('timeslotsMappingData'=>$timeslotsMappingData[0],'birdSanctuarylist'=> $getBirdSanctuary,'timeslotslist'=> $getBirdSanctuaryTimeSlots,'boatTypeslist'=>$getBirdSanctuaryBoatTypes));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslotsMapping'));
            }
        }
    }

    public function updateBSTimeSlotsMapping(Request $request){
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();

        $timeslotsId = $content['id'];

        $validator = \Validator::make($request->all(), [
            'birdSanctuary_id' => 'required',
            'boatType_id' => 'required',
            'timeslots_id' => 'required',
            'isActive' => 'required' ,
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/BStimeslotsMapping'));

        }else {

            try {
                unset($content['_token']);
                unset($content['id']);

                $update = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('id', $timeslotsId)->update($content);

                Session::flash('message', 'Time Slots updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/BStimeslotsMapping'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslotsMapping'));
            }
        }
    }

    public function deleteBSTimeSlotsMapping(Request $request){
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
            return \Redirect::to(url('admin/BStimeslotsMapping'));

        }else {

            try {
                unset($content['_token']);
                unset($content['id']);

                $deletetimeslotsData = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('id', $timeslotsId)->delete();

                Session::flash('message', 'Time Slot deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/BStimeslotsMapping'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/BStimeslotsMapping'));
            }
        }
    }
}
