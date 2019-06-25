<?php

namespace App\Jobs;

use App\Jobs\Job;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use ZendService\Google\Gcm\Response;

class sendPushNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $token;
    protected $message;
    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($token, $message, $user_id)
    {
        $this->token = $token;
        $this->message = $message;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the notification to the device with a token of $deviceToken
        $collection = PushNotification::app('orangeAndroid')
            ->to($this->token);
        $collection->adapter->setAdapterParameters(['sslverifypeer' => false]);

        $collection->send($this->message);

        foreach ($collection->pushManager as $push) {
            $success = $push->getAdapter()->getResponse()->getSuccessCount();
            if ($success == 0) {
                $response = $push->getAdapter()->getResponse()->getResult(Response::RESULT_ERROR);
                if (array_key_exists($this->token, $response)){
                    Log::error('[API v2] Error GCM Token  : '. $response[$this->token] . ' from user id ' . $this->user_id);
                }
            }
        }
    }
}
