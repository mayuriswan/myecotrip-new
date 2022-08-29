<?php

namespace App\Http\Controllers\Admin\Safari;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;


class SafariController extends Controller
{
    public function getSafaries(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $safarilist = \App\Safari\Safari::all()->toArray();

            foreach ($safarilist as $index => $safarilistData){
                $getParkData = \App\Parks::where('id',$safarilistData['park_id'])->get()->toArray();

                $safarilist[$index]['parkname'] = $getParkData[0]['name'];
            }
            return view('Admin/safari/index', ['safariList'=> $safarilist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safari'));
        }
    }

    public function addSafaries(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $parklist = \App\Parks::all()->toArray();
            $transporttypes = \App\Transportation\TransportationTypes::all()->toArray();

            return view('Admin/safari/add', ['parkList'=> $parklist,'transporttypesList'=>$transporttypes]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safari'));
        }
    }

    public function createSafari(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();
        $content['transportation_id'] = implode($content['transportation_id'],',');

        $validator = \Validator::make($request->all(), [
            'display_order_no'   => 'required',
            'park_id'   => 'required',
            'name'   => 'required',
            'meta_title'   => 'required',
            'meta_desc'   => 'required',
            'keywords'   => 'required',
            'description'   => 'required',
            'includes'   => 'required',
            'excludes'   => 'required',
            'isActive'   => 'required',
            //'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safari'));

        }else {
            try {
                $safarilist = \App\Safari\Safari::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($safarilist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Safari is already existed!!";
                    Session::flash('message', 'Sorry this Safari is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/safari'));
                }
                else{

                    // Upload Image
                    $file = $request->file('logo') ;

                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/safari/';
                    $destinationFileName = time().".$ext";

                    $pathToSacveInDB = '/assets/img/safari/'.$destinationFileName;
                    $file->move($destinationPath,$destinationFileName);

                    $content['logo'] = $pathToSacveInDB;

                    $create  = \App\Safari\Safari::create($content);

                    $safariId = $create->id;

                    if ($content['safariImages']) {
                        if($files=$request->file('safariImages')){
                            foreach($files as $index => $file){
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                                $destinationPath = public_path().'/assets/img/safari/'. $safariId;
                                $destinationFileName = time().$index.".$ext";

                                $pathToSacveInDB = '/assets/img/safari/'.$safariId.'/'.$destinationFileName;
                                $file->move($destinationPath,$destinationFileName);

                                $safariImageList['safari_id'] = $safariId;
                                $safariImageList['name'] = $pathToSacveInDB;

                                $create  = \App\Safari\SafariImages::create($safariImageList);
                            }
                        }
                    }

                    Session::flash('message', 'Safari added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/safari'));
                }
            }catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safari'));
            }
        }
    }

    public function editSafari(Request $request)
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
            return \Redirect::to(url('admin/safari'));

        }else {
            try {
                $safariData = \App\Safari\Safari::where('id', [$content['id']])->get()->toArray();
                $safariData[0]['transportation_id'] = explode(',',$safariData[0]['transportation_id']);
                $safariData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                $parklist = \App\Parks::all()->toArray();
                $transporttypes = \App\Transportation\TransportationTypes::all()->toArray();
                $safariImages = \App\Safari\SafariImages::where('safari_id',$content['id'])->get()->toArray();

                return view('Admin/safari/edit',['safariData'=>$safariData[0],'parkList'=>$parklist,'transporttypesList'=>$transporttypes,'safariImages'=>$safariImages]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safari'));
            }
        }
    }

    public function updateSafari(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();
        $content['transportation_id'] = implode($content['transportation_id'],',');
        $safariId     = $content['safariId'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'display_order_no'   => 'required',
            'park_id'   => 'required',
            'name'   => 'required',
            'meta_title'   => 'required',
            'meta_desc'   => 'required',
            'keywords'   => 'required',
            'description'   => 'required',
            'includes'   => 'required',
            'excludes'   => 'required',
            'isActive'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safari'));

        }else {
            try {

                if (isset($content['logo'])) {

                    // Get the record to delete the existing file
                    $getRow = \App\Safari\Safari::where('id',$safariId)->get()->toArray();

                    // Upload Image
                    $file = $request->file('logo') ;

                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/safari/';
                    $destinationFileName = time().".$ext";

                    $pathToSacveInDB = '/assets/img/safari/'.$destinationFileName;
                    $copyFile = $file->move($destinationPath,$destinationFileName);

                    if ($copyFile) {
                        $filepath = public_path().$getRow[0]['logo'];
                        unlink($filepath);
                    }

                    $content['logo'] = $pathToSacveInDB;
                }

                // Upload the safari images
                if (count($content['safariImages'][0]) > 0) {
                    if($files=$request->file('safariImages')){
                        foreach($files as $index => $file){
                            $fileName = $file->getClientOriginalName() ;

                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            $destinationPath = public_path().'/assets/img/safari/'. $safariId;
                            $destinationFileName = time().$index.".$ext";

                            $pathToSacveInDB = '/assets/img/safari/'.$safariId.'/'.$destinationFileName;
                            $file->move($destinationPath,$destinationFileName);

                            $safariImageList['safari_id'] = $safariId;
                            $safariImageList['name'] = $pathToSacveInDB;

                            $create  = \App\Safari\SafariImages::create($safariImageList);
                        }
                    }
                }
                unset($content['safariImages']);
                unset($content['_token']);
                unset($content['safariId']);

                $update  = \App\Safari\Safari::where('id', $safariId)->update($content);

                Session::flash('message', 'Safari updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safari'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safari'));
            }
        }
    }


    public function deleteSafari(Request $request)
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
            return \Redirect::to(url('admin/safari'));

        }else {
            try {

                unset($content['_token']);
                unset($content['safariId']);

                $getRow = \App\Safari\SafariImages::where('safari_id',$content['id'])->get()->toArray();
                $getSafariRow = \App\Safari\Safari::where('id',$content['id'])->get()->toArray();

                $deletesafari  = \App\Safari\Safari::where('id', $content['id'])->delete();
                $deleteentryfee  = \App\Safari\SafariEntryFee::where('safari_id', $content['id'])->delete();
                $deletesafaritransp  = \App\Safari\SafariNumbers::where('safari_id', $content['id'])->delete();
                $deletesafaritranpprice  = \App\Safari\SafariTransportationPrice::where('safari_id', $content['id'])->delete();
                $deletesafarivehicledetails  = \App\Safari\SafariVehicle::where('safari_id', $content['id'])->delete();
                $deletesafarivImages  = \App\Safari\SafariImages::where('safari_id', $content['id'])->delete();

                foreach ($getRow as $deleteRow){
                    $filepath = public_path().$getRow['name'];
                }

                $parts = explode("/", $filepath);
                array_pop($parts);
                $folderpath = implode("/", $parts);
                $folderpath = $folderpath .'/';
                array_map('unlink', glob("$folderpath/*.*"));
                rmdir($folderpath);
                $filepath1 = public_path().$getSafariRow[0]['logo'];
                unlink($filepath1);

                Session::flash('message', 'Safari deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safari'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safari'));
            }
        }
    }

    public function deleteSafariImages(Request $request)
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
            return \Redirect::to(url('admin/safari'));

        }else {
            try {

                unset($content['_token']);
                $getRow = \App\Safari\SafariImages::where('id',$content['id'])->get()->toArray();

                $deletesafari  = \App\Safari\SafariImages::where('id', $getRow[0]['id'])->delete();

                $filepath = public_path().$getRow[0]['name'];
                unlink($filepath);

                Session::flash('message', 'Safari Images deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/safari'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/safari'));
            }
        }
    }

}
