<?php

namespace App\Http\Controllers\Admin\BirdsFest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;


class BirdsFestReportController extends Controller
{
    public function index(Request $request)
    {
    	if ($request->session()->get('userId')) {
            try {
            	//Get the bird sanctory list
            	$getRow = \App\BirdsFest\birdsFestDetails::select('id', 'name')->orderBy('name')->get()->toArray();

                // echo "<pre>";print_r($getRow);exit();
                return view('Admin/adminPages/superAdmin/reports/birdFest', ['data'=> $getRow]);

            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('myAdminHome');
            }
        }else{
        	Session::flash('message', 'Session out');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('myAdminHome');
        }
    }

    public function downloadBirdFestReport(Request $request)
    {
    	try{
    			$bookingData = \App\Events\EventsBooking::join('birdsFestPricing', 'birdsFestPricing.id','=','eventsBooking.booking_type_id')
    						->join('birdsFestDetails', 'birdsFestDetails.id','=','eventsBooking.event_id')
    						->join('users', 'users.id','=','eventsBooking.user_id')
    						->where('eventsBooking.event_id', $_POST['id'])
                            // ->where('eventsBooking.booking_status', 'Success')
                           	->select('kedb_amount','amount','amountWithTax','gatewayResponse','eventsBooking.id','number_of_tickets','birdsFestPricing.name','eventsBooking.booking_status','birdsFestDetails.event_id as type', 'birdsFestDetails.name as eventName', 'users.first_name', 'users.last_name','users.email', 'users.contact_no', 'eventsBooking.*')
                            ->get()
                            ->toArray();

                $outPutArray = array();

                foreach ($bookingData as $key => $bookings) {
                    $append['Id'] = $bookings['id'];
                	$append['Booked On'] = $bookings['date_of_booking'];
                	$append['Booked by'] = $bookings['first_name']. ' ' .$bookings['last_name'];
                    $append['userId'] =  $bookings['user_id'];
                    $append['Email'] =  $bookings['email'];
                	$append['Phone no'] =  $bookings['contact_no'];
                	$append['Booking ID'] = $bookings['display_id'];
                    $append['Booked On'] = $bookings['date_of_booking'];
                    $append['Number'] = $bookings['number_of_tickets'];
                    $append['amount'] = $bookings['amount'];
                    $append['amountWithTax'] = $bookings['amountWithTax'];
                    $append['kedb_amount'] = $bookings['kedb_amount'];
                    $append['gatewayResponse'] = $bookings['gatewayResponse'];
                	$append['booking_status'] = $bookings['booking_status'];



                    if ($bookings['type'] == 3) {
                        $append['users_details']  = json_encode($bookings['users_details']);
                        $outPutArray[] = $append;
                    }else{
                        $userInfo  = json_decode($bookings['users_details'], true);

                    	foreach ($userInfo as $key => $users) {
                    		$append['Name'] = $users['name'];
                    		$append['Age'] = $users['age'];
                    		$append['Gender'] = $users['sex'];

                    		$outPutArray[] = $append;
                    	}
                    }

                }

                if (count($outPutArray) > 0) {
			    	$fileName = 'BirdFestReport';
			    	$this->downloadAsXlsx($fileName, $outPutArray);
			    }else{
			    	Session::flash('message', 'Sorry could not process. No data');
		            Session::flash('alert-class', 'alert-danger');

		            $data =  $request->session()->get('_previous');
	            	return \Redirect::to($data['url']);
		        }

            	echo "<pre>";print_r($outPutArray);exit();


    	} catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }
}
