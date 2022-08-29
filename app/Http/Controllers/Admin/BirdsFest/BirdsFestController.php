<?php

namespace App\Http\Controllers\Admin\BirdsFest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class BirdsFestController extends Controller
{
    public function getBirdsFest(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $birdsFestList = \App\BirdsFest\birdsFestDetails::all()->toArray();

            foreach ($birdsFestList as $index => $birdsFestListData){
                $getEventData = \App\Events\EventType::where('id',$birdsFestListData['event_id'])->get()->toArray();


                $birdsFestList[$index]['eventName'] = $getEventData[0]['name'];
            }
            return view('Admin/birdsFest/index', ['birdsFestList'=> $birdsFestList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdsFest'));
        }
    }

    public function addBirdsFest(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $eventlist = \App\Events\EventType::all()->toArray();

            return view('Admin/birdsFest/add', ['eventlist'=> $eventlist]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdsFest'));
        }
    }

    public function createBirdsFest(Request $request)
    {
        // ini_set('memory_limit','16M');
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        // echo "<pre>"; print_r($_FILES);exit();
        $validator = \Validator::make($request->all(), [
            'event_id'   => 'required',
            'name'   => 'required',
            'description'   => 'required',
            'isActive'   => 'required',
            //'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdsFest'));

        }else {
            try {
                $birdsFestlist = \App\BirdsFest\birdsFestDetails::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($birdsFestlist) > 0)
                {
                    $failure['response']['message'] = "Sorry this Birds Fest is already existed!!";
                    Session::flash('message', 'Sorry this Birds Fest is already existed!!');
                    Session::flash('alert-class', 'alert-danger');

                    return \Redirect::to(url('admin/birdsFest'));
                }
                else{

                    // Upload Image
                    // $file = $request->file('logo') ;
                    // $fileName = $file->getClientOriginalName() ;
                    // $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                    // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/birdsFest/';
                    // $destinationFileName = time().".$ext";
                    // $pathToSacveInDB = '/assets/img/birdsFest/'.$destinationFileName;
                    // $file->move($destinationPath,$destinationFileName);

                    $content['s3_upload'] = 1;
                    
                    $create  = \App\BirdsFest\birdsFestDetails::create($content);

                    $birdsFestId = $create->id;

                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    //Upload to S3
                    $destinationFileName = time()."_logo.$ext";
                    $filePath = "eventImages/$birdsFestId/$destinationFileName";

                    $s3 = \Storage::disk('s3');
                    $s3->put($filePath, file_get_contents($file), 'public');
                    $s3Url = \Storage::disk('s3')->url($filePath);

                    $update['logo'] = $s3Url;

                    $create  = \App\BirdsFest\birdsFestDetails::where('id', $birdsFestId)->update($update);
                    

                    if ($content['birdsFestImages']) {
                        if($files=$request->file('birdsFestImages')){
                            foreach($files as $index => $file){
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                                // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/birdsFest/'. $birdsFestId;
                                // $destinationFileName = time().$index.".$ext";

                                // $pathToSacveInDB = '/assets/img/birdsFest/'.$birdsFestId.'/'.$destinationFileName;
                                // $file->move($destinationPath,$destinationFileName);

                                // $birdsFestlist['birdsFest_id'] = $birdsFestId;
                                // $birdsFestlist['name'] = $pathToSacveInDB;

                                //Upload to S3
                                $destinationFileName = time()."$index.$ext";

                                $filePath = "eventImages/$birdsFestId/$destinationFileName";

                                $s3 = \Storage::disk('s3');
                                $s3->put($filePath, file_get_contents($file), 'public');
                                $s3Url = \Storage::disk('s3')->url($filePath);

                                $birdsFestlist['birdsFest_id'] = $birdsFestId;
                                
                                $birdsFestlist['s3_upload'] = 1;
                                $birdsFestlist['name'] = $s3Url;


                                $create  = \App\BirdsFest\birdsFestImages::create($birdsFestlist);
                            }
                        }
                    }


                    if (isset($content['speakersImages'])) {
                        if($files=$request->file('speakersImages')){
                            foreach($files as $index => $file){

                                if (!count($file)) {
                                   continue;
                                }
                                
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                                // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/birdsFest/'. $birdsFestId;
                                // $destinationFileName = time().$index.".$ext";

                                // $pathToSacveInDB = '/assets/img/birdsFest/'.$birdsFestId.'/'.$destinationFileName;
                                // $file->move($destinationPath,$destinationFileName);

                                // $birdsFestlist['birdsFest_id'] = $birdsFestId;
                                // $birdsFestlist['name'] = $pathToSacveInDB;

                                //Upload to S3
                                $destinationFileName = time()."$index.$ext";

                                $filePath = "eventImages/$birdsFestId/$destinationFileName";

                                $s3 = \Storage::disk('s3');
                                $s3->put($filePath, file_get_contents($file), 'public');
                                $s3Url = \Storage::disk('s3')->url($filePath);

                                $birdsFestlist['birdsFest_id'] = $birdsFestId;
                                
                                $birdsFestlist['s3_upload'] = 1;
                                $birdsFestlist['name'] = $s3Url;
                                $birdsFestlist['image_type'] = 1;


                                $create  = \App\BirdsFest\birdsFestImages::create($birdsFestlist);
                            }
                        }
                    }

                    Session::flash('message', 'Birds Fest added successfully');
                    Session::flash('alert-class', 'alert-success');

                    return \Redirect::to(url('admin/birdsFest'));
                }
            }catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdsFest'));
            }
        }
    }

