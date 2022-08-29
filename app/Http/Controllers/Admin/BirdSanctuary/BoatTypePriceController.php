<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class BoatTypePriceController extends Controller
{
    public function birdSanctuaryList(Request $request, $requestFrom = Null)
    {
        try{
            $birdSanctuarylist = \App\BirdSanctuary\birdSanctuary::select('id','name')->where('isActive', 1)->orderBy('name')->get()->toArray();

            // echo "<pre>"; print_r($birdSanctuarylist);exit();
            return view('Admin/birdSanctuary/boatTypePrice/birdSanctuary',['birdSanctuarylist'=> $birdSanctuarylist, 'requestFrom' => $requestFrom]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatTypePrice'));
        }
    }


    public function getBoatTypePrice(Request $request, $birdSanctuaryId){
        try{

            $getCurrentVersion = $this->birdSancturyFunctionVersion($birdSanctuaryId, 'boating_fee_version');

            $birdSanctuaryPriceData = \App\BirdSanctuary\boatTypePrice::where('birdSanctuary_id', $birdSanctuaryId)
                ->join('birdSanctuaryBoatType' , 'birdSanctuaryBoatType.id' , '=', 'birdSanctuaryBoatTypePrice.boatType_id')
                ->join('birdSanctuaryPricingMasters', 'birdSanctuaryPricingMasters.id','=','birdSanctuaryBoatTypePrice.pricing_master_id')
                ->select('birdSanctuaryBoatTypePrice.*','birdSanctuaryBoatType.name','birdSanctuaryPricingMasters.name as unit')
                ->where('version', $getCurrentVersion)
                ->orderBy('name')
                ->get()
                ->toArray();

            // echo "<pre>"; print_r($birdSanctuaryPriceData);exit();
            return view('Admin/birdSanctuary/boatTypePrice/index',['boatTypePrice'=> $birdSanctuaryPriceData, 'birdSanctuaryId' => $birdSanctuaryId]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatTypePrice'));
        }
    }

    public function addBoatTypePrice(Request $request, $birdSanctuaryId){
        
        try{
            

            //get the row
            $getRow = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->get()->toArray();
            $boatTypes = json_decode($getRow[0]['boat_types']);

            $boatTypeData = \App\BirdSanctuary\boatType::whereIn('id',$boatTypes)->get()->toArray();
                
            $pricinMaster = \App\BirdSanctuary\birdSanctuaryPricingMasters::where('status', 1)->get()->toArray();

            // echo '<pre>';print_r($boatTypeData);exit();
            return view('Admin/birdSanctuary/boatTypePrice/add',['boatTypeData'=>$boatTypeData, 'birdSanctuaryId' => $birdSanctuaryId, 'pricinMaster' => $pricinMaster]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatTypePrice'));
        }
    }

    public function getBoatTypes(Request $request, $birdSanctuaryId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $getRow = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->get()->toArray();
            $boatTypes = json_decode($getRow[0]['boat_types']);

            $boatTypeData = \App\BirdSanctuary\boatType::whereIn('id',$boatTypes)->get()->toArray();

            return view('Admin/birdSanctuary/boatTypePrice/dynamic',['boatTypeData'=> $boatTypeData]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatTypePrice'));
        }
    }

    public function createBoatTypePrice(Request $request){
        $content      = $request->all();
        $validator = \Validator::make($request->all(), [
            'birdSanctuary_id'   => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'isActive'   => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);

        }else {
            try {
                $getCurrentVersion = $this->birdSancturyFunctionVersion($content['birdSanctuary_id'], 'boating_fee_version');

                $getCurrentVersion += 1;
                foreach ($content['type'] as $key => $value) {
                    $explodeData = explode("||", $key);
                    $content['pricing_master_id'] = $explodeData[0];
                    $content['boatType_id'] = $explodeData[1];
                    $content['price'] = $value;
                    $content['version'] = $getCurrentVersion;

                    $create  = \App\BirdSanctuary\boatTypePrice::create($content);

                }

                $update  = \App\BirdSanctuary\birdSanctuary::where('id', $content['birdSanctuary_id'])->update(['boating_fee_version' => $getCurrentVersion ]);

                \Session::flash('alert-success', 'Pricing added successfully');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }catch (Exception $e){
                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }
    }

    public function editBoatTypePrice(Request $request)
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
            return \Redirect::to(url('admin/boatTypePrice'));

        }else {
            try {
                $boatTypePriceData = \App\BirdSanctuary\boatTypePrice::where('id', [$content['id']])->get()->toArray();
                $boatTypeData = \App\BirdSanctuary\boatType::all()->toArray();
                $birdSanctuarylist = \App\BirdSanctuary\birdSanctuary::all()->toArray();

                // echo "<pre>"; print_r($boatTypePriceData);exit();
                return view('Admin/birdSanctuary/boatTypePrice/edit',['boatTypePriceData'=>$boatTypePriceData[0],'birdSanctuarylist'=>$birdSanctuarylist,'boatTypeData'=>$boatTypeData]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/boatTypePrice'));
            }
        }
    }

    public function updateBoatTypePrice(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        // echo "<pre>"; print_r($content);exit();
        $boatTypePriceId     = $content['boatTypePriceId'];

        $validator = \Validator::make($request->all(), [
            'birdSanctuary_id'   => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'full_booking' => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatTypePrice').'/'. $content['birdSanctuary_id']);

        }else {
            try {

                unset($content['_token']);
                unset($content['boatTypePriceId']);

                $update  = \App\BirdSanctuary\boatTypePrice::where('id', $boatTypePriceId)->update($content);

                Session::flash('message', 'Boat Type Price updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/boatTypePrice').'/'. $content['birdSanctuary_id']);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/boatTypePrice').'/'. $content['birdSanctuary_id']);
            }
        }
    }

    public function deleteBoatTypePrice(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $boatTypePriceId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/boatTypePrice'));

        }else {
            try {
                $delete  = \App\BirdSanctuary\boatTypePrice::where('id', $boatTypePriceId)->delete();

                Session::flash('message', 'Boat Type Price deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/boatTypePrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/boatTypePrice'));
            }
        }
    }
}
