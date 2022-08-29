<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class ParkingFeeController extends Controller
{
    public function getParkingFee(Request $request, $birdSanctuaryId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $getCurrentVersion = $this->birdSancturyFunctionVersion($birdSanctuaryId, 'parking_fee_version');

            $birdSanctuaryPriceData = \App\BirdSanctuary\parkingFee::where('birdSanctuary_id', $birdSanctuaryId)
                ->join('birdSanctuaryParkingVehicleType' , 'birdSanctuaryParkingVehicleType.id' , '=', 'birdSanctuaryParkingFee.vehicletype_id')
                ->select('birdSanctuaryParkingFee.*','birdSanctuaryParkingVehicleType.type')
                ->where('version', $getCurrentVersion)
                ->orderBy('birdSanctuaryParkingVehicleType.type')
                ->get()
                ->toArray();

            // echo "<pre>"; print_r($birdSanctuaryPriceData);exit();
            return view('Admin/birdSanctuary/parkingFee/index',['parkingFeeList'=> $birdSanctuaryPriceData, 'birdSanctuaryId' => $birdSanctuaryId]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingFee'));
        }
    }

    public function addParkingFee(Request $request, $birdSancturyId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
        
            //See what all vehicles s available
            $getEntranceAvailable = \App\BirdSanctuary\birdSanctuary::where('id', $birdSancturyId)->get()->toArray();

            $getCurrentVersion = $this->birdSancturyFunctionVersion($birdSancturyId, 'parking_fee_version');


            $entranceAvailable = json_decode($getEntranceAvailable[0]['vehicle_types'],true);

            //Get the pricing masters
            $getRow = \App\BirdSanctuary\parkingVehicleType::whereIn('id', $entranceAvailable)->get()->toArray();

            // echo '<pre>';print_r($getRow); exit();
            return view('Admin/birdSanctuary/parkingFee/add', ['data'=> $getRow,'birdSancturyId' => $birdSancturyId, 'currentVersion' => $getCurrentVersion]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingFee'));
        }
    }

    public function getParkingDetails(Request $request, $birdSanctuaryId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $birdSanctuary = \App\BirdSanctuary\birdSanctuary::where('id',$birdSanctuaryId)->get()->toArray();

            $parkingVehicleTypeList = \App\BirdSanctuary\parkingVehicleType::whereIn('id',json_decode($birdSanctuary[0]['vehicle_types']))->get()->toArray();

            // echo "<pre>"; print_r($parkingVehicleTypeList);exit();
            return view('Admin/birdSanctuary/parkingFee/dynamic',['parkingVehicleTypeList'=>$parkingVehicleTypeList]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingFee'));
        }
    }

    public function createParkingFee(Request $request){

        // echo "<pre>"; print_r($_POST);exit();
        $content = $request->all();

        $validator = \Validator::make($request->all(),[
            'birdSanctuary_id' => 'required',
            'version' => 'required',
            'type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'isActive' => 'required'
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
                    $content['vehicletype_id'] = $key;
                    $content['price'] = $value;

                    $create  = \App\BirdSanctuary\parkingFee::create($content);
                }

                $update  = \App\BirdSanctuary\birdSanctuary::where('id', $content['birdSanctuary_id'])->update(['parking_fee_version' => $content['version'] ]);

                \Session::flash('alert-success', 'Price added successfully');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
                
            }catch (Exception $e){
               \Session::flash('alert-danger', 'Sorry could not process. ' . $e->getMessage());
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }
    }

    public function editParkingFee(Request $request)
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
            return \Redirect::to(url('admin/parkingFee'));

        }else {
            try {
                $parkingFeeData = \App\BirdSanctuary\parkingFee::where('id', [$content['id']])->get()->toArray();

                $birdSanctuaryList = \App\BirdSanctuary\birdSanctuary::all()->toArray();
                $parkingTypeList = \App\BirdSanctuary\parkingType::all()->toArray();
                $parkingVehicleTypeList = \App\BirdSanctuary\parkingVehicleType::all()->toArray();

                return view('Admin/birdSanctuary/parkingFee/edit',['parkingFeeData'=>$parkingFeeData[0],'birdSanctuaryList'=>$birdSanctuaryList,'parkingTypeList'=>$parkingTypeList,'parkingVehicleTypeList'=>$parkingVehicleTypeList]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingFee'));
            }
        }
    }

    public function updateParkingFee(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $parkingFeeId     = $content['parkingFeeId'];

        $validator = \Validator::make($request->all(), [
            'birdSanctuary_id' => 'required',
            'parkingtype_id' => 'required',
            'vehicletype_id' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingFee'));

        }else {
            try {

                unset($content['_token']);
                unset($content['parkingFeeId']);

                $update  = \App\BirdSanctuary\parkingFee::where('id', $parkingFeeId)->update($content);

                Session::flash('message', 'Parking Fee updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/parkingFee'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingFee'));
            }
        }
    }

    public function deleteParkingFee(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $parkingFeeId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/parkingFee'));

        }else {
            try {
                $delete  = \App\BirdSanctuary\parkingFee::where('id', $parkingFeeId)->delete();

                Session::flash('message', 'Parking Fee deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/parkingFee'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/parkingFee'));
            }
        }
    }
}
