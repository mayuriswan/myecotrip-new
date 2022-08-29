<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\Trail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TrailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
     try {
         //Get the list of stays
         $getRows =  \App\Trail::select('id','name','status','display_order_no')->get()->toArray();


         // echo "<pre>"; print_r($getRows);exit();
         return view('cms::superAdmin.Trail.index', ['data' => $getRows]);

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
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            // get the parklist
            $parkList = \App\Parks::all()->toArray();
            $landscapelist = \App\Landscape::all()->toArray();

            // get the distance units
            $distanceUnit = \App\distanceMaster::all()->toArray();

            return view('cms::superAdmin.Trail.create', ['landscapelist' => $landscapelist,'parkList'=> $parkList, 'distanceUnit' => $distanceUnit]);
        } catch (Exception $e) {
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
        $success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        $content      = $request->all();

        // echo '<pre>';echo json_encode($content['pricing']);exit;

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            \Session::flash('alert-danger', 'Sorry Could not process. Invalid payload');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }else{
            try{

                // check for the name already exist
                $checkTrail = \App\Trail::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkTrail) > 0){                    

                    \Session::flash('alert-danger', "Sorry this trail exist already!!");
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);

                }else{

                    $content['s3_upload'] = 1;
                    $create  = \App\Trail::create($content);

                    $tailId = $create->id;

                    // Upload Image
                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    //Upload to S3
                    $destinationFileName = time()."_logo.$ext";
                    $filePath = "trailImages/$tailId/$destinationFileName";

                    $s3 = \Storage::disk('s3');
                    $s3->put($filePath, file_get_contents($file), 'public');
                    $s3Url = \Storage::disk('s3')->url($filePath);

                    $update['logo'] = $s3Url;

                    $update  = \App\Trail::where('id', $tailId)->update($update);

                    // Save the price data
                    // $getTheFormat = $this->priceFormat($content);
                    
                    // $fromDate  = strtotime($content['fromDate']); 
                    // $fromDate  =  date("Y-m-d H:i:s", $fromDate);

                    // $toDate  = strtotime($content['toDate']); 
                    // $toDate  =  date("Y-m-d H:i:s", $toDate);

                    // $insertData['trail_id'] = $tailId;
                    // $insertData['from'] = $fromDate;
                    // $insertData['to'] = $toDate;
                    // $insertData['price'] = json_encode($content['pricing']);

                    // $createPrice = \App\TrailPricing::create($insertData);

                    // Upload the trek images
                    if ($content['trekImages']) {
                        if($files=$request->file('trekImages')){
                            foreach($files as $index => $file){
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                                // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/'. $tailId;
                                // $destinationFileName = time().$index.".$ext";
                                
                                // $pathToSacveInDB = '/assets/img/trails/'.$tailId.'/'.$destinationFileName;
                                // $file->move($destinationPath,$destinationFileName);
                                
                                //Upload to S3
                                $destinationFileName = time()."$index.$ext";

                                $filePath = "trailImages/$tailId/$destinationFileName";

                                $s3 = \Storage::disk('s3');
                                $s3->put($filePath, file_get_contents($file), 'public');
                                $s3Url = \Storage::disk('s3')->url($filePath);

                                $trekImageList['trail_id'] = $tailId;
                                $trekImageList['s3_upload'] = 1;
                                $trekImageList['name'] = $s3Url;

                                $create  = \App\TrailImages::create($trekImageList);
                            }
                        }
                    }

                    \Session::flash('alert-success', "Trail added successfully");
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }
                
            }catch(\Exception $e ){
                \Session::flash('alert-danger', "Sorry could not insert.". $e );
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);

            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('cms::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        
        try{
            // Get the ciecles details
            $trailData = \App\Trail::where('id', $id)->get()->toArray();
            
            // get the parklist
            $parkList = \App\Parks::all()->toArray();
            $landscapelist = \App\Landscape::all()->toArray();

            // get the distance units
            $distanceUnit = \App\distanceMaster::all()->toArray();


            if(count($trailData) > 0){
                $trailData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');

                // Get trail images
                $trailImages = \App\TrailImages::where('trail_id',$id)->get()->toArray();
                // print_r($trailData);exit();
                
                return view('cms::superAdmin.Trail.edit', ['trailData'=>$trailData[0], 'landscapelist' => $landscapelist,'parkList'=> $parkList, 'distanceUnit' => $distanceUnit, 'trailImages' => $trailImages]);
            }else{
                \Session::flash('alert-danger', 'Sorry Could not process');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
            
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process'.$e);
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content = $request->all();
        $landscapeId = $content['landscape_id'];

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
            'landscape_id' => 'required'
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {

            \Session::flash('alert-success', 'Invalid Payload');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);

        }else{
            try{
                $trailId = $id;

                if (isset($content['logo'])) {

                    // Get the record to delete the existing file
                    // $getRow = \App\Trail::where('id',$trailId)->get()->toArray();

                    // Local Upload Image
                    // $file = $request->file('logo') ;
                
                    // $fileName = $file->getClientOriginalName() ;

                    // $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/';
                    // $destinationFileName = time().".$ext";
                    
                    // $pathToSacveInDB = '/assets/img/trails/'.$destinationFileName;
                    // $copyFile = $file->move($destinationPath,$destinationFileName);
                    
                    // if ($copyFile) {
                    //     $filepath = \Config::get('common.myecotripHTML').'public'.$getRow[0]['logo'];
                    //     unlink($filepath);
                    // }
                    
                    // $content['logo'] = $pathToSacveInDB;

                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    //Upload to S3
                    $destinationFileName = time()."_logo.$ext";
                    $filePath = "trailImages/$trailId/$destinationFileName";

                    $s3 = \Storage::disk('s3');
                    $s3->put($filePath, file_get_contents($file), 'public');
                    $s3Url = \Storage::disk('s3')->url($filePath);

                    $content['logo'] = $s3Url;
                    $content['s3_upload'] = 1;

                }

                
                // echo "<pre>"; print_r($content);exit;

                // Upload the trek images
                if (isset($content['trekImages']) && count($content['trekImages'][0]) > 0) {
                    if($files=$request->file('trekImages')){
                        foreach($files as $index => $file){

                            //Local update
                            // $fileName = $file->getClientOriginalName() ;

                            // $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/'. $trailId;
                            // $destinationFileName = time().$index.".$ext";
                            
                            // $pathToSacveInDB = '/assets/img/trails/'.$trailId.'/'.$destinationFileName;
                            // $file->move($destinationPath,$destinationFileName);
                            
                            // $trekImageList['trail_id'] = $trailId;
                            // $trekImageList['name'] = $pathToSacveInDB;

                            // $create  = \App\TrailImages::create($trekImageList);

                            // S3 upload
                            $fileName = $file->getClientOriginalName() ;
                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                            $destinationFileName = time()."$index.$ext";

                            $filePath = "trailImages/$trailId/$destinationFileName";

                            $s3 = \Storage::disk('s3');
                            $s3->put($filePath, file_get_contents($file), 'public');
                            $s3Url = \Storage::disk('s3')->url($filePath);

                            $trekImageList['trail_id'] = $trailId;
                            $trekImageList['s3_upload'] = 1;
                            $trekImageList['name'] = $s3Url;

                            $create  = \App\TrailImages::create($trekImageList);

                        }
                    }

                }

                unset($content['trekImages']);
                unset($content['_token']);
                unset($content['dataTables-example_length']);
                unset($content['_method']);

                // echo "<pre>";print_r($content);exit();
                $update  = \App\Trail::where('id',$trailId)->update($content);     

                \Session::flash('alert-success', 'Updated successfully');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);              

                
            }catch(\Exception $e ){
                \Session::flash('alert-danger', 'Sorry Could not process'.$e);
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $success = \Config::get('common.delete_success_response');
        $failure = \Config::get('common.delete_failure_response');

        $content      = $request->all();

        
        try{
            $deleteTrail = \App\Trail::where('id', $id)->delete();

            \Session::flash('alert-success', 'Deleted successfully');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
            
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process'.$e);
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }
}
