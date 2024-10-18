<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;


class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $setting = array();
        $app_data = GeneralSetting::where('setting_type','1')->get();
        foreach ($app_data as $row) {
            $setting[$row['setting_name']] = $row['filed_value'];
        }
        foreach ($this->details as $key => $value) {
            $image = $value['attachment'];
            $data = [
                'title' => $value['title'],
                'message' => $value['message']
            ];
            $fcm = [ 
                $value['fcm_id']
            ]; 
            firebaseNotification($fcm, $data, $setting, $image);
        }
    }
}
