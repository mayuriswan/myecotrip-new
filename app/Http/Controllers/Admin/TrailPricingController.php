<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\Exception;

use Session;

class TrailPricingController extends Controller
{
    public function getTrialPricing(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $ecoTrailsPricing = \App\TrailPricing::all()->toArray();
 
            foreach ($ecoTrailsPricing as $key => $value) {
            	$getEcoTrailTimeSlot = \App\EcoTrailTimeSlots::where('id',$value['ecotrailTimeSlots_id'])->get()->toArray();

            	$getTrails = \App\Trail::where('id',$value['trail_id'])->get()->toArray();

            	$priceList = json_decode($ecoTrailsPricing[$key]['price'], true);

			    $indiaAdultPrice = $priceList['India']['adult']['TAC'] + $priceList['India']['adult']['entry_fee'] + $priceList['India']['adult']['guide_fee'];
                $indiaChildPrice = $priceList['India']['child']['TAC_child'] + $priceList['India']['child']['entry_fee_child'] + $priceList['India']['child']['guide_fee_child'];

                $indiaStudentPrice = 0;
                if (isset($priceList['India']['student'])) {
                    $indiaStudentPrice = $priceList['India']['student']['TAC'] + $priceList['India']['student']['entry_fee'] + $priceList['India']['student']['guide_fee'];


                }
            	
            	$ecoTrailsPricing[$key]['timeslots'] = $getEcoTrailTimeSlot[0]['timeslots'];
            	$ecoTrailsPricing[$key]['trailName'] = $getTrails[0]['name'];
            	$ecoTrailsPricing[$key]['indiaAdultPrice'] = $indiaAdultPrice;
            	$ecoTrailsPricing[$key]['indiaChildPrice'] = $indiaChildPrice;
                $ecoTrailsPricing[$key]['indiaStudentPrice'] = $indiaStudentPrice;

            }
            

            return view('Admin/trailsPricing/index',['ecoTrailsPricing'=>$ecoTrailsPricing]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/getTrialPricing'));
        }
    }

    public function addTrialPricing(Request $request){
		$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $getTrails = \App\Trail::all()->toArray();
            $getEcoTrailTimeSlots = \App\EcoTrailTimeSlots::all()->toArray();
            return view('Admin/trailsPricing/add',['getTrails'=>$getTrails,'getEcoTrailTimeSlots'=>$getEcoTrailTimeSlots]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/getTrialPricing'));
        }
    }

