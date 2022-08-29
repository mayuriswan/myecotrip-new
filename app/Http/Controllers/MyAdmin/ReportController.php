<?php

namespace App\Http\Controllers\MyAdmin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

set_time_limit(0);
ini_set('memory_limit', '1G');

class ReportController extends Controller
{
    public function downloadReport(Request $request)
    {
    	ob_end_clean();
		ob_start();

    	// echo "<pre>";print_r($_POST);exit();
    	$requestFrom = $_POST['requestFrom'];
    	switch ($requestFrom) {
    		case 'trailAdmin':
    			return $this->trailAdmin($request);
    			break;
    		case 'parkAdmin':
    			return $this->parkAdmin($request);
    			break;
    		case 'circleAdmin':
    			return $this->circleAdmin($request);
    			break;
    		default:
    			# code...
    			break;
    	}

    	ob_flush();
    }

	public function trailAdmin($content)
	{
		
		$all = false;
	    $trailId = $content->session()->get('trailId');
	    

    	$outputArray = $this->getOutputArray($content, $trailId, $all);

    	// Trail Details
        $trailData = \App\Trail::where('id',$trailId)->select('name')->get()->toArray();
		$trailName = $trailData[0]['name'];

	    if (count($outputArray) > 0) {
	    	$fileName = $trailName.'_'.$content['selectMonth'];
	    	$this->downloadAsXlsx($fileName, $outputArray);
	    }else{
	    	Session::flash('message', 'Sorry could not process. No data'); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('TAbookingReports');
	    }
	}

	public function downloadAsXlsx($fileName, $data )
	{
		return \Excel::create($fileName, function($excel) use ($data) {
            $excel->sheet('Items', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->store('xlsx')->download('xlsx');
	}

	public function parksTrails(Request $request)
    {
        $traillist = [];
        $parkId = $request->session()->get('parkId');

        // get the trails assoiated with park
        $getTrails = \App\Trail::where('park_id',$parkId)->select('id')->get()->toArray();
        foreach ($getTrails as $index => $trails) {
            $traillist[] = $trails['id'];
        }

        return $traillist;
    }

	public function parkAdmin($content)
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
	    	Session::flash('message', 'Sorry could not process. No data'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('PAbookingReports'); 
        }
	}

	public function circleAdmin($content)			
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
	    	Session::flash('message', 'Sorry could not process. No data'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('CAbookingReports'); 
        }
	}

	public function getOutputArray($content, $traillist, $all)
	{
		$outputArray = [];
		$Items = [];
		$startDate = $content['selectMonth'].'-01';
	    $endDate = $content['selectMonth'].'-31';

	    if ($content['type'] == 'Online') {
	    	if ($all) {
	            $getBooking = \App\TrailBooking::whereIn('trail_id',$traillist)
			                ->whereDate('checkIn','>=',$startDate)
			                ->whereDate('checkIn','<=',$endDate)
			                ->where('booking_status', 'Success')
			                ->orderBy('id', 'DESC')
			                ->get()
			                ->toArray();
	    	}else{
	    		$getBooking = \App\TrailBooking::where('trail_id',$traillist)
			                ->whereDate('checkIn','>=',$startDate)
			                ->whereDate('checkIn','<=',$endDate)
			                ->where('booking_status', 'Success')
			                ->orderBy('id', 'DESC')
			                ->get()
			                ->toArray();
	    	}

            foreach ($getBooking as $index => $bookings) {
                // get the trail name
                $getName = \App\User::where('id',$bookings['user_id'])->get()->toArray();

                // Trail Details
                $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();
                
                $getBooking[$index]['user'] = $getName[0]['first_name'];
		        $getBooking[$index]['phone_no'] = $getName[0]['contact_no'];
		        $getBooking[$index]['email'] = $getName[0]['email'];
		        $getBooking[$index]['trailName'] = $trailData[0]['name'];

		        $unsetItems = ['user_id','trail_id','amountWithTax','booking_status', 'gatewayResponse','gatewayResponse','created_at','updated_at','trekkers_details'];

                foreach ($unsetItems as $unsetKeys) {
		        	unset($getBooking[$index][$unsetKeys]);
		        }
		        $Items[] = $getBooking[$index];

            }

            $downloadKeys = ['SlNo'=>'id','bookingId'=>'display_id','user'=>'user','Trail'=>'trailName','phone_no'=>'phone_no','email'=>'email','Date of booking'=>'date_of_booking','checkIn'=>'checkIn','Trekkers'=>'number_of_trekkers','amount'=>'amount'	];

	    	$outputArray = [];
	    	foreach ($Items as  $index => $value) {
		    	foreach ($downloadKeys as $displayKey => $dbKey) {
		    		$outputArray[$index][$displayKey] = $value[$dbKey];
		    	}
	    	}
	    }else{
	    	if ($all) {
	    		 $getBooking = \App\TrailOflineBOokings::whereIn('trail_id',$traillist)
			                ->whereDate('checkIn','>=',$startDate)
			                ->whereDate('checkIn','<=',$endDate)
			                ->where('booking_status', 'Success')
			                ->orderBy('id', 'DESC')
			                ->get()
			                ->toArray();
	    	}else{
	    		$getBooking = \App\TrailOflineBOokings::where('trail_id',$traillist)
			                ->whereDate('checkIn','>=',$startDate)
			                ->whereDate('checkIn','<=',$endDate)
			                ->where('booking_status', 'Success')
			                ->orderBy('id', 'DESC')
			                ->get()
			                ->toArray();
	    	}

	    	foreach ($getBooking as $index => $bookings) {
               // Trail Details
		        $trailData = \App\Trail::where('id',$bookings['trail_id'])->select('name')->get()->toArray();
		        
		        $getBooking[$index]['user'] = $bookings['name'];
		        $getBooking[$index]['phone_no'] = $bookings['contat_no'];
		        $getBooking[$index]['email'] = $bookings['email'];
		        $getBooking[$index]['trailName'] = $trailData[0]['name'];
		        $trailName = $trailData[0]['name'];

		        $unsetItems = ['user_id','trail_id','amountWithTax','booking_status', 'gatewayResponse','gatewayResponse','created_at','updated_at','trekkers_details'];

		        foreach ($unsetItems as $unsetKeys) {
		        	unset($getBooking[$index][$unsetKeys]);
		        }
		        $Items[] = $getBooking[$index];		                             
		    }

	    	$downloadKeys = ['SlNo'=>'id','bookingId'=>'display_id','user'=>'user','Trail'=>'trailName','phone_no'=>'phone_no','email'=>'email','checkIn'=>'checkIn','Trekkers'=>'number_of_trekkers','amount'=>'amount','receipt' => 'receipt'];

	    	
	    	foreach ($Items as  $index => $value) {
		    	foreach ($downloadKeys as $displayKey => $dbKey) {
		    		$outputArray[$index][$displayKey] = $value[$dbKey];
		    	}
	    	}
	    }

	    return $outputArray;
	}

	public function trailBookingReports(Request $request)
	{
		$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {

                $circleList = [];

		        // Get all the parks of the circle
		        $getCircles = \App\Circle::all()->toArray();

		        foreach ($getCircles as $index => $circle) {
		           $circleList[$circle['id']] = $circle['name'];
		        }

                // echo "<pre>";print_r($circleList);exit();
                return view('Admin/adminPages/myAdmin/reports/index', ['circleList'=> $circleList]);
                        
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('myAdminHome');
            }
        }
	}

