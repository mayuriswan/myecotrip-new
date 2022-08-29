<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;


class BannerController extends Controller
{
    public function getBannerImages(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $bannerImagesList = \App\BannerImages::all()->toArray();

            return view('Admin/bannerImages/index', ['bannerImagesList'=> $bannerImagesList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/bannerImages'));
        }
    }

    public function addBannerImages(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            return view('Admin/bannerImages/add');
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/bannerImages'));
        }
    }

    public function createBannerImages(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'type'   => 'required',
            'path'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/bannerImages'));

        }else {
            try {
                $bannerImageList = \App\BannerImages::whereRaw('LOWER(path) = ?', [$content['path']])->get()->toArray();

                if(count($bannerImageList) > 0)
                {
                    $failure['response']['message'] = "Sorry this is already existed!!";
                    Session::flash('message', 'Sorry this is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/bannerImages'));
                }else{

                    // Upload Image
                    $file = $request->file('path') ;

                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/banners/';
                    $destinationFileName = time().".$ext";

                    $pathToSacveInDB = '/assets/img/banners/'.$destinationFileName;
                    $file->move($destinationPath,$destinationFileName);

                    $content['path'] = $pathToSacveInDB;

                    $create  = \App\BannerImages::create($content);

                    $safariId = $create->id;

                    Session::flash('message', 'Banner added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/bannerImages'));
                }
            }catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/bannerImages'));
            }
        }
    }

    public function editBannerImages(Request $request)
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
            return \Redirect::to(url('admin/bannerImages'));

        }else {
            try {
                $bannerImageData = \App\BannerImages::where('id', [$content['id']])->get()->toArray();
                $bannerImageData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
               
                return view('Admin/bannerImages/edit',['bannerImageData'=>$bannerImageData[0]]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/bannerImages'));
            }
        }
    }

    public function updateBannerImages(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();
        
        $bannerImageId     = $content['id'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
            'type'   => 'required',
            'href'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/bannerImages'));

        }else {
            try {

                if (isset($content['path'])) {

                    // Get the record to delete the existing file
                    $getRow = \App\BannerImages::where('id',$bannerImageId)->get()->toArray();

                    // Upload Image
                    $file = $request->file('path') ;

                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/banners/';
                    $destinationFileName = time().".$ext";

                    $pathToSacveInDB = '/assets/img/banners/'.$destinationFileName;
                    $copyFile = $file->move($destinationPath,$destinationFileName);

                    if ($copyFile) {
                        $filepath = public_path().$getRow[0]['path'];
                        unlink($filepath);
                    }

                    $content['path'] = $pathToSacveInDB;
                }

                unset($content['_token']);
                unset($content['id']);

                $update  = \App\BannerImages::where('id', $bannerImageId)->update($content);

                Session::flash('message', 'Banner updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/bannerImages'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/bannerImages'));
            }
        }
    }


    public function deleteBannerImages(Request $request)
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
            return \Redirect::to(url('admin/bannerImages'));

        }else {
            try {

                $getRow = \App\BannerImages::where('id', $content['id'])->get()->toArray();
                $delete  = \App\BannerImages::where('id', $content['id'])->delete();
                
                if(!empty($getRow)){
                    foreach ($getRow as $deleteRow){
                        $filepath = public_path().$getRow[0]['path'];
                    }    
                    unlink($filepath);
                }
                                

                Session::flash('message', 'Banner deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/bannerImages'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/bannerImages'));
            }
        }
    }

}
