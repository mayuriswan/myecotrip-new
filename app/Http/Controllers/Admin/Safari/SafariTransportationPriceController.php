<?php

namespace App\Http\Controllers\Admin\Safari;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\Exception;

use Session;

class SafariTransportationPriceController extends Controller
{
    public function getsafariTransportationPrice(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $getSafariTransportationPriceData = \App\Safari\SafariTransportationPrice::orderBy('created_at','desc')->get()->toArray();

            foreach ($getSafariTransportationPriceData as $index => $getData){
                $safarilist = \App\Safari\Safari::where('id',$getData['safari_id'])->get()->toArray();
                $transporttypes = \App\Transportation\TransportationTypes::where('id',$getData['transportation_id'])->get()->toArray();

                $getSafariTransportationPriceData[$index]['safariName'] = $safarilist[0]['name'];
                $getSafariTransportationPriceData[$index]['transportationName'] =  $transporttypes[0]['name'];
            }

            return view('Admin/safari/safariTransportationPrice/index',['safariTransportationPriceData'=> $getSafariTransportationPriceData]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTransportationPrice'));
        }
    }

    public function addSafariTransportationPrice(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $safarilist = \App\Safari\Safari::all()->toArray();
            $transporttypeslist = \App\Transportation\TransportationTypes::all()->toArray();

            return view('Admin/safari/safariTransportationPrice/add',['safariData'=> $safarilist,'transporttypesData'=>$transporttypeslist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTransportationPrice'));
        }
    }

    public function createSafariTransportationPrice(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'safari_id'   => 'required',
            'transportation_id'   => 'required',
            'adult_price_india' => 'required',
            'child_price_india' => 'required',
            'senior_price_india' => 'required',
            'adult_price_foreign' => 'required',
            'child_price_foreign' => 'required',
            'senior_price_foreign' => 'required',
            'no_of_seats' => 'required',
            'allow_seat_selection' => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTransportationPrice'));

        }else {
            try {
                $safariTransportationPricelist = \App\Safari\SafariTransportationPrice::whereRaw('LOWER(transportation_id) = ?', [$content['transportation_id']])->get()->toArray();

                $create  = \App\Safari\SafariTransportationPrice::create($content);

                Session::flash('message', 'Safari added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariTransportationPrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTransportationPrice'));
            }
        }
    }

    public function editSafariTransportationPrice(Request $request){
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
            return \Redirect::to(url('admin/safariTransportationPrice'));

        }else {
            try {
                $safariTransportationPricelist = \App\Safari\SafariTransportationPrice::where('id', [$content['id']])->get()->toArray();
                $safarilist = \App\Safari\Safari::all()->toArray();
                $transporttypeslist = \App\Transportation\TransportationTypes::all()->toArray();

                return view('Admin/safari/safariTransportationPrice/edit',['safariTransportationPrice'=>$safariTransportationPricelist[0],'safariData'=> $safarilist,'transporttypesData'=>$transporttypeslist]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTransportationPrice'));
            }
        }
    }

    public function updateSafariTransportationPrice(Request $request){
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content      = $request->all();
        $safaritransportpriceId = $content['id'];

        $validator = \Validator::make($request->all(), [
            'safari_id'   => 'required',
            'transportation_id'   => 'required',
            'adult_price_india' => 'required',
            'child_price_india' => 'required',
            'senior_price_india' => 'required',
            'adult_price_foreign' => 'required',
            'child_price_foreign' => 'required',
            'senior_price_foreign' => 'required',
            'no_of_seats' => 'required',
            'allow_seat_selection' => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTransportationPrice'));

        }else {
            try {

                unset($content['_token']);
                unset($content['id']);

                $update  = \App\Safari\SafariTransportationPrice::where('id', $safaritransportpriceId)->update($content);

                Session::flash('message', 'Safari Transportation Price updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariTransportationPrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTransportationPrice'));
            }
        }
    }

    public function deleteSafariTransportationPrice(Request $request){

        $success = \Config::get('common.delete_success_response');
        $failure = \Config::get('common.upload_failure_response');
        $content      = $request->all();
        $safaritransportpriceId      = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariTransportationPrice'));

        }else {
            try {

                unset($content['_token']);
                unset($content['id']);

                $delete  = \App\Safari\SafariTransportationPrice::where('id', $safaritransportpriceId)->delete();

                Session::flash('message', 'Safari Transportation Price deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safariTransportationPrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safariTransportationPrice'));
            }
        }
    }

}
