<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\JungleStay;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Session;

class JungleStayController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     public function index(Request $request)
     {
         try {
             //Get the list of stays
             $getRows =  \App\JungleStay\Stay::orderBy('id','DESC')->get()->toArray();

             // echo "<pre>"; print_r($getRows);exit();
             return view('cms::superAdmin.JungleStay.index', ['data' => $getRows]);

         } catch (\Exception $e) {
             // echo "$e";exit;
             \Session::flash('alert-danger', 'Sorry Could not process');
             $data =  $request->session()->get('_previous');
             return \Redirect::to($data['url']);
         }

     }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        try {
            //Get the list of stays
            $data['parkType'] =  \App\ParkType::where('status', 1)->select('id','name')->get()->toArray();
            $data['trailList'] =  \App\Trail::where('status', 1)->select('id','name')->get()->toArray();
            $data['roomTypes'] =  \App\JungleStay\RoomType::where('status', 1)->select('id','name','description')->get()->toArray();
            // $data['safariList'] =  App\Safari\Safari::where('status', 1)->get()->toArray();

            // echo "<pre>"; print_r($data);exit();
            return view('cms::superAdmin.JungleStay.create', ['data' => $data]);

        } catch (\Exception $e) {
            // echo "$e";exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try{
            $success = \Config::get('common.create_success_response');
            $failure = \Config::get('common.create_failure_response');

            $content      = $request->except(['_token','logo','otherImages']);
            $content['room_types'] = json_encode($content['room_types']);

            if (isset($content['trails'])) {
                $content['trails'] = json_encode($content['trails']);
            }

            $validator = \Validator::make($request->all(), [
            	'name' => 'required',
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                \Session::flash('alert-danger', 'Invalid params');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            $create  = \App\JungleStay\Stay::create($content);

            $jsId = $create->id;

            // Upload Image
            $file = $request->file('logo') ;
            $fileName = $file->getClientOriginalName() ;
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            //Upload to S3
            $destinationFileName = time()."_logo.$ext";
            $filePath = "jsImages/$jsId/$destinationFileName";

            $s3 = \Storage::disk('s3');
            $s3->put($filePath, file_get_contents($file), 'public');
            $s3Url = \Storage::disk('s3')->url($filePath);

            $update['logo'] = $s3Url;

            $update  = \App\JungleStay\Stay::where('id', $jsId)->update($update);

            // Upload the other images
            if ($request->file('otherImages')) {
                if($files=$request->file('otherImages')){
                    foreach($files as $index => $file){
                        $fileName = $file->getClientOriginalName() ;

                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                        // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/'. $jsId;
                        // $destinationFileName = time().$index.".$ext";

                        // $pathToSacveInDB = '/assets/img/trails/'.$jsId.'/'.$destinationFileName;
                        // $file->move($destinationPath,$destinationFileName);

                        //Upload to S3
                        $destinationFileName = time()."$index.$ext";

                        $filePath = "jsImages/$jsId/$destinationFileName";

                        $s3 = \Storage::disk('s3');
                        $s3->put($filePath, file_get_contents($file), 'public');
                        $s3Url = \Storage::disk('s3')->url($filePath);

                        $trekImageList['js_id'] = $jsId;
                        $trekImageList['s3_upload'] = 1;
                        $trekImageList['name'] = $s3Url;

                        $create  = \App\JungleStay\Images::create($trekImageList);
                    }
                }
            }

            \Session::flash('alert-success', 'Added successfully');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }catch(\Exception $e ){
            echo "$e";exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            // Get the ciecles details
            $jsData = \App\JungleStay\Stay::where('id', $id)->get()->toArray()[0];

            //Get the list of static data
            $data['parkType'] =  \App\ParkType::where('status', 1)->select('id','name')->get()->toArray();
            $data['trailList'] =  \App\Trail::where('status', 1)->select('id','name')->get()->toArray();
            $data['roomTypes'] =  \App\JungleStay\RoomType::where('status', 1)->select('id','name','description')->get()->toArray();
            // $data['safariList'] =  App\Safari\Safari::where('status', 1)->get()->toArray();

            // echo "<pre>";print_r($jsData);exit();


            if(count($jsData) > 0){
                // $jsData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');

                $jsData['images'] = \App\JungleStay\Images::where('js_id',$id)->get()->toArray();
                $jsData['room_types'] = json_decode($jsData['room_types']);
                $jsData['trails'] = json_decode($jsData['trails']);

                // echo "<pre>";print_r($jsData);exit();
                return view('cms::superAdmin.JungleStay.edit', ['data' => $data, 'jsData' => $jsData]);
            }else{
                \Session::flash('alert-danger', 'Sorry Could not process');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('cms::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $jsId)
    {
        try{
            $success = \Config::get('common.create_success_response');
            $failure = \Config::get('common.create_failure_response');

            $content      = $request->except(['_token','logo','otherImages','_method']);
            $content['room_types'] = json_encode($content['room_types']);

            if (isset($content['trails'])) {
                $content['trails'] = json_encode($content['trails']);
            }

            $validator = \Validator::make($request->all(), [
            	'name' => 'required',
            ]);

            if ($validator->fails()) {
                \Session::flash('alert-danger', 'Invalid params');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }


            if ($request->file('logo')) {
                // Upload Image
                $file = $request->file('logo') ;
                $fileName = $file->getClientOriginalName() ;
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                //Upload to S3
                $destinationFileName = time()."_logo.$ext";
                $filePath = "jsImages/$jsId/$destinationFileName";

                $s3 = \Storage::disk('s3');
                $s3->put($filePath, file_get_contents($file), 'public');
                $s3Url = \Storage::disk('s3')->url($filePath);

                $content['logo'] = $s3Url;
            }

            $update  = \App\JungleStay\Stay::where('id', $jsId)->update($content);

            // Upload the other images
            if ($request->file('otherImages')) {
                if($files=$request->file('otherImages')){
                    foreach($files as $index => $file){
                        $fileName = $file->getClientOriginalName() ;

                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                        // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/'. $jsId;
                        // $destinationFileName = time().$index.".$ext";

                        // $pathToSacveInDB = '/assets/img/trails/'.$jsId.'/'.$destinationFileName;
                        // $file->move($destinationPath,$destinationFileName);

                        //Upload to S3
                        $destinationFileName = time()."$index.$ext";

                        $filePath = "jsImages/$jsId/$destinationFileName";

                        $s3 = \Storage::disk('s3');
                        $s3->put($filePath, file_get_contents($file), 'public');
                        $s3Url = \Storage::disk('s3')->url($filePath);

                        $trekImageList['js_id'] = $jsId;
                        $trekImageList['s3_upload'] = 1;
                        $trekImageList['name'] = $s3Url;

                        $create  = \App\JungleStay\Images::create($trekImageList);
                    }
                }
            }

            \Session::flash('alert-success', 'Added successfully');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }catch(\Exception $e ){
            // echo "$e"; exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try{
            $update  = \App\JungleStay\Images::where('js_id', $id)->delete();
            $update  = \App\JungleStay\Rooms::where('js_id', $id)->delete();
            $update  = \App\JungleStay\Parking::where('js_id', $id)->delete();
            $update  = \App\JungleStay\Stay::where('id', $id)->delete();
            \Session::flash('alert-success', 'Deleted successfully');
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process');
        }

    }

    public function staysImages(Request $request)
    {
        try{
            $content = $request->except(['_token']);
            // echo "<pre>"; print_r($content['images']); exit;

            foreach ($content['images'] as $key => $value) {
                \App\JungleStay\Images::where('id', $key)->update(['status' => $value]);

            }

            \Session::flash('alert-success', 'Updated successfully');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);

        }catch(\Exception $e ){
            echo "$e"; exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }


    }
}
