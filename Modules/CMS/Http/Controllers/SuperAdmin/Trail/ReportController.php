<?php

namespace Modules\CMS\Http\Controllers\SuperAdmin\Trail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {

                $circleList = [];

                // Get all the parks of the circle
                $getCircles = \App\Circle::all()->toArray();

                foreach ($getCircles as $index => $circle) {
                   $circleList[$circle['id']] = $circle['name'];
                }

                // echo "<pre>";print_r($circleList);exit();
                return view('cms::superAdmin.TrailReport.index', ['circleList'=> $circleList]);

                return view('Admin/adminPages/superAdmin/reports/index', ['circleList'=> $circleList]);
                        
            } catch (Exception $e) {
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
        return view('cms::create');
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

    public function downloadReport(Request $content)
    {
        $all = false;
        $trail = explode("_", $content['trail']);
        $fileName = '';
        $outputArray = [];

        if ($trail[0] == 'All') {
            $all = true;
            $traillist = explode(",", $trail[1]);
            $fileName = 'All';
        }else{
            $traillist = $trail[0];
            $fileName = $trail[1];
        }

        $outputArray = $this->getOutputArray($content, $traillist, $all);

        if (count($outputArray) > 0) {
            $fileName = $fileName.'_'.$content['selectMonth'];
            $this->downloadAsXlsx($fileName, $outputArray);
        }else{
            \Session::flash('alert-danger', 'Sorry could not process. No data');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }
}
