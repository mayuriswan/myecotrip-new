<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class BoatTypeController extends Controller
{
    public function getBoatType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $boatTypeList = \App\BirdSanctuary\boatType::all()->toArray();

            foreach ($boatTypeList as $index => $getBoatTypeListDate){
                $getParkData = \App\Parks::where('id',$getBoatTypeListDate['park_id'])->get()->toArray();
                $getBirdSanctuaryData = \App\BirdSanctuary\birdSanctuary::where('id',$getBoatTypeListDate['birdSanctuary_id'])->get()->toArray();

                $boatTypeList[$index]['parkname'] = $getParkData[0]['name'];
                $boatTypeList[$index]['birdSanctuaryName'] = $getBirdSanctuaryData[0]['name'];
            }
            return view('Admin/birdSanctuary/boatType/index', ['boatTypeList'=> $boatTypeList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatType'));
        }
    }

    public function addBoatType(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $parklist = \App\Parks::all()->toArray();
            $birdSanctuarylist = \App\BirdSanctuary\birdSanctuary::all()->toArray();

            return view('Admin/birdSanctuary/boatType/add', ['parkList'=> $parklist,'birdSanctuarylist'=>$birdSanctuarylist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatType'));
        }
    }

    public function getBirdSanctuary(Request $request, $parkId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $birdSanctuarylist = \App\BirdSanctuary\birdSanctuary::where('park_id',$parkId)->get()->toArray();

            return view('Admin/birdSanctuary/boatType/dynamic', ['birdSanctuarylist'=>$birdSanctuarylist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatType'));
        }
    }    

    public function createBoatType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'park_id'   => 'required',
            'birdSanctuary_id'   => 'required',
            'name'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatType'));

        }else {
            try {
                $create  = \App\BirdSanctuary\boatType::create($content);

                Session::flash('message', 'Boat Type added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/boatType'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/boatType'));
            }
        }
    }

    public function editBoatType(Request $request)
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
            return \Redirect::to(url('admin/boatType'));

        }else {
            try {
                $parklist = \App\Parks::all()->toArray();
                $birdSanctuarylist = \App\BirdSanctuary\birdSanctuary::all()->toArray();
                $boatTypeData = \App\BirdSanctuary\boatType::where('id', [$content['id']])->get()->toArray();

                return view('Admin/birdSanctuary/boatType/edit',['parkList'=>$parklist,'birdSanctuarylist'=>$birdSanctuarylist,'boatTypeData'=>$boatTypeData[0]]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/boatType'));
            }
        }
    }

    public function updateBoatType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $boatTypeId     = $content['boatTypeId'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'park_id'   => 'required',
            'birdSanctuary_id'   => 'required',
            'name'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['boatTypeId']);

                $update  = \App\BirdSanctuary\boatType::where('id', $boatTypeId)->update($content);

                Session::flash('message', 'Boat Type updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/boatType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/boatType'));
            }
        }
    }

    public function deleteBoatType(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $boatTypeId     = $content['id'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatType'));

        }else {
            try {

                unset($content['_token']);
                unset($content['id']);

                $delete  = \App\BirdSanctuary\boatType::where('id', $boatTypeId)->delete($content);

                Session::flash('message', 'Boat Type deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/boatType'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/boatType'));
            }
        }
    }

}
