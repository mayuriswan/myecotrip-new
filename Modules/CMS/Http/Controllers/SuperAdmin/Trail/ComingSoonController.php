<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\Trail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ComingSoonController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
     try {
        //Get the list of stays
        $datalist = \App\TrialUpcoming::all()->toArray();


         // echo "<pre>"; print_r($getRows);exit();
         return view('cms::superAdmin.TrialUpcoming.index', ['data' => $datalist]);

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
        return view('cms::superAdmin.TrialUpcoming.create');
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
            'shortDesc'   => 'required',
            'googleSearchText'   => 'required'
        ]);

        if ($validator->fails()) {
            \Session::flash('alert-danger', 'Invalid Payload'. $validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
            
        }else{
            try{
                // check for the email already exist
                $check = \App\TrialUpcoming::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($check) > 0){

                    \Session::flash('alert-danger', 'Sorry this trail exist already!!');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);

                }else{
                    $create  = \App\TrialUpcoming::create($content);

                    \Session::flash('alert-success', 'Added successfully');
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
    public function edit($id)
    {
        try{
            // Get the ciecles details
            $data = \App\TrialUpcoming::where('id', $id)->get()->toArray();
            

            if(count($data) > 0){
                $data[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');

                
                return view('cms::superAdmin.TrialUpcoming.edit', ['data'=>$data[0]]);
            }else{
                \Session::flash('alert-danger', 'Sorry Could not process');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
            
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry could not process.'. $e->getMessage());
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
        $content      = $request->except(['_token', '_method']);;

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
            'shortDesc'   => 'required',
            'googleSearchText'   => 'required'
        ]);

        if ($validator->fails()) {
            \Session::flash('alert-danger', 'Invalid Payload'. $validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
            
        }else{
            try{
                // check for the email already exist
                $check = \App\TrialUpcoming::whereRaw('LOWER(name) = ?', [$content['name']])
                                            ->where('id','!=',$id)
                                            ->get()->toArray();

                if(count($check) > 0){

                    \Session::flash('alert-danger', 'Sorry this trail exist already!!');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);

                }else{
                    $create  = \App\TrialUpcoming::where('id', $id)->update($content);

                    \Session::flash('alert-success', 'Updated successfully');
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
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        try{
            // Get the ciecles details
            $landscapeData = \App\TrialUpcoming::where('id', $id)->get()->toArray();

            if(count($landscapeData) > 0){
                $updateLandscape = \App\TrialUpcoming::where('id', $id)->delete();

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
