<?php

namespace App\Http\Controllers\Admin\JungleStay;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class JungleStayController extends Controller
{
    public function getJungleStay(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $junglestaylist = \App\JungleStay\jungleStay::all()->toArray();

            foreach ($junglestaylist as $index => $junglestaylistData){
                $getParkData = \App\JungleStay\JungleStayLandscape::where('id',$junglestaylistData['landscape_id'])->get()->toArray();

                $junglestaylist[$index]['parkname'] = $getParkData[0]['name'];
            }
            return view('Admin/jungleStay/index', ['jungleStayList'=> $junglestaylist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStay'));
        }
    }

    public function addJungleStay(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $junglestaylist = \App\JungleStay\JungleStayLandscape::all()->toArray();

            return view('Admin/jungleStay/add', ['parkList'=> $junglestaylist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStay'));
        }
    }

    public function createJungleStay(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'landscape_id'   => 'required',
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
            return \Redirect::to(url('admin/jungleStay'));

        }else {
            try {
                $jungleStaylist = \App\JungleStay\jungleStay::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($jungleStaylist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Jungle Stay is already existed!!";
                    Session::flash('message', 'Sorry this Jungle Stay is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/jungleStay'));
                }
                else{

                    // Upload Image
                    $file = $request->file('logo') ;

                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/jungleStay/';
                    $destinationFileName = time().".$ext";

                    $pathToSacveInDB = '/assets/img/jungleStay/'.$destinationFileName;
                    $file->move($destinationPath,$destinationFileName);

                    $content['logo'] = $pathToSacveInDB;

                    $create  = \App\JungleStay\jungleStay::create($content);

                    $jungleStayId = $create->id;

                    if ($content['jungleStayImages']) {
                        if($files=$request->file('jungleStayImages')){
                            foreach($files as $index => $file){
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                                $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/jungleStay/'. $jungleStayId;
                                $destinationFileName = time().$index.".$ext";

                                $pathToSacveInDB = '/assets/img/jungleStay/'.$jungleStayId.'/'.$destinationFileName;
                                $file->move($destinationPath,$destinationFileName);

                                $jungleStayList['jungleStay_id'] = $jungleStayId;
                                $jungleStayList['name'] = $pathToSacveInDB;

                                $create  = \App\JungleStay\jungleStayImages::create($jungleStayList);
                            }
                        }
                    }

                    Session::flash('message', 'Jungle Stay added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/jungleStay'));
                }
            }catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStay'));
            }
        }
    }

    public function editJungleStay(Request $request)
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
            return \Redirect::to(url('admin/jungleStay'));

        }else {
            try {
                $jungleStayData = \App\JungleStay\jungleStay::where('id', [$content['id']])->get()->toArray();
                $jungleStayData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                $parklist = \App\JungleStay\JungleStayLandscape::all()->toArray();
                $jungleStayDataImages = \App\JungleStay\jungleStayImages::where('jungleStay_id',$content['id'])->get()->toArray();

                return view('Admin/jungleStay/edit',['jungleStayData'=>$jungleStayData[0],'parkList'=>$parklist,'jungleStayDataImages'=>$jungleStayDataImages]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStay'));
            }
        }
    }

    public function updateJungleStay(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $jungleStayId     = $content['jungleStayId'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'landscape_id'   => 'required',
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
            return \Redirect::to(url('admin/jungleStay'));

        }else {
            try {

                if (isset($content['logo'])) {

                    // Get the record to delete the existing file
                    $getRow = \App\JungleStay\jungleStay::where('id',$jungleStayId)->get()->toArray();

                    // Upload Image
                    $file = $request->file('logo') ;

                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/jungleStay/';
                    $destinationFileName = time().".$ext";

                    $pathToSacveInDB = '/assets/img/jungleStay/'.$destinationFileName;
                    $copyFile = $file->move($destinationPath,$destinationFileName);

                    if ($copyFile) {
                        $filepath = \Config::get('common.myecotripHTML').'/public'.$getRow[0]['logo'];
                        unlink($filepath);
                    }

                    $content['logo'] = $pathToSacveInDB;
                }

                // Upload the safari images
                if (count($content['jungleStayImages'][0]) > 0) {
                    if($files=$request->file('jungleStayImages')){
                        foreach($files as $index => $file){
                            $fileName = $file->getClientOriginalName() ;

                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/jungleStay/'. $jungleStayId;
                            $destinationFileName = time().$index.".$ext";

                            $pathToSacveInDB = '/assets/img/jungleStay/'.$jungleStayId.'/'.$destinationFileName;
                            $file->move($destinationPath,$destinationFileName);

                            $jungleStayImageList['jungleStay_id'] = $jungleStayId;
                            $jungleStayImageList['name'] = $pathToSacveInDB;

                            $create  = \App\JungleStay\jungleStayImages::create($jungleStayImageList);
                        }
                    }
                }
                unset($content['jungleStayImages']);
                unset($content['_token']);
                unset($content['jungleStayId']);

                $update  = \App\JungleStay\jungleStay::where('id', $jungleStayId)->update($content);

                Session::flash('message', 'Jungle Stay updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStay'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStay'));
            }
        }
    }

    public function deleteJungleStay(Request $request)
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
            return \Redirect::to(url('admin/jungleStay'));

        } else {
            try {
                $getRow = \App\JungleStay\jungleStayImages::where('jungleStay_id', $content['id'])->get()->toArray();
                $getJungleStayRow = \App\JungleStay\jungleStay::where('id', $content['id'])->get()->toArray();
                $getJungleStayRoomsRow = \App\JungleStay\jungleStayRooms::where('jungleStay_id', $content['id'])->get()->toArray();

                $deleteJungleStayRow = \App\JungleStay\jungleStay::where('id', $content['id'])->delete();
                $deleteJungleStayRowImages = \App\JungleStay\jungleStayImages::where('jungleStay_id', $content['id'])->delete();
                $deleteJungleStayRooms = \App\JungleStay\jungleStayRooms::where('jungleStay_id', $content['id'])->delete();
                $deleteJungleStayRoomsImages = \App\JungleStay\jungleStayRoomsImages::where('jungleStay_id', $content['id'])->delete();
                $deleteJungleStayRoomsPrice = \App\JungleStay\jungleStayRoomsPrice::where('jungleStay_id', $content['id'])->delete();
                
                if(!empty($getRow)){

                    foreach ($getJungleStayRoomsRow as $deleteJungleStayRoomsRow) {
                        $roomsfilepath = \Config::get('common.myecotripHTML') . '/public/assets/img/jungleStay/'.$content['id'].'/'. $deleteJungleStayRoomsRow['id'];
                        $parts = explode("/", $roomsfilepath);
                        $roomsfolderpath = implode("/", $parts);
                        $roomsfolderpath = $roomsfolderpath . '/';
                        array_map('unlink', glob("$roomsfolderpath/*.*"));
                        rmdir($roomsfolderpath);
                    }

                    foreach ($getRow as $deleteRow) {
                        $filepath = \Config::get('common.myecotripHTML') . '/public' . $deleteRow['name'];
                    }

                    $parts = explode("/", $filepath);
                    array_pop($parts);
                    $folderpath = implode("/", $parts);
                    $folderpath = $folderpath . '/';
                    array_map('unlink', glob("$folderpath/*.*"));
                    rmdir($folderpath);
                    
                    $filepath1 = \Config::get('common.myecotripHTML') . '/public' . $getJungleStayRow[0]['logo'];
                    unlink($filepath1);
                }

                Session::flash('message', 'Jungle Stay deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStay'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStay'));
            }
        }
    }

    public function deleteJungleStayImages(Request $request)
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
            return \Redirect::to(url('admin/jungleStay'));

        }else {
            try {

                unset($content['_token']);
                $getRow = \App\JungleStay\jungleStayImages::where('id',$content['id'])->get()->toArray();

                $deletejungleStayImage  = \App\JungleStay\jungleStayImages::where('id', $content['id'])->delete();

                if(!empty($getRow)){
                    $filepath = \Config::get('common.myecotripHTML').'/public'.$getRow[0]['name'];
                    unlink($filepath);
                }

                Session::flash('message', 'Jungle Stay Images deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStay'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStay'));
            }
        }
    }
}
