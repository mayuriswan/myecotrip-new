<?php

namespace App\Http\Controllers\Admin\JungleStay;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class JungleStayRoomsController extends Controller
{
    public function getJungleStayRooms(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $junglestayroomslist = \App\JungleStay\jungleStayRooms::all()->toArray();

            foreach ($junglestayroomslist as $index => $junglestayroomslistData){
                $getJungleStayData = \App\JungleStay\jungleStay::where('id',$junglestayroomslistData['jungleStay_id'])->get()->toArray();

                $junglestayroomslist[$index]['jungleStayName'] = $getJungleStayData[0]['name'];
            }
            return view('Admin/jungleStay/jungleStayRooms/index', ['jungleStayRoomsList'=> $junglestayroomslist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRooms'));
        }
    }

    public function addJungleStayRooms(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $jungleStaylist = \App\JungleStay\jungleStay::all()->toArray();

            return view('Admin/jungleStay/jungleStayRooms/add', ['jungleStaylist'=> $jungleStaylist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRooms'));
        }
    }

    public function createJungleStayRooms(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'jungleStay_id'   => 'required',
            'type'   => 'required',
            'description'   => 'required',
            'remarks'   => 'required',
            'minimum_stay'   => 'required',
            'no_of_rooms'   => 'required',
            'inclusive'   => 'required',
            'exclusive'   => 'required',
            'checkin'   => 'required',
            'checkout'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRooms'));

        }else {
            try {
                $jungleStayRoomslist = \App\JungleStay\jungleStayRooms::whereRaw('LOWER(type) = ?', [$content['type']])->get()->toArray();

                if(count($jungleStayRoomslist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Jungle Stay Room is already existed!!";
                    Session::flash('message', 'Sorry this Jungle Stay Room is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/jungleStayRooms'));
                }
                else{
                    $create  = \App\JungleStay\jungleStayRooms::create($content);

                    $jungleStayId = $create->jungleStay_id;
                    $jungleStayRoomsId = $create->id;

                    // Upload Image
                        if ($content['jungleStayRoomsImages']) {
                        if($files=$request->file('jungleStayRoomsImages')){
                            foreach($files as $index => $file){
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                                $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/jungleStay/'.$jungleStayId.'/'.$jungleStayRoomsId.'/';
                                $destinationFileName = time().$index.".$ext";

                                $pathToSacveInDB = '/assets/img/jungleStay/'.$jungleStayId.'/'.$jungleStayRoomsId.'/'.$destinationFileName;
                                $file->move($destinationPath,$destinationFileName);

                                $jungleStayRoomsList['jungleStay_id'] = $jungleStayId;
                                $jungleStayRoomsList['jungleStayRooms_id'] = $jungleStayRoomsId;
                                $jungleStayRoomsList['name'] = $pathToSacveInDB;

                                $create  = \App\JungleStay\jungleStayRoomsImages::create($jungleStayRoomsList);
                            }
                        }
                    }

                    Session::flash('message', 'Jungle Stay Room added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/jungleStayRooms'));
                }
            }catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRooms'));
            }
        }
    }

    public function editJungleStayRooms(Request $request)
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
            return \Redirect::to(url('admin/jungleStayRooms'));

        }else {
            try {
                $jungleStayRoomsData = \App\JungleStay\jungleStayRooms::where('id', [$content['id']])->get()->toArray();
                $jungleStayRoomsData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                $jungleStaylist = \App\JungleStay\jungleStay::all()->toArray();
                $jungleStayRoomsDataImages = \App\JungleStay\jungleStayRoomsImages::where('jungleStayRooms_id',$content['id'])->get()->toArray();

                return view('Admin/jungleStay/jungleStayRooms/edit',['jungleStayRoomsData'=>$jungleStayRoomsData[0],'jungleStayList'=>$jungleStaylist,'jungleStayRoomsDataImages'=>$jungleStayRoomsDataImages]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRooms'));
            }
        }
    }

    public function updateJungleStayRooms(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $jungleStayRoomId     = $content['jungleStayRoomId'];
        $jungleStayId     = $content['jungleStay_id'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'jungleStay_id'   => 'required',
            'type'   => 'required',
            'description'   => 'required',
            'remarks'   => 'required',
            'minimum_stay'   => 'required',
            'no_of_rooms'   => 'required',
            'inclusive'   => 'required',
            'exclusive'   => 'required',
            'checkin'   => 'required',
            'checkout'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRooms'));

        }else {
            try {
                // Upload the safari images
                if (count($content['jungleStayRoomsImages'][0]) > 0) {
                    if($files=$request->file('jungleStayRoomsImages')){
                        foreach($files as $index => $file){
                            $fileName = $file->getClientOriginalName() ;

                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/jungleStay/'.$jungleStayId.'/';
                            $destinationFileName = time().$index.".$ext";

                            $pathToSacveInDB = '/assets/img/jungleStay/'.$jungleStayId.'/'.$jungleStayRoomsId.'/'.$destinationFileName;
                            $file->move($destinationPath,$destinationFileName);

                            $jungleStayRoomsList['jungleStay_id'] = $jungleStayId;
                            $jungleStayImageList['jungleStayRooms_id'] = $jungleStayRoomId;
                            $jungleStayImageList['name'] = $pathToSacveInDB;

                            $create  = \App\JungleStay\jungleStayRoomsImages::create($jungleStayImageList);
                        }
                    }
                }
                unset($content['jungleStayRoomsImages']);
                unset($content['_token']);
                unset($content['jungleStay_id']);
                unset($content['jungleStayRoomId']);

                $update  = \App\JungleStay\jungleStayRooms::where('id', $jungleStayRoomId)->update($content);

                Session::flash('message', 'Jungle Stay Room updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStayRooms'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRooms'));
            }
        }
    }

    public function deleteJungleStayRooms(Request $request)
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
            return \Redirect::to(url('admin/jungleStayRooms'));

        } else {
            try {
                $getRow = \App\JungleStay\jungleStayRoomsImages::where('jungleStayRooms_id', $content['id'])->get()->toArray();
                $getJungleStayRoomsRow = \App\JungleStay\jungleStayRooms::where('id', $content['id'])->get()->toArray();

                $deleteJungleStayRoomsRow = \App\JungleStay\jungleStayRooms::where('id', $content['id'])->delete();
                $deleteJungleStayRoomsRowImages = \App\JungleStay\jungleStayRoomsImages::where('jungleStayRooms_id', $content['id'])->delete();
                $deleteJungleStayRoomsPrice = \App\JungleStay\jungleStayRoomsPrice::where('jungleStayRooms_id', $content['id'])->delete();

                if(!empty($getRow)){
                    foreach ($getRow as $deleteRow) {
                        $filepath = \Config::get('common.myecotripHTML') . '/public' . $deleteRow['name'];
                    }
                    $parts = explode("/", $filepath);
                    array_pop($parts);
                    $folderpath = implode("/", $parts);
                    $folderpath = $folderpath . '/';
                    array_map('unlink', glob("$folderpath/*.*"));
                    rmdir($folderpath);
                }

                Session::flash('message', 'Jungle Stay Room deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStayRooms'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRooms'));
            }
        }
    }

    public function deleteJungleStayRoomsImages(Request $request)
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
            return \Redirect::to(url('admin/jungleStayRooms'));

        }else {
            try {
                $getRow = \App\JungleStay\jungleStayRoomsImages::where('id',$content['id'])->get()->toArray();

                $deletejungleStayRoomsImages  = \App\JungleStay\jungleStayRoomsImages::where('id', $content['id'])->delete();

                if(!empty($getRow)) {
                    $filepath = \Config::get('common.myecotripHTML') . '/public' . $getRow[0]['name'];
                    unlink($filepath);
                }

                Session::flash('message', 'Jungle Stay Rooms Images deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStayRooms'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRooms'));
            }
        }
    }
}
