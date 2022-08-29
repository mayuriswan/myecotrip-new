<?php

namespace App\Http\Middleware;

use Closure;
use App\Events\LoggingEvent;
class BeforeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // echo url('/');exit;
        // foreach (getallheaders() as $name => $value)
        //     {
        //         if ($name == 'Cookie')
        //             continue;
        //         $json[$name] = $value;
        //     }

        // $req_str = '[' . $request->ip() . '][' . json_encode($json) . '] -> ' . $request->method() . ' ' . $request->path() . json_encode($request->query()) . $request->getContent() . "\n";

        // \Event::fire(new LoggingEvent("REQ", $req_str));

        // echo "string";exit();

        //trekking - Check if any booking has taken too long n release the seats
        $getTheWaitingRows = \App\TrailBooking::where('booking_status','Waiting')
                            ->get()
                            ->toArray();

        foreach ($getTheWaitingRows as $key => $row) {
            $datetime1 = strtotime($row['date_of_booking']);
            $datetime2 = strtotime(date("Y-m-d H:i:s"));
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);

            // if min is more than 15 change to cancelledByMyecotrip
            if ($minutes >= 30) {
                $updateContent = array();
                $updateContent['booking_status'] = 'cancelledByMyecotrip';
                $updateContent['gatewayResponse'] = "Payment delayed by $minutes min";

                $updateBookingStatus = \App\TrailBooking::where('id',$row['id'])
                ->update($updateContent);
            }
        }
        // ------------------- Ecotrail booking ------------------

        // JungleStay booking
        $getTheWaitingRows = \App\JungleStay\Booking::where('booking_status','Waiting')
                            ->get()
                            ->toArray();

        foreach ($getTheWaitingRows as $key => $row) {
            $datetime1 = strtotime($row['date_of_booking']);
            $datetime2 = strtotime(date("Y-m-d H:i:s"));
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);

            // if min is more than 15 change to cancelledByMyecotrip
            if ($minutes >= 30) {
                $updateContent = array();
                $updateContent['booking_status'] = 'cancelledByMyecotrip';
                $updateContent['gateway_response'] = "Payment delayed by $minutes min";

                $updateBookingStatus = \App\JungleStay\Booking::where('id',$row['id'])
                                      ->update($updateContent);
                //Booking details
                \App\JungleStay\BookingDetail::where('booking_id',$row['id'])
                                        ->update(['booking_status' => 'cancelledByMyecotrip']);
            }

        }

        // Safari booking
        // $getTheWaitingRows = \App\Safari\SafariBookings::where('booking_status','Waiting')
        //                     ->get()
        //                     ->toArray();

        // foreach ($getTheWaitingRows as $key => $row) {
        //     $datetime1 = strtotime($row['date_of_booking']);
        //     $datetime2 = strtotime(date("Y-m-d H:i:s"));
        //     $interval  = abs($datetime2 - $datetime1);
        //     $minutes   = round($interval / 60);

        //     // if min is more than 15 change to cancelledByMyecotrip
        //     if ($minutes >= 15) {
        //         $updateContent = array();
        //         $updateContent['booking_status'] = 'cancelledByMyecotrip';
        //         $updateContent['gateway_response'] = "Payment delayed by $minutes min";

        //         $updateBookingStatus = \App\Safari\SafariBookings::where('id',$row['id'])
        //         ->update($updateContent);

        //         $update['booking_status'] = "cancelledByMyecotrip";
        //         $updateCorrespondingEntries = \App\Safari\SafariBookingEntries::where('display_id',$row['display_id'])->update($update);
        //     }
        // }

        // Bird event booking
        $getTheWaitingRows = \App\Events\EventsBooking::where('booking_status','Waiting')
                            ->get()
                            ->toArray();

        foreach ($getTheWaitingRows as $key => $row) {
            $datetime1 = strtotime($row['date_of_booking']);
            $datetime2 = strtotime(date("Y-m-d H:i:s"));
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);

            // if min is more than 15 change to cancelledByMyecotrip
            if ($minutes >= 15) {
                $updateContent = array();
                $updateContent['booking_status'] = 'cancelledByMyecotrip';
                $updateContent['gatewayResponse'] = "Payment delayed by $minutes min";

                $updateBookingStatus = \App\Events\EventsBooking::where('id',$row['id'])
                ->update($updateContent);
            }
        }


        //Deleting old Qr codes
        $fileLists = scandir(public_path()."/assets/img/qrcodes", 1);
        $currentTime = time();

        foreach ($fileLists as $key => $value) {
            if (strpos($value, '.png') !== false) {
                $createdTime = (int) str_replace(".png","",$value);

                // If QR code is created more than 15 min
                if ($currentTime - $createdTime >= 900) {
                    unlink(public_path()."/assets/img/qrcodes/".$value);
                }

            }
        }

        return $next($request);
    }
}
