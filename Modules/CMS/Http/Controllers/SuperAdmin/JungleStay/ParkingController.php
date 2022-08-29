<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\JungleStay;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Session;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     public function index(Request $request)
     {
         try {
             //Get the list of stays
             $getRows =  \App\JungleStay\Parking::join('jungle_stays','jungle_stays.id','js_parking.js_id')
                        ->join('js_parking_types as vehicle','vehicle.id','js_parking.vehicle_id')
                        ->where('js_parking.status',1)
                        ->select('jungle_stays.name','vehicle.type','js_parking.*')
                        ->orderBy('js_parking.id','DESC')
                        ->get()
                        ->toArray();

             // echo "<pre>"; print_r($getRows);exit();
             return view('cms::superAdmin.JungleStay.Parking.index', ['data' => $getRows]);

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
    public function create(Request $request)
    {
        try{
            $data['stays'] =  \App\JungleStay\Stay::orderBy('id','DESC')->select('name', 'id')->get()->toArray();
            $data['vehicles'] =  \App\JungleStay\Vehicle::orderBy('type')->get()->toArray();
            // echo "<pre>"; print_r($data);exit();

            return view('cms::superAdmin.JungleStay.Parking.create', ['data' => $data]);

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

             $content = $request->except(['_token']);

             if (isset($content['trails'])) {
                 $content['trails'] = json_encode($content['trails']);
             }

             $validator = \Validator::make($request->all(), [
                    'js_id' => 'required',
                    'vehicle_id' => 'required',
                    'price' => 'required',
     	            'status' => 'required',
             ]);

             if ($validator->fails()) {
                 \Session::flash('alert-danger', 'Invalid params');
                 $data =  $request->session()->get('_previous');
                 return \Redirect::to($data['url']);
             }

             //Update the old pricing status to 0
             \App\JungleStay\Parking::where('js_id',$content['js_id'])
                            ->where('vehicle_id',$content['vehicle_id'])
                            ->update(['status' => 0]);

             $create  = \App\JungleStay\Parking::create($content);

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
        try{
            $parkingData  = \App\JungleStay\Parking::where('id', $id)->get()->toArray();

            $data['stays'] =  \App\JungleStay\Stay::orderBy('id','DESC')->select('name', 'id')->get()->toArray();
            $data['vehicles'] =  \App\JungleStay\Vehicle::orderBy('type')->get()->toArray();
            // echo "<pre>"; print_r($data);exit();

            return view('cms::superAdmin.JungleStay.Parking.edit', ['data' => $data, 'parkingData' => $parkingData[0]]);

        } catch (\Exception $e) {
            // echo "$e";exit;
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
    public function update(Request $request, $id)
    {
        try{
            $success = \Config::get('common.create_success_response');
            $failure = \Config::get('common.create_failure_response');

            $content      = $request->except(['_token','_method']);

            if (isset($content['trails'])) {
                $content['trails'] = json_encode($content['trails']);
            }

            $validator = \Validator::make($request->all(), [
                   'js_id' => 'required',
                   'vehicle_id' => 'required',
                   'price' => 'required',
                   'status' => 'required',
            ]);

            if ($validator->fails()) {
                \Session::flash('alert-danger', 'Invalid params');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            $create  = \App\JungleStay\Parking::where('id', $id)->update($content);

            \Session::flash('alert-success', 'Updated successfully');
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
            $delete  = \App\JungleStay\Parking::where('id', $id)->delete();
            \Session::flash('alert-success', 'Deleted successfully');
            
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process');
        }
    }
}
