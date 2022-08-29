<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mockery\Exception;
use Session;

class BirdSanctuaryBookingsController extends Controller
{
    public function getBirdSanctuaryBookings(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $birdSanctuaryBookingData = \App\BirdSanctuary\birdSanctuaryBookings::all()->toArray();

            return view('Admin/birdSanctuary/birdsanctuarybookings/index', ['birdSanctuaryBookingData'=> $birdSanctuaryBookingData]);
        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/birdSanctuaryBookings'));
        }
    }

    public function viewBirdSanctuaryBookings(Request $request, $bookingId, $userId)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        if ($request->session()->get('userId')) {
            try {
                
                // booking details
                $bookingData = \App\BirdSanctuary\birdSanctuaryBookings::where('id',$bookingId)->get()->toArray();
                $bookingData = $bookingData[0];

                $bookingData['visitors_details'] = json_decode($bookingData['visitors_details'],true);

                // BirdSanctuary Details
                $birdSanctuaryData = \App\BirdSanctuary\birdSanctuary::where('id',$bookingData['birdSanctuary_id'])->select('name')->get()->toArray();
                $boatTypeData = \App\BirdSanctuary\boatType::where('birdSanctuary_id',$bookingData['birdSanctuary_id'])->select('name')->get()->toArray();

                $bookingData['birdSanctuaryName'] = $birdSanctuaryData[0]['name'];
                $bookingData['boatType'] = $boatTypeData[0]['name'];
            
                // User details
                $userData = \App\User::where('id',$userId)->get()->toArray();

                return view('Admin/birdSanctuary/birdsanctuarybookings/bookingDetails', ['bookingData'=> $bookingData,'userData' =>$userData[0]]);
            } catch (Exception $e) {
                Session::flash('message', 'Sorry could not process. '. $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/birdSanctuaryBookings'));
            }
        }else{
            return redirect()->route('adminHome');
        }
    }
}
