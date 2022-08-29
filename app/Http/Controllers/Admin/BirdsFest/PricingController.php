<?php

namespace App\Http\Controllers\Admin\BirdsFest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class PricingController extends Controller
{
    public function addEventPricing(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $eventList = \App\BirdsFest\birdsFestDetails::all()->toArray();

            return view('Admin/birdsFest/addPrice', ['eventList'=> $eventList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdsFest'));
        }
    }

    public function saveEventPricing(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'event_id'   => 'required',
            'name'   => 'required',
            'per_head_price'   => 'required',
            'no_of_slots'   => 'required',
            //'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/addEventPricing'));

        }else {
            $checkDuplicate = \App\BirdsFest\birdFestPricings::whereRaw('LOWER(name) = ?', [$content['name']])
                            ->where('event_id',$content['event_id'])
                            ->get()
                            ->toArray();

            if(count($checkDuplicate) > 0)
            {
                Session::flash('message', 'Sorry pricing with this name and event exist!!');
                Session::flash('alert-class', 'alert-danger');

                return \Redirect::to(url('admin/addEventPricing'));
            }
            else{
                $content['remaining_slots'] = $content['no_of_slots'];

                $create  = \App\BirdsFest\birdFestPricings::create($content);

                Session::flash('message','Added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/addEventPricing'));
            }
        }
    }
}
