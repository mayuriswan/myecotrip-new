<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class BirdSanctuaryPriceController extends Controller
{
    public function getBirdSanctuaryPrice(Request $request, $birdSanctuaryId){
        try{

            $getCurrentVersion = $this->birdSancturyFunctionVersion($birdSanctuaryId, 'entrance_fee_version');

            $birdSanctuaryPriceData = \App\BirdSanctuary\birdSanctuaryPrice::where('birdSanctuary_id', $birdSanctuaryId)
                ->join('birdSanctuaryPricingMasters' , 'birdSanctuaryPricingMasters.id' , '=', 'birdSanctuaryEntryFee.pricing_master_id')
                ->select('birdSanctuaryEntryFee.*','birdSanctuaryPricingMasters.name')
                ->where('version', $getCurrentVersion)
                ->orderBy('birdSanctuaryPricingMasters.name')
                ->get()
                ->toArray();


            // echo "<pre>"; print_r($birdSanctuaryPriceData);exit();

            return view('Admin/birdSanctuary/birdSanctuaryPrice/index',['birdSanctuaryPrice'=> $birdSanctuaryPriceData,'birdSanctuaryId' => $birdSanctuaryId]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuaryPrice'));
        }
    }

    public function addBirdSanctuaryPrice(Request $request, $birdSancturyId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            //See what all entrance s available
            $getEntranceAvailable = \App\BirdSanctuary\birdSanctuary::where('id', $birdSancturyId)->get()->toArray();

            $getCurrentVersion = $this->birdSancturyFunctionVersion($birdSancturyId, 'entrance_fee_version');


            $entranceAvailable = json_decode($getEntranceAvailable[0]['entrance_type'],true);

            //Get the pricing masters
            $getRow = \App\BirdSanctuary\birdSanctuaryPricingMasters::whereIn('id', $entranceAvailable)->get()->toArray();

            // echo "<pre>";print_r($getRow);exit();

            return view('Admin/birdSanctuary/birdSanctuaryPrice/add', ['data'=> $getRow, 'birdSancturyId' => $birdSancturyId, 'currentVersion' => $getCurrentVersion]);
        } catch (Exception $e) {
            \Session::flash('alert-danger', 'Sorry could not process. '. $e->getMessage());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function createBirdSanctuaryPrice(Request $request){

        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();

        $validator = \Validator::make($request->all(),[
            'birdSanctuary_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'isActive' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            \Session::flash('alert-danger', $validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);

        }else {
            try {
                $types = $content['type'];
                unset($content['type']);

                $content['version'] += 1;

                foreach ($types as $key => $value) {
                    $content['pricing_master_id'] = $key;
                    $content['price'] = $value;

                    $create  = \App\BirdSanctuary\birdSanctuaryPrice::create($content);

                }

                $update  = \App\BirdSanctuary\birdSanctuary::where('id', $content['birdSanctuary_id'])->update(['entrance_fee_version' => $content['version'] ]);


                \Session::flash('alert-success', 'BirdSanctuary Price added successfully');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);

            }catch (Exception $e){
                \Session::flash('alert-danger', 'Sorry could not process. ' . $e->getMessage());
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }
    }

    public function editBirdSanctuaryPrice(Request $request)
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
            return \Redirect::to(url('admin/birdSanctuaryPrice'));

        }else {
            try {
                $birdSanctuaryPriceData = \App\BirdSanctuary\birdSanctuaryPrice::where('id', [$content['id']])->get()->toArray();

                $birdSanctuarylist = \App\BirdSanctuary\birdSanctuary::all()->toArray();

                return view('Admin/birdSanctuary/birdSanctuaryPrice/edit',['birdSanctuaryPriceData'=>$birdSanctuaryPriceData[0],'birdSanctuarylist'=>$birdSanctuarylist]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuaryPrice'));
            }
        }
    }

    public function updateBirdSanctuaryPrice(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $birdSanctuaryPriceId     = $content['birdSanctuaryPriceId'];

        $validator = \Validator::make($request->all(), [
            'birdSanctuary_id' => 'required',
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
            return \Redirect::to(url('admin/birdSanctuaryPrice'));

        }else {
            try {

                unset($content['_token']);
                unset($content['birdSanctuaryPriceId']);

                $update  = \App\BirdSanctuary\birdSanctuaryPrice::where('id', $birdSanctuaryPriceId)->update($content);

                Session::flash('message', 'BirdSanctuary Price updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdSanctuaryPrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuaryPrice'));
            }
        }
    }

    public function deleteBirdSanctuaryPrice(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $birdSanctuaryPriceId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuaryPrice'));

        }else {
            try {
                $delete  = \App\BirdSanctuary\birdSanctuaryPrice::where('id', $birdSanctuaryPriceId)->delete();

                Session::flash('message', 'BirdSanctuary Price deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdSanctuaryPrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuaryPrice'));
            }
        }
    }
}
