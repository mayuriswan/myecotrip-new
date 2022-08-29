<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LandscapeController extends Controller
{
    public function index()
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {

        	$landscapelist = \App\Landscape::where('status',1)
                            ->orderBy('display_order_no')
                            ->get()
                            ->toArray();

            // get number of trek in each landscape
            foreach($landscapelist as $index => $landscape){
                $getTrekCount = \App\Trail::where('landscape_id', $landscape['id'])
                                ->where('status',1)
                                ->get()
                                ->toArray();
                $landscapelist[$index]['trailCount'] = count($getTrekCount);
            }

            // Get the upcoming trials list
            $trailList = \App\TrialUpcoming::where('status', 1)->get()->toArray();

            // echo '<pre>';print_r($landscapelist);exit;
        	return view('ecotrails/landscapes', ['landscapeList'=> $landscapelist, 'trailList' => $trailList]);
        } catch (Exception $e) {
        	// Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
            // Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('home');
        }
    }
}