	public function circlesParlList(Request $request, $circleId)
	{
		$parklist = [];
		$parkIds = [];

        if ($circleId != 'All') {
            $getParkss = \App\Parks::where('circle_id',$circleId)->select('id','name')->get()->toArray();
        }else{
            $getParkss = \App\Parks::select('id','name')->get()->toArray();
        }
        
        foreach ($getParkss as $index => $trails) {
            $parkIds[] = $trails['id'];
            $parklist[$trails['id']] = $trails['name'];
        }

        $allValue = implode(',', $parkIds);

        return view('Admin/adminPages/myAdmin/reports/parks', ['parklist'=> $parklist, 'allValue' => $allValue]);
	}

	public function parksTrailList(Request $request, $parkId)
    {
        $traillist = [];
        $trailIds = [];

    	$parkId = explode("_", $parkId);

        if ($parkId[0] != 'All') {
            $getTrails = \App\Trail::where('park_id',$parkId[0])->select('id','name')->get()->toArray();
        }else{
        	$parkId = explode(',', $parkId[1]);
            $getTrails = \App\Trail::whereIn('park_id',$parkId)->select('id','name')->get()->toArray();
        }

        // echo '<pre>';print_r($getTrails);exit();
        foreach ($getTrails as $index => $trails) {
            $trailIds[] = $trails['id'];
            $traillist[$trails['id']] = $trails['name'];
        }

        $allValue = implode(',', $trailIds);
        return view('Admin/adminPages/myAdmin/reports/trails', ['traillist'=> $traillist, 'allValue' => $allValue]);
    }
}
