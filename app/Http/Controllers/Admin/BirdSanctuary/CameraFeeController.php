<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class CameraFeeController extends Controller
{
    public function getCameraFee(Request $request, $birdSanctuaryId){
        try{

            $getCurrentVersion = $this->birdSancturyFunctionVersion($birdSanctuaryId, 'camera_fee_version');

            $birdSanctuaryPriceData = \App\BirdSanctuary\cameraFee::where('birdSanctuary_id', $birdSanctuaryId)
                ->join('birdSanctuaryCameraType' , 'birdSanctuaryCameraType.id' , '=', 'birdSanctuaryCameraFee.cameratype_id')
                ->select('birdSanctuaryCameraFee.*','birdSanctuaryCameraType.type')
                ->where('version', $getCurrentVersion)
                ->orderBy('birdSanctuaryCameraType.type')
                ->get()
                ->toArray();


            // echo "<pre>"; print_r($birdSanctuaryPriceData);exit();
            return view('Admin/birdSanctuary/cameraFee/index',['cameraFeeList'=> $birdSanctuaryPriceData, 'birdSanctuaryId' => $birdSanctuaryId]);

        }catch (Exception $e){
            \Session::flash('alert-danger', 'Sorry could not process. '. $e->getMessage());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function addCameraFee(Request $request, $birdSancturyId){

        try {

            //See what all entrance s available
            $getEntranceAvailable = \App\BirdSanctuary\birdSanctuary::where('id', $birdSancturyId)->get()->toArray();

            $getCurrentVersion = $this->birdSancturyFunctionVersion($birdSancturyId, 'camera_fee_version');


            $entranceAvailable = json_decode($getEntranceAvailable[0]['camera_types'],true);

            //Get the pricing masters
            $getRow = \App\BirdSanctuary\cameraType::whereIn('id', $entranceAvailable)->where('isActive', 1)->get()->toArray();

            // echo "<pre>";print_r($getRow);exit();

            return view('Admin/birdSanctuary/cameraFee/add', ['data'=> $getRow, 'birdSancturyId' => $birdSancturyId, 'currentVersion' => $getCurrentVersion]);
        } catch (Exception $e) {
            \Session::flash('alert-danger', 'Sorry could not process. '. $e->getMessage());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function getCameraTypes(Request $request, $birdSanctuaryId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $birdSanctuary = \App\BirdSanctuary\birdSanctuary::where('id',$birdSanctuaryId)->get()->toArray();

            $cameraTypeList = \App\BirdSanctuary\cameraType::whereIn('id',json_decode($birdSanctuary[0]['camera_types']))->get()->toArray();

            // echo "<pre>"; print_r($cameraTypeList);exit();
            return view('Admin/birdSanctuary/cameraFee/dynamic',['cameraTypeData'=> $cameraTypeList]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraFee'));
        }
    }

    public function createCameraFee(Request $request){
        // echo "<pre>"; print_r($_POST);exit();
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();

        $validator = \Validator::make($request->all(),[
            'birdSanctuary_id' => 'required',
            'version' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'isActive' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraFee'));

        }else {
            try {
                $types = $content['type'];
                unset($content['type']);

                $content['version'] += 1;

                foreach ($types as $key => $value) {
                    $content['cameratype_id'] = $key;
                    $content['price'] = $value;

                    $create  = \App\BirdSanctuary\cameraFee::create($content);

                }

                $update  = \App\BirdSanctuary\birdSanctuary::where('id', $content['birdSanctuary_id'])->update(['camera_fee_version' => $content['version'] ]);


                \Session::flash('alert-success', 'Price added successfully');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
                
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraFee'));
            }
        }
    }

    public function editCameraFee(Request $request)
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
            return \Redirect::to(url('admin/cameraFee'));

        }else {
            try {
                $cameraFeeData = \App\BirdSanctuary\cameraFee::where('id', [$content['id']])->get()->toArray();

                $birdSanctuaryList = \App\BirdSanctuary\birdSanctuary::all()->toArray();
                $cameraTypeList = \App\BirdSanctuary\cameraType::all()->toArray();

                return view('Admin/birdSanctuary/cameraFee/edit',['cameraFeeData'=>$cameraFeeData[0],'birdSanctuaryList'=>$birdSanctuaryList,'cameraTypeList'=>$cameraTypeList]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraFee'));
            }
        }
    }

    public function updateCameraFee(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $cameraFeeId     = $content['cameraFeeId'];

        $validator = \Validator::make($request->all(), [
            'birdSanctuary_id' => 'required',
            'cameratype_id' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraFee'));

        }else {
            try {

                unset($content['_token']);
                unset($content['cameraFeeId']);

                $update  = \App\BirdSanctuary\cameraFee::where('id', $cameraFeeId)->update($content);

                Session::flash('message', 'Camera Fee updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/cameraFee'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraFee'));
            }
        }
    }

    public function deleteCameraFee(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $cameraFeeId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/cameraFee'));

        }else {
            try {
                $delete  = \App\BirdSanctuary\cameraFee::where('id', $cameraFeeId)->delete();

                Session::flash('message', 'Camera Fee deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/cameraFee'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/cameraFee'));
            }
        }
    }
}
