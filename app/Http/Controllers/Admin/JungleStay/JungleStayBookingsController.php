<?php

namespace App\Http\Controllers\Admin\JungleStay;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class JungleStayBookingsController extends Controller
{
    public function getJungleStayBookings(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $junglestayBookingData = \App\JungleStay\jungleStayBookings::all()->toArray();

            return view('Admin/jungleStay/jungleStaybookings/index', ['junglestayBookingData'=> $junglestayBookingData]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayBookings'));
        }
    }

    public function viewJungleStayBookings(Request $request, $bookingId, $userId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                
                // booking details
                $bookingData = \App\JungleStay\jungleStayBookings::where('id',$bookingId)->get()->toArray();
                $bookingData = $bookingData[0];

                $bookingData['visitors_details'] = json_decode($bookingData['visitors_details'],true);

                // BirdSanctuary Details
                $junglestayData = \App\JungleStay\jungleStay::where('id',$bookingData['junglestay_id'])->select('name')->get()->toArray();
                $boatTypeData = \App\JungleStay\jungleStayRooms::where('jungleStay_id',$bookingData['junglestay_id'])->select('type')->get()->toArray();

                $bookingData['junglestayName'] = $junglestayData[0]['name'];
                $bookingData['stayType'] = $boatTypeData[0]['type'];
            
                // User details
                $userData = \App\User::where('id',$userId)->get()->toArray();

                return view('Admin/jungleStay/jungleStaybookings/bookingDetails', ['bookingData'=> $bookingData,'userData' =>$userData[0]]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayBookings'));
            }
        }else{
            return redirect()->route('adminHome');
        }
    }
}
