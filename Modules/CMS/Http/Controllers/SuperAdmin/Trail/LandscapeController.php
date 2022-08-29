<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\Trail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LandscapeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
     try {
         //Get the list of stays
        $landscapelist = \App\Landscape::all()->toArray();


         // echo "<pre>"; print_r($getRows);exit();
         return view('cms::superAdmin.Landscape.index', ['data' => $landscapelist]);

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
        return view('cms::superAdmin.Landscape.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
            'seo_url'   => 'required',
            'display_order_no'   => 'required',
            'logo' => 'required|mimes:jpeg,png|max:2000'
        ]);

        if ($validator->fails()) {
            
            \Session::flash('alert-danger', 'Invalid Payload'. $validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
            
        }else{
            try{
                // check for the email already exist
                $checkLandscape = \App\Landscape::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkLandscape) > 0){
                    \Session::flash('alert-danger', 'Sorry this landscape is exist already!!');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);

                }else{

                    // Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/landscape/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/landscape/'.$destinationFileName;
                    $file->move($destinationPath,$destinationFileName);
                    
                    $content['logo'] = $pathToSacveInDB;

                    $create  = \App\Landscape::create($content);

                    \Session::flash('alert-success', 'Landscape added successfully');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);

                }
                
            }catch(\Exception $e ){
                \Session::flash('alert-danger', 'Sorry could not insert.');
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
            $data = \App\Landscape::where('id', $id)->get()->toArray();
            

            if(count($data) > 0){
                $data[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');

                
                return view('cms::superAdmin.Landscape.edit', ['data'=>$data[0]]);
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
        $content      = $request->all();
        $landscapeId  = $id;

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
            'seo_url'   => 'required',
            'display_order_no'   => 'required',
        ]);

        if ($validator->fails()) {
            \Session::flash('alert-danger', 'Sorry Could not process'.$validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }else{
            try{

                if (isset($content['logo'])) {

                    // Get the record to delete the existing file
                    $getRow = \App\Landscape::where('id',$landscapeId)->get()->toArray();


                    // Upload Image
                    $file = $request->file('logo') ;
                
                    $fileName = $file->getClientOriginalName() ;

                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    $destinationPath = public_path().'/assets/img/landscape/';
                    $destinationFileName = time().".$ext";
                    
                    $pathToSacveInDB = '/assets/img/landscape/'.$destinationFileName;
                    $copyFile = $file->move($destinationPath,$destinationFileName);
                    
                    if ($copyFile) {
                        $filepath = public_path().$getRow[0]['logo'];
                        unlink($filepath);
                    }
                    
                    $content['logo'] = $pathToSacveInDB;
                }

                unset($content['_token']);
                unset($content['landscapeId']);
                unset($content['_method']);

                $updateLandscape = \App\Landscape::where('id', $landscapeId)->update($content);

                \Session::flash('alert-success', 'Landscape updated successfully');
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
        try{
            // Get the ciecles details
            $landscapeData = \App\Landscape::where('id', $id)->get()->toArray();

            if(count($landscapeData) > 0){
                $updateLandscape = \App\Landscape::where('id', $id)->delete();

                \Session::flash('alert-success', 'Deleted successfully');
                 $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']); 

            }else{
                \Session::flash('alert-danger', 'Sorry!! Couldnt process your request. Try once again. ');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
            
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process'.$e);
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }
}
