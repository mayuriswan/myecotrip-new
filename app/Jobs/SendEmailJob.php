<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendMailable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Users 
        // $getUsers = \App\User::where('email_verified',1)->get()->toArray();

        // // echo "<pre>"; print_r($getUsers); exit;
        // $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);


        // for ($i=0; $i < count($getUsers) ; $i++) {
        //     \Log::info(date("Y-m-d H:m:s"). ' '. $getUsers[$i]['id'].' '. $getUsers[$i]['email']);

        //     $user = $getUsers[$i];

        //     $beautymail->send('marketing::Mail/birdfest2020', [], function($message) use($user)
        //     {
        //         $message->from('support@myecotrip.com', 'Myecotrip')
        //             ->to($user['email'], $user['first_name']. ' ' .$user['last_name'])
        //             ->subject('Bird Festival 2020 - 17th, 18th and 19th of January');
        //     });

        //     if ($i%10 == 0) {
        //         sleep(10);
        //     }
        // }

        // ------ VTP ------
        // $getUsers = \App\VTPList::where('status',1)->get()->toArray();

        // // echo "<pre>"; print_r($getUsers); exit;
        // $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

        // for ($i=0; $i < count($getUsers) ; $i++) {
        //     $user = $getUsers[$i];

        //     $beautymail->send('marketing::Mail/birdfest2020', [], function($message) use($user)
        //     {
            
        //         $email = $user['email'];
        //         \Log::info(date("Y-m-d H:m:s").' '. $user['email']);

        //         try {
        //             if (filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        //                 //Validate the email format
        //                 $message->from('support@myecotrip.com', 'Myecotrip')
        //                     ->to($email, '')
        //                     ->subject('Bird Festival 2020 - 17th, 18th and 19th of January');
        //             }

        //         }catch (Throwable $e) {
        //             \Log::info(date("Y-m-d H:m:s"). $user['email'].'  Not Sent');
        //         }
        //     });


        //     if ($i%10 == 0) {
        //         sleep(10);
        //     }
                
        // }

        // ---------- Subscribe ----------
        $getUsers = \App\Subscribe::where('status',1)->get()->toArray();

        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

        for ($i=0; $i < count($getUsers) ; $i++) {
            $user = $getUsers[$i];

            $beautymail->send('marketing::Mail/birdfest2020', [], function($message) use($user)
            {
            
                $email = $user['email'];
                \Log::info(date("Y-m-d H:m:s").' '. $user['email']);

                try {
                    if (filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
                        //Validate the email format
                        $message->from('support@myecotrip.com', 'Myecotrip')
                            ->to($email, '')
                            ->subject('Bird Festival 2020 - 17th, 18th and 19th of January');
                    }

                }catch (Throwable $e) {
                    \Log::info(date("Y-m-d H:m:s"). $user['email'].'  Not Sent');
                }
            });


            if ($i%10 == 0) {
                sleep(10);
            }
                
        }



    }
}
