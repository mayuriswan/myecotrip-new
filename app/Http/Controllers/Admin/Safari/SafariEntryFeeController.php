<?php

namespace App\Http\Controllers\Admin\Safari;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\Exception;

use Session;

class SafariEntryFeeController extends Controller
{
    public function getsafariEntryFee(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $safarientryfeeData = \App\Safari\SafariEntryFee::orderBy('id','desc')->get()->toArray();

            foreach ($safarientryfeeData as $index => $safarientryfeeDataList){
                $safariList = \App\Safari\Safari::where('id',$safarientryfeeDataList['safari_id'])->get()->toArray();

                $safarientryfeeData[$index]['safariName'] = $safariList[0]['name'];
            }
            return view('Admin/safari/safarientryfee/index',['safarientryfeeDataList'=> $safarientryfeeData]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariEntryFee'));
        }
    }

    public function addsafariEntryFee(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $safarilist = \App\Safari\Safari::all()->toArray();

            return view('Admin/safari/safarientryfee/add', ['safariList'=> $safarilist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariEntryFee'));
        }
    }

    public function createsafariEntryFee(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();

        $validator = \Validator::make($request->all(),[
            'safari_id' => 'required',
            'adult_price_india' => 'required',
            'child_price_india' => 'required',
            'senior_price_india' => 'required',
            'adult_price_foreign' => 'required',
            'child_price_foreign' => 'required',
            'senior_price_foreign' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariEntryFee'));

        }else {
            try {
                $safarientryfeelist = \App\Safari\SafariEntryFee::whereRaw('LOWER(safari_id) = ?', [$content['safari_id']])->get()->toArray();

                $create  = \App\Safari\SafariEntryFee::create($content);

                Session::flash('message', 'Safari Entry Fee added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariEntryFee'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariEntryFee'));
            }
        }
    }

    public function editsafariEntryFee(Request $request)
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
            return \Redirect::to(url('admin/safariEntryFee'));

        }else {
            try {
                $safarientryfeeData = \App\Safari\SafariEntryFee::where('id', [$content['id']])->get()->toArray();

                $safarilist = \App\Safari\Safari::all()->toArray();

                return view('Admin/safari/safarientryfee/edit',['safarientryfeeDataList'=>$safarientryfeeData[0],'safariList'=>$safarilist]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariEntryFee'));
            }
        }
    }

    public function updatesafariEntryFee(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $safarisafariEntryFeeId     = $content['safariEntryFeeId'];

        $validator = \Validator::make($request->all(), [
            'safari_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'adult_price_india' => 'required',
            'child_price_india' => 'required',
            'senior_price_india' => 'required',
            'adult_price_foreign' => 'required',
            'child_price_foreign' => 'required',
            'senior_price_foreign' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariEntryFee'));

        }else {
            try {

                unset($content['_token']);
                unset($content['safariEntryFeeId']);

                $update  = \App\Safari\SafariEntryFee::where('id', $safarisafariEntryFeeId)->update($content);

                Session::flash('message', 'Safari Entry Fee updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariEntryFee'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariEntryFee'));
            }
        }
    }

    public function deletesafariEntryFee(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $safarisafariEntryFeeId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariEntryFee'));

        }else {
            try {

                unset($content['_token']);
                unset($content['safariEntryFeeId']);

                $delete  = \App\Safari\SafariEntryFee::where('id', $safarisafariEntryFeeId)->delete();

                Session::flash('message', 'Safari Entry Fee deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariEntryFee'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariEntryFee'));
            }
        }
    }
}
