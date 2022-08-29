<?php

namespace App\Http\Controllers\MyAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnData = \App\Events\EventsBooking::orderBy('id', 'DESC')->get();
        // dd($returnData);
        return view('Admin/adminPages/myAdmin/bookings/event-index', ['rows'=> $returnData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returnData = \App\Events\EventsBooking::find($id);
        // dd($id);
        return view('Admin/adminPages/myAdmin/bookings/eventDetails', ['row'=> $returnData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data['users_details'] = json_encode($_POST['usersDetails']);
            \App\Events\EventsBooking::where('id', $id)->update($data);

            return redirect()->back()->with('success', 'Updated successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry could not process.');
        }
    }

    public function sendMail(Request $request, $id)
    {
        try {
            $order = \App\Events\EventsBooking::findorFail($id);

            if ($order->booking_status != "Success") {
                return redirect()->back()->with('error', 'Please make sure the booking is Success!');
            }

            $subject = "Myecotrip Booking Confirmation";

            $event = \App\BirdsFest\birdsFestDetails::find($order->event_id);

            $bookingData = $order->toArray();
            $bookingData['event_name'] = $order->event->name;


            if($event->event_id == 3){
                // dd(json_decode($bookingData['users_details'],true));
                // return \View::make('payment.bookMailTemplate', ['bookingData' => $bookingData]);
                $message = \View::make('payment.bookMailTemplate', ['bookingData' => $bookingData]);
            }else{
                $message = \View::make('payment.eventMailTemplate', ['bookingData' => $bookingData]);
            }

            $userInfo = \App\User::findorFail($order->user_id);
            $sendMail = $this->sendEmail($userInfo->email, $userInfo->first_name,[], $subject, $message, [], ['myecotrip17@gmail.com']);
            return redirect()->back()->with('success', 'Email sent successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry could not process.');
        }

    }

    public function sendEventSMS(Request $request, $id)
    {
        try {
            $order = \App\Events\EventsBooking::findorFail($id);
            
            if ($order->booking_status != "Success") {
                return redirect()->back()->with('error', 'Please make sure the booking is Success!');
            }

            $event = \App\BirdsFest\birdsFestDetails::find($order->event_id);
            $userInfo = \App\User::findorFail($order->user_id);

            $data['userInfo'] =  $userInfo->toArray();
            $data['bookingData']['event_name'] =  $order->event->name;
            $data['bookingData']['display_id'] =  $order->display_id;
            $this->bookingSMS($data, 3);

            return redirect()->back()->with('success', 'SMS sent successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry could not process.');
        }
    }

    public function updateSuccess(Request $request, $id)
    {
        try {
            $order = \App\Events\EventsBooking::findorFail($id);

            $bookinngType = \App\BirdsFest\birdFestPricings::findorFail($order->booking_type_id);

            if ($bookinngType->remaining_slots >= $order->number_of_tickets) {
                $decrementSlots = \App\BirdsFest\birdFestPricings::where('id',$order->booking_type_id)->decrement('remaining_slots',$order->number_of_tickets);
                $order->booking_status = 'Success';
                $order->save();
                return redirect()->back()->with('success', 'Updated successfully');

            }else{
                return redirect()->back()->with('error', 'No slots available');
            }


        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry could not process.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
