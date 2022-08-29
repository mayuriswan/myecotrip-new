<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class AITEController extends Controller
{
    public function register(Request $request)
    {
    	// get the tigerReserves list
    	$tigerReservesList = \App\Events\TigerReserve::where('remaningSlots','>',0)->get()->toArray();

    	return view('events/AITE/registration',['tigerReservesList' => $tigerReservesList]);
    }

    public function registerAITE(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
        	$data = $_POST;

            $checkDuplicate = \App\Events\AITERegistratons::where('VTP_ID',$data['VTP_ID'])->get()->toArray();

            if (count($checkDuplicate) > 0) {
            	Session::flash('profileUpdateMessage', 'VTP_ID already registered'); 
                Session::flash('alert-class', 'alert-danger');

            }else{
            	$saveData = \App\Events\AITERegistratons::create($data);

            	// reduce slots
            	$getData = \App\Events\TigerReserve::where('name',$data['tiger_reserve'])->decrement('remaningSlots');;

            	Session::flash('profileUpdateMessage', 'Registered successfully'); 
                Session::flash('alert-class', 'alert-success');

            }
            return redirect()->route('AITE-Registration');

        } catch (Exception $e) {
        	Session::flash('profileUpdateMessage', $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('AITE-Registration');
        }
    }
}