    public function createTrialPricing(Request $request){
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();
        
        $validator = \Validator::make($request->all(),[
        	'ecotrailTimeSlots_id' => 'required',
            'trail_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/getTrialPricing'));

        }else {
            try {
                $trailPricinglist = \App\TrailPricing::whereRaw('LOWER(ecotrailTimeSlots_id) = ?', [$content['ecotrailTimeSlots_id']])
                												->whereRaw('LOWER(trail_id) = ?', [$content['trail_id']])
                												->get()->toArray();
				if(count($trailPricinglist) > 0)
				{
					Session::flash('message', 'This is Duplicate Entry');
	                Session::flash('alert-class', 'alert-success');
				}else{
					$content['from'] = $content['from']." 00:00:00";
					$content['to'] = $content['to']." 23:59:59";
					$create = [];
					$create['ecotrailTimeSlots_id'] = $content['ecotrailTimeSlots_id'];
					$create['trail_id'] = $content['trail_id'];
					$create['from'] = $content['from'];
					$create['to'] = $content['to'];
					$create['price'] = json_encode($content['data']);
					$create['status'] = $content['status'];

					$insert  = \App\TrailPricing::create($create);

	                Session::flash('message', 'Trail Price added successfully');
	                Session::flash('alert-class', 'alert-success');
				}                												
                return \Redirect::to(url('admin/getTrialPricing'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/getTrialPricing'));
            }
        }
    }

    public function editTrialPricing(Request $request)
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
            return \Redirect::to(url('admin/getTrialPricing'));

        }else {
            try {
                $trailPricingData = \App\TrailPricing::where('id', [$content['id']])->get()->toArray();
                $getTrails = \App\Trail::all()->toArray();
                $getEcoTrailTimeSlots = \App\EcoTrailTimeSlots::all()->toArray();

                $prices = [];
                $priceList = json_decode($trailPricingData[0]['price'], true);
                // echo "<pre>"; print_r($priceList);exit();
			    $prices['india_adult_tac'] = $priceList['India']['adult']['TAC'];
                $prices['india_adult_entry_fee'] = $priceList['India']['adult']['entry_fee'];
                $prices['india_adult_guide_fee'] = $priceList['India']['adult']['guide_fee'];
                $prices['india_child_tac'] = $priceList['India']['child']['TAC_child'];
                $prices['india_child_entry_fee'] = $priceList['India']['child']['entry_fee_child'];
                $prices['india_child_guide_fee'] = $priceList['India']['child']['guide_fee_child'];
                $prices['india_student_tac'] = $priceList['India']['student']['TAC'];
                $prices['india_student_entry_fee'] = $priceList['India']['student']['entry_fee'];
                $prices['india_student_guide_fee'] = $priceList['India']['student']['guide_fee'];

                $prices['foreign_adult_tac'] = $priceList['Foreign']['adult']['TAC_foreign'];
                $prices['foreign_adult_entry_fee'] = $priceList['Foreign']['adult']['entry_fee_foreign'];
                $prices['foreign_adult_guide_fee'] = $priceList['Foreign']['adult']['guide_fee_foreign'];
                $prices['foreign_child_tac'] = $priceList['Foreign']['child']['TAC_foreign_child'];
                $prices['foreign_child_entry_fee'] = $priceList['Foreign']['child']['entry_fee_foreign_child'];
                $prices['foreign_child_guide_fee'] = $priceList['Foreign']['child']['guide_fee_foreign_child'];
                $prices['foreign_student_tac'] = $priceList['Foreign']['student']['TAC_foreign_student'];
                $prices['foreign_student_entry_fee'] = $priceList['Foreign']['student']['entry_fee_foreign_student'];
                $prices['foreign_student_guide_fee'] = $priceList['Foreign']['student']['guide_fee_foreign_student'];

			    $fromdate = explode(' ', $trailPricingData[0]['from']);
			    $trailPricingData[0]['from'] = $fromdate[0];

			    $todate = explode(' ', $trailPricingData[0]['to']);
			    $trailPricingData[0]['to'] = $todate[0];

                return view('Admin/trailsPricing/edit',['trailPricingData'=>$trailPricingData[0],'getTrails'=>$getTrails,'getEcoTrailTimeSlots'=>$getEcoTrailTimeSlots,'prices'=>$prices]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/getTrialPricing'));
            }
        }
    }

    public function updateTrialPricing(Request $request){
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();
        $trailPricingId     = $content['trailPricingId'];
        
        $validator = \Validator::make($request->all(),[
        	'ecotrailTimeSlots_id' => 'required',
            'trail_id' => 'required',
            'from' => 'required',
            'to' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/getTrialPricing'));

        }else {
            try {
            	unset($content['_token']);
                unset($content['trailPricingId']);

				$content['from'] = $content['from']." 00:00:00";
				$content['to'] = $content['to']." 23:59:59";
				$create = [];
				$create['ecotrailTimeSlots_id'] = $content['ecotrailTimeSlots_id'];
				$create['trail_id'] = $content['trail_id'];
				$create['from'] = $content['from'];
				$create['to'] = $content['to'];
				$create['price'] = json_encode($content['data']);
				$create['status'] = $content['status'];

				$update  = \App\TrailPricing::where('id', $trailPricingId)->update($create);

                Session::flash('message', 'Trail Price updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/getTrialPricing'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/getTrialPricing'));
            }
        }
    }

    public function deleteTrialPricing(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $trailPricingId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/getTrialPricing'));

        }else {
            try {

                unset($content['_token']);
                unset($content['trailPricingId']);

                $delete  = \App\TrailPricing::where('id', $trailPricingId)->delete();

                Session::flash('message', 'Trail Pricing deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/getTrialPricing'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/getTrialPricing'));
            }
        }
    }
}
