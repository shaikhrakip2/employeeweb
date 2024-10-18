<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NewsletterMail;
use App\Models\NewsLetter;
use Mail;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Config;


class NewsletterMailJob implements ShouldQueue
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
        $All_users=NewsLetter::whereNull('deleted_at')->get()->toArray();
        $setting = array();
        $app_data = GeneralSetting::where('setting_type','2')->get();
        foreach ($app_data as $row) {
            $setting[$row['setting_name']] = $row['filed_value'];
        }
         Config::set("mail.mailers.smtp", [
            'transport'     => 'smtp',
            'host'          => $setting['smtp_host'],
            'port'          => $setting['smtp_port'],
            'encryption'    => in_array((int) $setting['smtp_port'], [587, 2525]) ? 'tls' : 'ssl',
            'username'      => $setting['smtp_user'],
            'password'      => $setting['smtp_pass'],
            'timeout'       =>  null,
            'auth_mode'     =>  null,
        ]);

        foreach ($All_users as $key => $value) {
            $detail = [];
            $detail['user'] = $value['email'];
            $detail['subject'] = $this->details['subject'];
            $detail['message'] = $this->details['message'];

            try{
                Mail::to($value['email'])->send(new NewsletterMail($detail)); 
            }
            catch(\Exception $e){
                dd($e);
            }
        }

    }
}
