<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\Trail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
     try {
         //Get the list of stays
        $data = \App\TrailTimeslot::all()->toArray();


         // echo "<pre>"; print_r($getRows);exit();
         return view('cms::superAdmin.Timeslot.index', ['data' => $data]);

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
        return view('cms::superAdmin.Timeslot.create');
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
            'timeslots'   => 'required',
            'isActive'   => 'required'
        ]);

        if ($validator->fails()) {
            
            \Session::flash('alert-danger', 'Invalid Payload'. $validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
            
        }else{
            try{
                
                $timeSlotsList = \App\TrailTimeslot::whereRaw('LOWER(timeslots) = ?', [$content['timeslots']])
                                                        ->get()->toArray();

                if(count($timeSlotsList) > 0)
                {
                    \Session::flash('alert-danger', 'Sorry this Time Slot is already existed!!');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }
                $timeSlotsList = \App\TrailTimeslot::create($content);

                \Session::flash('alert-success', 'Added successfully');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
                
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
            $data = \App\TrailTimeslot::where('id', $id)->get()->toArray();
            

            if(count($data) > 0){
                return view('cms::superAdmin.Timeslot.edit', ['data'=>$data[0]]);
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

        $validator = \Validator::make($request->all(), [
            'timeslots'   => 'required',
            'isActive'   => 'required'
        ]);

        if ($validator->fails()) {
            \Session::flash('alert-danger', 'Sorry Could not process'.$validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }else{
            try{

                
                unset($content['_token']);
                unset($content['_method']);

                $timeSlotsList = \App\TrailTimeslot::whereRaw('LOWER(timeslots) = ?', [$content['timeslots']])
                                                        ->where('id','!=', $id)
                                                        ->get()->toArray();

                if(count($timeSlotsList) > 0)
                {
                    \Session::flash('alert-danger', 'Sorry this Time Slot is already existed!!');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }
                $timeSlotsList = \App\TrailTimeslot::where('id', $id)->update($content);

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
            $landscapeData = \App\TrailTimeslot::where('id', $id)->get()->toArray();

            if(count($landscapeData) > 0){
                $updateLandscape = \App\TrailTimeslot::where('id', $id)->delete();

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