    public function editBirdsFest(Request $request)
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
            return \Redirect::to(url('admin/birdsFest'));

        }else {
            try {
                $birdsFestData = \App\BirdsFest\birdsFestDetails::where('id', [$content['id']])->get()->toArray();
                $birdsFestData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                $eventlist = \App\Events\EventType::all()->toArray();
                $birdsFestDataImages = \App\BirdsFest\birdsFestImages::where('birdsFest_id',$content['id'])->get()->toArray();

                // echo "<pre>"; print_r($birdsFestData);exit();
                return view('Admin/birdsFest/edit',['birdsFestData'=>$birdsFestData[0],'eventlist'=>$eventlist,'birdsFestDataImages'=>$birdsFestDataImages]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdsFest'));
            }
        }
    }

    public function updateBirdsFest(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        // echo "<pre>"; print_r($content);exit();
        $birdsFestId     = $content['birdsFestId'];
        unset($content['dataTables-example_length']);
        $validator = \Validator::make($request->all(), [
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
            return \Redirect::to(url('admin/birdsFest'));

        }else {
            try {

                if (isset($content['logo'])) {

                    //S3 upload
                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    //Upload to S3
                    $destinationFileName = time()."_logo.$ext";
                    $filePath = "eventImages/$birdsFestId/$destinationFileName";

                    $s3 = \Storage::disk('s3');
                    $s3->put($filePath, file_get_contents($file), 'public');
                    $s3Url = \Storage::disk('s3')->url($filePath);

                    $content['logo'] = $s3Url;


                    // Get the record to delete the existing file
                    $getRow = \App\BirdsFest\birdsFestDetails::where('id',$birdsFestId)->get()->toArray();

                    //Delete the old record
                    $getFileName = explode('eventImages', $getRow[0]['logo']);

                    \Storage::disk('s3')->delete('/eventImages' . $getFileName[1]);


                    
                    // // Upload Image
                    // $file = $request->file('logo') ;

                    // $fileName = $file->getClientOriginalName() ;

                    // $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/birdsFest/';
                    // $destinationFileName = time().".$ext";

                    // $pathToSacveInDB = '/assets/img/birdsFest/'.$destinationFileName;
                    // $copyFile = $file->move($destinationPath,$destinationFileName);

                    // if ($copyFile) {
                    //     $filepath = \Config::get('common.myecotripHTML').'/public'.$getRow[0]['logo'];
                    //     unlink($filepath);
                    // }

                    // $content['logo'] = $pathToSacveInDB;
                }

                // Upload the birdsFest images

                if (isset($content['birdsFestImages']) && count($content['birdsFestImages'])) {
                    if($files=$request->file('birdsFestImages')){
                        foreach($files as $index => $file){

                            if (!count($file)) {
                               continue;
                            }

                            $fileName = $file->getClientOriginalName() ;

                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            //Upload to S3
                            $destinationFileName = time()."$index.$ext";

                            $filePath = "eventImages/$birdsFestId/$destinationFileName";

                            $s3 = \Storage::disk('s3');
                            $s3->put($filePath, file_get_contents($file), 'public');
                            $s3Url = \Storage::disk('s3')->url($filePath);

                            $birdsFestlist['birdsFest_id'] = $birdsFestId;
                            
                            $birdsFestlist['s3_upload'] = 1;
                            $birdsFestlist['name'] = $s3Url;


                            $create  = \App\BirdsFest\birdsFestImages::create($birdsFestlist);
                        }
                    }
                }

                if (isset($content['speakersImages']) && count($content['speakersImages'])) {
                    if($files=$request->file('speakersImages')){
                        foreach($files as $index => $file){

                            if (!count($file)) {
                               continue;
                            }

                            $fileName = $file->getClientOriginalName() ;

                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            //Upload to S3
                            $destinationFileName = time()."$index.$ext";

                            $filePath = "eventImages/$birdsFestId/$destinationFileName";

                            $s3 = \Storage::disk('s3');
                            $s3->put($filePath, file_get_contents($file), 'public');
                            $s3Url = \Storage::disk('s3')->url($filePath);

                            $birdsFestlist['birdsFest_id'] = $birdsFestId;
                            
                            $birdsFestlist['s3_upload'] = 1;
                            $birdsFestlist['name'] = $s3Url;
                            $birdsFestlist['image_type'] = 1;

                            $create  = \App\BirdsFest\birdsFestImages::create($birdsFestlist);
                        }
                    }
                }

                unset($content['birdsFestImages']);
                unset($content['speakersImages']);
                unset($content['_token']);
                unset($content['birdsFestId']);

                $update  = \App\BirdsFest\birdsFestDetails::where('id', $birdsFestId)->update($content);

                Session::flash('message', 'Birds Fest updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdsFest'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdsFest'));
            }
        }
    }

    public function deleteBirdsFest(Request $request)
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
            return \Redirect::to(url('admin/birdsFest'));

        } else {
            try {
                $getRow = \App\BirdsFest\birdsFestImages::where('birdsFest_id', $content['id'])->get()->toArray();
                $getBirdsFestRow = \App\BirdsFest\birdsFestDetails::where('id', $content['id'])->get()->toArray();

                $deleteBirdsFestRow = \App\BirdsFest\birdsFestDetails::where('id', $content['id'])->delete();
                $deleteBirdsFestRowImages = \App\BirdsFest\birdsFestImages::where('birdsFest_id', $content['id'])->delete();
                $deleteBirdFestPricings = \App\BirdsFest\birdFestPricings::where('event_id', $content['id'])->delete();

                if(!empty($getRow)){
                    foreach ($getRow as $deleteRow) {
                        $filepath = public_path() . $deleteRow['name'];
                    }

                    $parts = explode("/", $filepath);
                    array_pop($parts);
                    $folderpath = implode("/", $parts);
                    $folderpath = $folderpath . '/';
                    array_map('unlink', glob("$folderpath/*.*"));
                    rmdir($folderpath);
                    $filepath1 = public_path() . $getBirdsFestRow[0]['logo'];
                    unlink($filepath1);
                }

                Session::flash('message', 'Deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdsFest'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdsFest'));
            }
        }
    }

    public function deleteBirdsFestImages(Request $request)
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
            return \Redirect::to(url('admin/birdsFest'));

        }else {
            try {

                unset($content['_token']);
                $getRow = \App\BirdsFest\birdsFestImages::where('id',$content['id'])->get()->toArray();

                $deletebirdsFestImage  = \App\BirdsFest\birdsFestImages::where('id', $content['id'])->delete();
                
                if(!empty($getRow)){
                    if (!$getRow[0]['s3_upload']) {
                        $filepath = public_path().$getRow[0]['name'];
                        unlink($filepath);
                    }else{
                        $getFileName = explode('eventImages', $getRow[0]['name']);

                        \Storage::disk('s3')->delete('/eventImages' . $getFileName[1]);
                    }
                }

                Session::flash('message', 'Birds Fest Images deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/birdsFest'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdsFest'));
            }
        }
    }
}
