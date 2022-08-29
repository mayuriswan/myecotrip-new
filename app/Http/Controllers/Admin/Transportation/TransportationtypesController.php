<?php

namespace App\Http\Controllers\Admin\Transportation;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class TransportationtypesController extends Controller
{

    public function getTypes(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $transporttypes = \App\Transportation\TransportationTypes::all()->toArray();

            return view('Admin/transportationtypes/index', ['transporttypesList'=> $transporttypes]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/transportationTypes'));
        }
    }

    public function addTransportationTypes(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $transporttypes = \App\Transportation\TransportationTypes::all()->toArray();

            return view('Admin/transportationtypes/add', ['transporttypesList'=> $transporttypes]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/transportationTypes'));
        }
    }

    public function createTransportationTypes(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/transportationTypes'));

        }else {

            try {
                $transporttypes = \App\Transportation\TransportationTypes::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($transporttypes) > 0)
                {
                        $failure['response']['message'] = "Sorry this transportation type is already existed!!";
                        Session::flash('message', 'Sorry this transportation type is already existed!!');
                        Session::flash('alert-class', 'alert-danger');

                        return \Redirect::to(url('admin/transportationTypes'));
                }

                $create  = \App\Transportation\TransportationTypes::create($content);
                Session::flash('message', 'TransportationType added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/transportationTypes'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/transportationTypes'));
            }
        }
    }

    public function editTransportationTypes(Request $request)
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
            return \Redirect::to(url('admin/transportationTypes'));

        }else {
            try {
                $transportationTypes = \App\Transportation\TransportationTypes::where('id', [$content['id']])->get()->toArray();
                return view('Admin/transportationtypes/edit')->with(array('transportationTypes'=>$transportationTypes[0]));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/transportationTypes'));
            }
        }
    }

    public function updateTransportationTypes(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $transportationTypesId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/transportationTypes'));

        }else {
            try {

                unset($content['_token']);
                unset($content['transportationTypesId']);

                $update  = \App\Transportation\TransportationTypes::where('id', $transportationTypesId)->update($content);

                Session::flash('message', 'Safari updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/transportationTypes'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/transportationTypes'));
            }
        }
    }


    public function deleteTransportationTypes(Request $request)
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
            return \Redirect::to(url('admin/transportationTypes'));

        }else {
            try {

                unset($content['_token']);
                unset($content['transportationTypesId']);

                $delete  = \App\Transportation\TransportationTypes::where('id', $content['id'])->delete();

                Session::flash('message', 'TransportationTypes deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/transportationTypes'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/transportationTypes'));
            }
        }
    }

}