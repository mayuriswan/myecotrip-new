<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\Trail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $getRows = \App\TrailEntryFee::
                    leftJoin('trail_pricing_masters', 'trail_pricing_masters.id','=', 'trail_entry_fee.pricing_master_id')
                    ->leftJoin('trails', 'trails.id','=', 'trail_entry_fee.trail_id')
                    ->select('trail_pricing_masters.name', 'trail_pricing_masters.shortDesc', 'trail_entry_fee.id', 'trail_entry_fee.price', 'trail_pricing_masters.bill_name','grouping_id', 'trails.name as trailName', 'version')
                    // ->orderBy('trail_pricing_masters.display_order')
                    ->get()
                    ->toArray();


            // echo "<pre>"; print_r($getRows);exit();
            return view('cms::superAdmin.TrailPricing.index', ['data' => $getRows]);

        } catch (\Exception $e) {
            // echo "$e";exits;
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
            $getRows['trails'] = \App\Trail::select('id', 'name')->orderBy('name')
                    ->get()
                    ->toArray();

            $getRows['timeslots'] = \App\TrailTimeslot::get()
                    ->toArray();

            $getRows['types'] = \App\TrailPricingMaster::select('id', 'name')->get()
                    ->toArray();


            // echo "<pre>"; print_r($getRows);exit();
            return view('cms::superAdmin.TrailPricing.create', ['data' => $getRows]);

        } catch (\Exception $e) {
            // echo "$e";exits;
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

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'from_date'    => 'required|date',
            'to_date'      => 'required|date|after_or_equal:from_date',
            'trail_id'     => 'required',
            'timeslot_id'     => 'required'
        ]);


        if ($validator->fails()) {
            
            \Session::flash('alert-danger', 'Invalid Payload'. $validator->errors());
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
            
        }else{
            try{
                
                $trialData = \App\Trail::where('id', $content['trail_id'])->select('entrance_fee_version')
                                ->get()->toArray();

                // echo "<pre>"; print_r(count($trialData) );exit;

                if(!count($trialData))
                {
                    \Session::flash('alert-danger', 'Sorry could not get trail data!!');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }

                $newVersion = $trialData[0]['entrance_fee_version'] + 1;

                $insertContnet = [];
                $basicContent = $request->except(['_token','type']);
                $basicContent['version'] = $newVersion;

                foreach ($content['type'] as $key => $value) {
                    $append = $basicContent;
                    $append['pricing_master_id'] = $key;
                    $append['price'] = $value;

                    $insertContnet[] = $append;

                    // $create  = \App\TrailEntryFee::create($append);


                }

                $create  = \App\TrailEntryFee::insert($insertContnet);

                //Update other timeslot version also
                \App\TrailEntryFee::where('version', $trialData[0]['entrance_fee_version'])
                                    ->where('trail_id', $content['trail_id'])
                                    ->update(['version' => $newVersion]);


                //Update trail version
                \App\Trail::where('id', $content['trail_id'])->update(['entrance_fee_version' => $newVersion]);

                \Session::flash('alert-success', 'Added successfully');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
                
            }catch(\Exception $e ){
                echo "$e"; exit;
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
        //
    }
}
