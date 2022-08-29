<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\JungleStay;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;

use App\Http\Controllers\Controller;
use Session;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     public function index(Request $request, $jsId)
     {
         try {
             //Get the list of stays
             $getRows =  \App\JungleStay\Rooms::join('js_room_types', 'js_room_types.id','js_rooms.js_type')
                        ->where('js_id', $jsId)
                        ->select('js_rooms.*','js_room_types.name as type')
                        ->orderBy('js_rooms.id','DESC')
                        ->get()->toArray();

             session(['roomsList' => url('/').'/cms/jungle-stay/rooms-list/'.$jsId]);
             // echo "<pre>"; print_r($getRows);exit();
             return view('cms::superAdmin.JungleStay.Rooms.index', ['data' => $getRows,'jsId' => $jsId]);

         } catch (\Exception $e) {
             echo "$e";exit;
             \Session::flash('alert-danger', 'Sorry Could not process');
             $data =  $request->session()->get('_previous');
             return \Redirect::to($data['url']);
         }

     }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request, $jsId)
    {
        try {
            $getRoomTypes =  \App\JungleStay\Stay::where('id',$jsId)->get()->toArray()[0];
            $roomTypes = json_decode($getRoomTypes['room_types']);

            //Get the list of stays
            $getRows['roomTypes'] =  \App\JungleStay\RoomType::whereIn('id', $roomTypes)->get()->toArray();
            $getRows['amenities'] =  \App\JungleStay\Amenities::where('status',1)->get()->toArray();

            // echo "<pre>"; print_r($getRows);exit();
            return view('cms::superAdmin.JungleStay.Rooms.create', ['data' => $getRows,'jsId' => $jsId]);

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
             // echo "<pre>"; print_r($request->all());exit;
             $validator = \Validator::make($request->all(), [
             	 'no_of_rooms' => 'required',
                 'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                 'js_type' => 'required',
                 'js_id' => 'required',
                 'display_order' => 'required',
                 'maintaince_charge' => 'required',
                 'max_capacity' => 'required'
             ]);

             if ($validator->fails()) {
                 \Session::flash('alert-danger', 'Invalid params'. $validator->errors());
                 $data =  $request->session()->get('_previous');
                 return \Redirect::to($data['url']);
             }

             if (isset($content['amenities'])) {
                 $content['amenities'] = json_encode($content['amenities']);
             }

             $create  = \App\JungleStay\Rooms::create($content);
             $roomId = $create->id;

             // Upload Image
             $file = $request->file('logo') ;
             $fileName = $file->getClientOriginalName() ;
             $ext = pathinfo($fileName, PATHINFO_EXTENSION);

             //Upload to S3
             $destinationFileName = time()."_logo.$ext";
             $filePath = "jsImages/$roomId/$destinationFileName";

             $s3 = \Storage::disk('s3');
             $s3->put($filePath, file_get_contents($file), 'public');
             $s3Url = \Storage::disk('s3')->url($filePath);

             $update['logo'] = $s3Url;

             $update  = \App\JungleStay\Rooms::where('id', $roomId)->update($update);

             // Upload the other images
             // if ($request->file('otherImages')) {
             //     if($files=$request->file('otherImages')){
             //
             //         foreach($files as $index => $file){
             //             $fileName = $file->getClientOriginalName() ;
             //             //Upload to S3
             //             $ext = pathinfo($fileName, PATHINFO_EXTENSION);
             //             $destinationFileName = time()."$index.$ext";
             //
             //             $filePath = "jsImages/$roomId/$destinationFileName";
             //
             //             $s3 = \Storage::disk('s3');
             //             $s3->put($filePath, file_get_contents($file), 'public');
             //             $s3Url = \Storage::disk('s3')->url($filePath);
             //
             //             $trekImageList['js_id'] = $content['js_id'];
             //             $trekImageList['room_id'] = $roomId;
             //             $trekImageList['s3_upload'] = 1;
             //             $trekImageList['type'] = 2; // Room images
             //             $trekImageList['name'] = $s3Url;
             //
             //             // echo "<pre>";print_r($trekImageList); exit;
             //             $create  = \App\JungleStay\Images::create($trekImageList);
             //
             //         }
             //     }
             // }

             \Session::flash('alert-success', 'Added successfully');
             $data =  $request->session()->get('_previous');
             return \Redirect::to($data['url']);
         }catch(\Exception $e ){
             // echo "$e";exit;
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
    public function show($id)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            // Get the ciecles details
            $jsData = \App\JungleStay\Rooms::where('id', $id)->get()->toArray();

            // echo "<pre>";print_r($jsData);exit();

            //Get the list of static data
            $data['roomTypes'] =  \App\JungleStay\RoomType::where('status',1)->get()->toArray();
            $data['amenities'] =  \App\JungleStay\Amenities::where('status',1)->get()->toArray();

            if(count($jsData) > 0){
                // $jsData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');
                $jsData = $jsData[0];

                if ($jsData['amenities']) {
                    $jsData['amenities'] = json_decode($jsData['amenities']);
                }else{
                    $jsData['amenities'] = [];
                }

                $jsData['images'] = \App\JungleStay\Images::where('room_id',$id)->get()->toArray();
                // echo "<pre>";print_r($jsData);exit();
                return view('cms::superAdmin.JungleStay.Rooms.edit', ['data' => $data, 'jsData' => $jsData]);
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
    public function update(Request $request, $roomId)
    {
        try{
            $success = \Config::get('common.create_success_response');
            $failure = \Config::get('common.create_failure_response');

            $content      = $request->except(['_token','logo','otherImages','_method']);
            // echo "<pre>"; print_r($request->all());exit;
            $validator = \Validator::make($request->all(), [
                'no_of_rooms' => 'required',
                 // 'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                 'js_type' => 'required',
                 'js_id' => 'required',
                 'display_order' => 'required',
                 'maintaince_charge' => 'required',
                 'max_capacity' => 'required'
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
                $filePath = "jsImages/$roomId/$destinationFileName";

                $s3 = \Storage::disk('s3');
                $s3->put($filePath, file_get_contents($file), 'public');
                $s3Url = \Storage::disk('s3')->url($filePath);

                $content['logo'] = $s3Url;

            }

            if (isset($content['amenities'])) {
                $content['amenities'] = json_encode($content['amenities']);
            }

            $update  = \App\JungleStay\Rooms::where('id', $roomId)->update($content);

            // Upload the other images
            if ($request->file('otherImages')) {
                if($files=$request->file('otherImages')){

                    foreach($files as $index => $file){
                        $fileName = $file->getClientOriginalName() ;
                        //Upload to S3
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $destinationFileName = time()."$index.$ext";

                        $filePath = "jsImages/$roomId/$destinationFileName";

                        $s3 = \Storage::disk('s3');
                        $s3->put($filePath, file_get_contents($file), 'public');
                        $s3Url = \Storage::disk('s3')->url($filePath);

                        $trekImageList['js_id'] = $content['js_id'];
                        $trekImageList['room_id'] = $roomId;
                        $trekImageList['s3_upload'] = 1;
                        $trekImageList['type'] = 2; // Room images
                        $trekImageList['name'] = $s3Url;

                        // echo "<pre>";print_r($trekImageList); exit;
                        $create  = \App\JungleStay\Images::create($trekImageList);

                    }
                }
            }

            \Session::flash('alert-success', 'Added successfully');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }catch(\Exception $e ){
            // echo "$e";exit;
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
            $update  = \App\JungleStay\Images::where('room_id', $id)->delete();
            $update  = \App\JungleStay\Rooms::where('id', $id)->delete();
            \Session::flash('alert-success', 'Deleted successfully');

        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process');
        }
    }
}
