<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\JungleStay;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Session;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     public function index(Request $request, $roomId)
     {
         try {
             //Get the list of stays
             $getRows =  \App\JungleStay\RoomPricing::join( 'js_pricing_master as master', 'master.id','js_room_pricing.pricing_id')
                        ->where('room_id', $roomId)
                        ->where('js_room_pricing.status', 1)
                        ->select('js_room_pricing.*','master.name as name as priceMaster','master.shortDesc')
                        ->orderBy('js_room_pricing.id','DESC')
                        ->get()->toArray();

             // echo "<pre>"; print_r($getRows);exit();
             return view('cms::superAdmin.JungleStay.RoomPricing.index', ['data' => $getRows,'roomId' => $roomId]);

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
    public function create(Request $request, $roomId)
    {
        try{
            //get the room type 1st full booking / Individual
            $roomData = \App\JungleStay\Rooms::join('js_room_types as rtype','rtype.id','js_rooms.js_type')
                        ->where('js_rooms.id', $roomId)
                        ->select('rtype.type')
                        ->get()
                        ->toArray()[0];
            // echo "<pre>"; print_r($roomData);exit();

            $data['pricingMaster'] = \App\JungleStay\PricingMaster::where('type',$roomData['type'])->get()->toArray();

            session(['backUrl' => url('/').'/cms/jungle-stay/pricing/'.$roomId]);

            // echo "<pre>"; print_r($data);exit();
            return view('cms::superAdmin.JungleStay.RoomPricing.create', ['data' => $data,'roomId' => $roomId]);

        } catch (\Exception $e) {
            echo "$e";exit;
            \Session::flash('alert-danger', 'Sorry Could not process');
            return \Redirect::to($request->session()->get('roomsList'));

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

            $content      = $request->except(['_token']);
            // echo "<pre>"; print_r($request->all());exit;
            $validator = \Validator::make($request->all(), [
                'room_id' => 'required',
                'pricing_id' => 'required',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                \Session::flash('alert-danger', 'Invalid params');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            //update the status of old entry
            \App\JungleStay\RoomPricing::where('room_id', $content['room_id'])
                            ->where('pricing_id', $content['pricing_id'])
                            ->update(['status' => 0]);

            $create  = \App\JungleStay\RoomPricing::create($content);

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
        return view('cms::show');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try{
            \App\JungleStay\RoomPricing::where('id', $id)->delete();
            \Session::flash('alert-success', 'Deleted successfully');
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process');
        }

    }
}
