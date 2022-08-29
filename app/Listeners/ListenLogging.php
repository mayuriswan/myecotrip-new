<?php

namespace App\Listeners;

use App\Events\LoggingEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenLogging
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoggingEvent  $event
     * @return void
     */
    public function handle(LoggingEvent $event)
    {
       $date = date('Y-m-d');
       $file = storage_path() . '/logs/access-' . $date . '.log';
       if (!file_exists($file))
         {
           touch($file);
         }
       // if (is_array($event->logs))
       //     $event->logs = print_r($event->logs, TRUE);

       $logfile  = fopen($file, 'a');
       $data_str = '[' . date('Y-m-d:H:i:s') . '] ' . $event->logs;

       if ($event->log_level == 'RSP')
       $data_str .= "\n\n";
       
       fwrite($logfile, $data_str);
       fclose($logfile);
       return 1;
    }
}
