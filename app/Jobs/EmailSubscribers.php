<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EmailSubscribers implements ShouldQueue
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
        $getUsers = \App\Subscribe::where('status',1)->get()->toArray();

        // echo "<pre>"; print_r($getUsers); exit;
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

        $beautymail->send('marketing::Mail/birdfest2020', [], function($message) use($getUsers)
        {
            for ($i=0; $i < count($getUsers) ; $i++) {
                    $email = $getUsers[$i]['email'];
                    \Log::info(date("Y-m-d H:m:s").' '. $getUsers[$i]['email']);

            try {
                    if (filter_var($getUsers[$i]['email'], FILTER_VALIDATE_EMAIL)) {
                        //Validate the email format
                        $message->from('support@myecotrip.com', 'Myecotrip')
                            ->to($email, '')
                            ->subject('Bird Festival 2020 - 17th, 18th and 19th of January');
                    }

                }catch (Throwable $e) {
                    \Log::info(date("Y-m-d H:m:s"). $getUsers[$i]['email'].'  Not Sent');
                }
            }

        });
    }
}
