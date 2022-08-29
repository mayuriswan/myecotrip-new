<?php

namespace App\Http\Controllers\Admin\Safari;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class SafariBookingsController extends Controller
{
    public function getSafariBookings(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $safariBookingData = \App\Safari\SafariBookings::all()->toArray();

            return view('Admin/safari/safaribookings/index', ['safariBookingData'=> $safariBookingData]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariBookings'));
        }
    }

    /*public function viewSafariBookings(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();
        try{
            $viewsafariBookingData = \App\Safari\SafariBookings::where('id',$content['id'])->get()->toArray();
            $safarilist = \App\Safari\Safari::where('id', $viewsafariBookingData[0]['safari_id'])->get()->toArray();
            $transporttypeslist = \App\Transportation\TransportationTypes::where('id', $viewsafariBookingData[0]['transportation_id'])->get()->toArray();
            $vehiclelist = \App\Safari\SafariVehicle::where('id', $viewsafariBookingData[0]['vehicle_id'])->get()->toArray();
            $userlist = \App\User::where('id', $viewsafariBookingData[0]['user_id'])->get()->toArray();

            return view('Admin/safari/safaribookings/view', ['viewsafariBookingData'=> $viewsafariBookingData[0],'safarilist' => $safarilist[0],'transporttypeslist' => $transporttypeslist[0], 'vehiclelist' => $vehiclelist[0],'userlist' => $userlist[0]]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/safariBookings'));
        }
    }*/

    public function viewSafariBookings(Request $request, $bookingId, $userId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {

                // booking details
                $bookingData = \App\Safari\SafariBookings::where('id',$bookingId)->get()->toArray();
                $bookingData = $bookingData[0];

                $bookingData['visitors_details'] = json_decode($bookingData
                ['visitors_details'],true);

                // Safari Details
                $safariData = \App\Safari\Safari::where('id',$bookingData['safari_id'])->select('name')->get()->toArray();

                $bookingData['safariName'] = $safariData[0]['name'];

                // User details
                $userData = \App\User::where('id',$userId)->get()->toArray();

                // echo "<pre>";print_r($bookingData);print_r($trailData);exit();
                return view('Admin/safari/safaribookings/bookingDetails', ['bookingData'=> $bookingData,'userData' =>$userData[0]]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('getTrailAdmins');
            }
        }else{
            return redirect()->route('adminHome');
        }
    }
}
