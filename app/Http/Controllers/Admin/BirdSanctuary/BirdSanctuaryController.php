<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class BirdSanctuaryController extends Controller
{
    public function getBirdSanctuary(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $birdSanctuaryList = \App\BirdSanctuary\birdSanctuary::all()->toArray();

            foreach ($birdSanctuaryList as $index => $birdSanctuaryListData){
                $getParkData = \App\Parks::where('id',$birdSanctuaryListData['park_id'])->get()->toArray();

                $birdSanctuaryList[$index]['parkname'] = $getParkData[0]['name'];
            }
            return view('Admin/birdSanctuary/index', ['birdSanctuaryList'=> $birdSanctuaryList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuary'));
        }
    }

    public function addBirdSanctuary(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $parklist = \App\Parks::all()->toArray();
            $boatTypeList = \App\BirdSanctuary\boatType::where('isActive', 1)->orderBy('name')->get()->toArray();
            $cameraTypeList = \App\BirdSanctuary\cameraType::where('isActive', 1)->orderBy('type')->get()->toArray();


            $parkingVehicleType = \App\BirdSanctuary\parkingVehicleType::where('isActive', 1)->get()->toArray();

            // echo "<pre>"; print_r($parkingVehicleType);exit();
            return view('Admin/birdSanctuary/add', ['parkList'=> $parklist, 'boatTypeList' =>$boatTypeList, 'parkingVehicleType' => $parkingVehicleType, 'cameraTypeList' =>$cameraTypeList]);

        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuary'));
        }
    }

    public function createBirdSanctuary(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();
        // echo "<pre>"; print_r($content);exit();

        $validator = \Validator::make($request->all(), [
            'park_id'   => 'required',
            'name'   => 'required',
            'description'   => 'required',
            'meta_desc'   => 'required',
            'meta_title'   => 'required',
            'keywords'   => 'required',
            'activity'   => 'required',
            'contactinfo'   => 'required',
            'isActive'   => 'required',
            //'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuary'));

        }else {
            try {
                $birdSanctuarylist = \App\BirdSanctuary\birdSanctuary::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($birdSanctuarylist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Bird Sanctuary is already existed!!";
                    Session::flash('message', 'Sorry this Bird Sanctuary is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/birdSanctuary'));
                }
                else{

                    // Upload Image
                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/birdSanctuary/';
                    $destinationFileName = time().".$ext";
                    $pathToSacveInDB = 'birdSanctuary-logo/'.$destinationFileName;

                    $pathToSacveInDB = $this->S3upload($request, 'logo', $pathToSacveInDB);
                    $content['logo'] = $pathToSacveInDB;
                    $content['boat_types'] = json_encode($content['boat_types']);
                    $content['vehicle_types'] = json_encode($content['vehicle_types']);
                    $content['camera_types'] = json_encode($content['camera_types']);

                    $create  = \App\BirdSanctuary\birdSanctuary::create($content);

                    $birdSanctuaryId = $create->id;
                    $birdSanctuaryIdFolder = 'BirdSanctuaryId-'.$birdSanctuaryId;

                    // echo "<pre>"; print_r($content);exit();
                    if ($content['birdSanctuaryImages']) {
                        if($files=$request->file('birdSanctuaryImages')){
                            foreach($files as $index => $file){
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                                $destinationFileName = time().$index.".$ext";
                                $pathToSacveInDB = 'birdSanctuary/'.$birdSanctuaryIdFolder.'/'.$destinationFileName;

                                $s3 = \Storage::disk('s3');
                                $s3->put($pathToSacveInDB, file_get_contents($file), 'public');
                                $pathToSacveInDB = \Storage::disk('s3')->url($pathToSacveInDB);

                                $birdSanctuaryList['birdSanctuary_id'] = $birdSanctuaryId;
                                $birdSanctuaryList['name'] = $pathToSacveInDB;

                                $create  = \App\BirdSanctuary\birdSanctuaryImages::create($birdSanctuaryList);
                            }
                        }
                    }

                    Session::flash('message', 'Bird Sanctuary added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/birdSanctuary'));
                }
            }catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuary'));
            }
        }
    }

    public function editBirdSanctuary(Request $request)
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
            return \Redirect::to(url('admin/birdSanctuary'));

        }else {
            try {
                $boatTypeList = \App\BirdSanctuary\boatType::where('isActive', 1)->orderBy('name')->get()->toArray();

                $parkingVehicleType = \App\BirdSanctuary\parkingVehicleType::where('isActive', 1)->get()->toArray();

                $cameraTypeList = \App\BirdSanctuary\cameraType::where('isActive', 1)->orderBy('type')->get()->toArray();


                $birdSanctuaryData = \App\BirdSanctuary\birdSanctuary::where('id', [$content['id']])->get()->toArray();
                $birdSanctuaryData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                $parklist = \App\Parks::all()->toArray();
                $birdSanctuaryDataImages = \App\BirdSanctuary\birdSanctuaryImages::where('birdSanctuary_id',$content['id'])->get()->toArray();

                $birdSanctuaryData[0]['boat_types'] = json_decode($birdSanctuaryData[0]['boat_types'], true);
                $birdSanctuaryData[0]['vehicle_types'] = json_decode($birdSanctuaryData[0]['vehicle_types'], true);
                $birdSanctuaryData[0]['camera_types'] = json_decode($birdSanctuaryData[0]['camera_types'], true);

                


                // echo "<pre>"; print_r($birdSanctuaryData);exit();
                return view('Admin/birdSanctuary/edit',['birdSanctuaryData'=>$birdSanctuaryData[0],'parkList'=>$parklist,'birdSanctuaryDataImages'=>$birdSanctuaryDataImages, 'boatTypeList' => $boatTypeList, 'parkingVehicleType' => $parkingVehicleType, 'cameraTypeList'=>$cameraTypeList]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuary'));
            }
        }
    }

    public function updateBirdSanctuary(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $birdSanctuaryId     = $content['birdSanctuaryId'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'park_id'   => 'required',
            'name'   => 'required',
            'description'   => 'required',
            'meta_desc'   => 'required',
            'meta_title'   => 'required',
            'keywords'   => 'required',
            'activity'   => 'required',
            'contactinfo'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuary'));

        }else {
            try {

                if (isset($content['logo'])) {

                    // Get the record to delete the existing file
                    $getRow = \App\BirdSanctuary\birdSanctuary::where('id',$birdSanctuaryId)->get()->toArray();

                    // Upload Image
                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationFileName = time().".$ext";
                    $pathToSacveInDB = 'birdSanctuary-logo/'.$destinationFileName;

                    $pathToSacveInDB = $this->S3upload($request, 'logo', $pathToSacveInDB);
                    

                    if ($pathToSacveInDB) {
                        if (strpos($getRow[0]['logo'], 'birdSanctuary-logo') !== false) {
                            $fileExplode = explode("birdSanctuary-logo/", $getRow[0]['logo']);
                            \Storage::disk('s3')->delete("birdSanctuary-logo/".$fileExplode[1]);
                        }
                    }

                    $content['logo'] = $pathToSacveInDB;
                }

                // Upload the safari images
                if (count($content['birdSanctuaryImages'][0]) > 0) {
                    if($files=$request->file('birdSanctuaryImages')){
                        foreach($files as $index => $file){
                            $fileName = $file->getClientOriginalName() ;

                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            $birdSanctuaryIdFolder = 'BirdSanctuaryId-'.$birdSanctuaryId;
                            $destinationPath = public_path().'/assets/img/birdSanctuary/'. $birdSanctuaryIdFolder;
                            $destinationFileName = time().$index.".$ext";

                            $pathToSacveInDB = '/assets/img/birdSanctuary/'.$birdSanctuaryIdFolder.'/'.$destinationFileName;
                            $file->move($destinationPath,$destinationFileName);

                            $birdSanctuaryImageList['birdSanctuary_id'] = $birdSanctuaryId;
                            $birdSanctuaryImageList['name'] = $pathToSacveInDB;

                            $create  = \App\BirdSanctuary\birdSanctuaryImages::create($birdSanctuaryImageList);
                        }
                    }
                }
                unset($content['birdSanctuaryImages']);
                unset($content['_token']);
                unset($content['birdSanctuaryId']);

                $content['boat_types'] = json_encode($content['boat_types']);
                $content['vehicle_types'] = json_encode($content['vehicle_types']);
                $content['camera_types'] = json_encode($content['camera_types']);


                // echo "<pre>"; print_r($content);exit();

                $update  = \App\BirdSanctuary\birdSanctuary::where('id', $birdSanctuaryId)->update($content);

                Session::flash('message', 'Bird Sanctuary updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdSanctuary'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuary'));
            }
        }
    }

    public function deleteBirdSanctuary(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuary'));

        } else {
            try {
                $getRow = \App\BirdSanctuary\birdSanctuaryImages::where('birdSanctuary_id', $content['id'])->get()->toArray();
                $getBirdSanctuaryRow = \App\BirdSanctuary\birdSanctuary::where('id', $content['id'])->get()->toArray();

                $deleteBirdSanctuaryRow = \App\BirdSanctuary\birdSanctuary::where('id', $content['id'])->delete();
                $deleteBirdSanctuaryRowImages = \App\BirdSanctuary\birdSanctuaryImages::where('birdSanctuary_id', $content['id'])->delete();
                $deleteBirdSanctuaryPrice = \App\BirdSanctuary\birdSanctuaryPrice::where('birdSanctuary_id', $content['id'])->delete();
                $deleteBoatType = \App\BirdSanctuary\boatType::where('birdSanctuary_id', $content['id'])->delete();
                $deleteBoatTypePrice = \App\BirdSanctuary\boatTypePrice::where('birdSanctuary_id', $content['id'])->delete();
                $deletebirdSanctuaryTimeSlotsMapping  = \App\BirdSanctuary\birdSanctuaryTimeSlotsMapping::where('birdSanctuary_id', $content['id'])->delete();
                $deletebirdSanctuaryCameraFee  = \App\BirdSanctuary\cameraFee::where('birdSanctuary_id', $content['id'])->delete();
                $deletebirdSanctuaryCameraType  = \App\BirdSanctuary\cameraType::where('birdSanctuary_id', $content['id'])->delete();
                $deletebirdSanctuaryParkingFee  = \App\BirdSanctuary\parkingFee::where('birdSanctuary_id', $content['id'])->delete();
                $deletebirdSanctuaryParkingType  = \App\BirdSanctuary\parkingType::where('birdSanctuary_id', $content['id'])->delete();
                $deletebirdSanctuaryParkingVehicleType  = \App\BirdSanctuary\parkingVehicleType::where('birdSanctuary_id', $content['id'])->delete();

                //Delete from S3
                if(!empty($getRow)){
                    foreach ($getRow as $deleteRow) {
                        $filepath = public_path(). $deleteRow['name'];

                        if (strpos($deleteRow['name'], 'birdSanctuary') !== false) {
                            $fileExplode = explode("birdSanctuary/", $deleteRow['name']);
                            \Storage::disk('s3')->delete("birdSanctuary/".$fileExplode[1]);
                        }

                    }

                    // $parts = explode("/", $filepath);
                    // array_pop($parts);
                    // $folderpath = implode("/", $parts);
                    // $folderpath = $folderpath . '/';
                    // array_map('unlink', glob("$folderpath/*.*"));
                    // rmdir($folderpath);
                    // $filepath1 = \Config::get('common.myecotripHTML') . '/public' . $getBirdSanctuaryRow[0]['logo'];
                    // unlink($filepath1);
                }

                if(!empty($getBirdSanctuaryRow)){
                    if (strpos($getBirdSanctuaryRow[0]['logo'], 'birdSanctuary-logo') !== false) {
                        $fileExplode = explode("birdSanctuary-logo/", $getBirdSanctuaryRow[0]['logo']);
                        \Storage::disk('s3')->delete("birdSanctuary-logo/".$fileExplode[1]);
                    }
                }

                Session::flash('message', 'Bird Sanctuary deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdSanctuary'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuary'));
            }
        }
    }

    public function deleteBirdSanctuaryImages(Request $request)
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
            return \Redirect::to(url('admin/birdSanctuary'));

        }else {
            try {

                unset($content['_token']);
                $getRow = \App\BirdSanctuary\birdSanctuaryImages::where('id',$content['id'])->get()->toArray();

                $deletebirdSanctuaryImage  = \App\BirdSanctuary\birdSanctuaryImages::where('id', $content['id'])->delete();
                
                if(!empty($getRow)){
                    if (strpos($getRow[0]['name'], 'birdSanctuary') !== false) {
                        $fileExplode = explode("birdSanctuary/", $getRow[0]['name']);
                        \Storage::disk('s3')->delete("birdSanctuary/".$fileExplode[1]);
                    }
                }

                Session::flash('message', 'Bird Sanctuary Images deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdSanctuary'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuary'));
            }
        }
    }
}
