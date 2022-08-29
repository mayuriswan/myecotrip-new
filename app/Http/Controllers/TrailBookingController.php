<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TrailBookingController extends Controller
{
    public function sendOldMail(Request $request, $date)
    {
    	$bookingsOFTheDate = \App\TrailBooking::whereDate('date_of_booking','=',$date)->where('booking_status',"Success")
                ->orderBy('id', 'DESC')
                ->get()
                ->toArray();

        // echo "<pre>";print_r($getTodaysBooking);exit();
        $mailList = [];
        foreach ($bookingsOFTheDate as $key => $value) {
        	
    		$bookingData = $value;
        	$trailData = \App\Trail::where('id',$value['trail_id'])->get()->toArray();

        	// user mail
        	$userData = \App\User::where('id',$value['user_id'])->select('email')->get()->toArray();
        	$userEmail = $userData[0]['email'];
            $mailList[] = $userEmail;
            
        	$message = \View::make('payment.trailMailTemplate', ['bookingData' => $bookingData, 'trailData' => $trailData[0]]);

	        $subject = "Ecotrail booking confirmation";
	        $headers = "MIME-Version: 1.0" . "\r\n";
	        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	        $headers .= "Bcc:myecotrip17@gmail.com" . "\r\n";

	        // More headers
	        $headers .= 'From: <support@myecotrip.com>' . "\r\n";

	        mail($userEmail,$subject,$message,$headers);
	        // return view('payment/success', ['userEmail'=> $userEmail]);
        }

        echo "<pre>";print_r($mailList);
    }

    public function testMail(Request $request){
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Bcc:myecotrip17@gmail.com" . "\r\n";

        // More headers
        $headers .= 'From: <support@myecotrip.com>' . "\r\n";

        echo mail('vinayan17@gmail.com','Ticket','So what makes you want to take that extra step to actually open an email? Often, it\'s the subject line. After all, it\'s your very first impression of the email -- and from it, you\'ll do your best to judge the content on the inside.',$headers);
    }
}
