<?php

namespace Modules\APIS\Http\Controllers\Trail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TrailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        echo "string";
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('apis::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('apis::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('apis::edit');
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

    public function getPricing(Request $request, $trailId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        try {

            $output = [];

            $append['name'] = 'Entrance';
            $append['alias'] = 'ENT';
            $append['chargeId'] = 1;
            $append['data'] = $this->entrancePricing($trailId);
            $append['config'] = ['ourPer' => \Config::get('common.internetHandlingCharge'), 'gstPer' => \Config::get('common.gstCharge')];

            $output[] = $append;

            $success['content'] = $output;
            // echo "<pre>"; print_r($charges);exit;

            return \Response::json($success);


        } catch (\Exception $e) {
            $failure['message'] = $e->getMessage();
            return \Response::json($failure);

        }
    }

    public function entrancePricing($trailId)
    {
        //get the current pricing version
        $currentVersion = \App\Trail::where('id', $trailId)->select('entrance_fee_version')->get()->toArray();

        $checkDate = date("Y-m-d");

        $getEntryPricing = \App\TrailEntryFee::
            leftJoin('trail_pricing_masters', 'trail_pricing_masters.id','=', 'trail_entry_fee.pricing_master_id')
            ->where('trail_id', $trailId)
            ->where('version', $currentVersion[0]['entrance_fee_version'])
            ->where('from_date','<=', $checkDate)
            ->where('to_date','>=', $checkDate)
            ->where('isActive', 1)
            ->select('trail_pricing_masters.name', 'trail_pricing_masters.shortDesc', 'trail_entry_fee.id', 'trail_entry_fee.price', 'trail_pricing_masters.bill_name','grouping_id')
            ->orderBy('trail_pricing_masters.display_order')
            ->get()
            ->toArray();

        return $getEntryPricing;
    }

    public function syncTickets(Request $request)
    {
        $success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');
        try {

            $content_json = $request->getContent();
            $data      = json_decode($content_json, true);


             $validator = \Validator::make($request->all(), [
                'display_id' => 'required',
                'date_of_booking' => 'required',
                'checkIn' => 'required',
                'user_id' => 'required',
                'trail_id' => 'required',
                'device_info' => 'required',
                'entrance' => 'required',
                'trekkers_details' => 'required',
                'amount' => 'required',
                'amountWithTax' => 'required',
                'gst_amount' => 'required',
                'number_of_trekkers' => 'required',
                'number_of_children' => 'required',
                'number_of_students' => 'required',
                'total_trekkers' => 'required'   

            ]);

            if ($validator->fails()) {
                $failure['message'] = $validator->errors();
                return \Response::json($failure);
            }

            //Check for the duplicate
            $checkDupliacte = \App\BirdSanctuary\birdSanctuaryBookings::
                where('display_id', $data['display_id'])
                ->where('user_id',$data['user_id'] )
                ->get()->count();

            if(!$checkDupliacte){
                $inserData = $request->except(['entrance']);  
                
                $inserData['time_slot'] = 2;
                $inserData['booking_status'] = "Success";
                $inserData['booking_source'] = 2;
                $inserData['device_info'] = json_encode($inserData['device_info']);
                $inserData['trekkers_details'] = json_encode($inserData['trekkers_details']);

                $placeOrder = \App\TrailBooking::create($inserData);

                if ($placeOrder) {
                    return \Response::json($success);
                }else{
                    return \Response::json($failure);
                }

            }else{
                $success['message'] = 'Duplicate sync!!';
                return \Response::json($success);
            }

        } catch (\Exception $e) {
            $failure['message'] = $e->getMessage();
            return \Response::json($failure);

        }
    }


}
