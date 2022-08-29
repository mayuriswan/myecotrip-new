<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\JungleStay;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Session;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            //Get the list of stays
            $getRows =  \App\JungleStay\EntryPricing::join('jungle_stays','jungle_stays.id','js_entry_pricing.js_id')
                        ->join('js_entry_master','js_entry_master.id','js_entry_pricing.pricing_id')
                        ->select('js_entry_pricing.*','jungle_stays.name','js_entry_master.name as master','shortDesc')
                        ->orderBy('js_entry_pricing.id','DESC')->get()->toArray();

            // echo "<pre>"; print_r($getRows);exit();
            return view('cms::superAdmin.JungleStay.EntryPricing.index', ['data' => $getRows]);

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
            $data['entryMaster'] =  \App\JungleStay\EntryMaster::where('status', 1)->select('id','name','shortDesc')->orderBy('name')
                                    ->get()->toArray();
            $data['stays'] =  \App\JungleStay\Stay::where('status', 1)->select('id','name')->orderBy('name')
                                    ->get()->toArray();

            // echo "<pre>"; print_r($data);exit();
            return view('cms::superAdmin.JungleStay.EntryPricing.create', ['data' => $data]);

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

            $content      = $request->except(['_token']);
            // echo "<pre>"; print_r($request->all());exit;
            $validator = \Validator::make($request->all(), [
                'js_id' => 'required',
                'pricing_id' => 'required',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                \Session::flash('alert-danger', 'Invalid params');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            //update the status of old entry
            \App\JungleStay\EntryPricing::where('js_id', $content['js_id'])
                            ->where('pricing_id', $content['pricing_id'])
                            ->update(['status' => 0]);

            $create  = \App\JungleStay\EntryPricing::create($content);

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
            \App\JungleStay\EntryPricing::where('id', $id)->delete();
            \Session::flash('alert-success', 'Deleted successfully');
        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry Could not process');
        }
    }
}
