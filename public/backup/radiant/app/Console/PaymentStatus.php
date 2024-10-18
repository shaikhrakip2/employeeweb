<?php

namespace App\Console\Commands;

use App\Models\GeneralSetting;
use Illuminate\Console\Command;
use App\Models\UserPlanLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class PaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:payment_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription Payment Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $GeneralSetting     = new GeneralSetting();
        $razor_key_data     = $GeneralSetting->get_general_settings('razorpay_key_id')->first();
        $secret_key_data    = $GeneralSetting->get_general_settings('razorpay_secret_key')->first();
        
        $razor_key  = $razor_key_data->filed_value??Null;
        $secret_key = $secret_key_data->filed_value??Null;
         
        // Update package payment status if not clear
        $purchased_packages = BookingInquiry::where('payment_status', 0)->whereBetween('payment_date', [Carbon::now()->subDay()->toDateString(), Carbon::now()->toDateString()])->get();
        
        if (count($purchased_packages) > 0) {
            foreach ($purchased_packages as $key => $value) {
                $api = new Api($razor_key, $secret_key);

                try {
                    $payment = $api->order->fetch($value->razorpay_order_id)->payments();
 						
				   if (!empty($payment) && ($payment->count > 0) && ($payment->items[0]->status == 'captured')) { 
                    BookingInquiry::where(['id' => $value->id])->update([
                            'transaction_id'    => $payment->items[0]->id,
                            'payment_status'    => 1,
                        ]);
                    }
                } catch (\Throwable $th) {
                   /// prd($th);
                }
            }
        }
        
        Log::info("Subscription Payment Status Cron Run Successfully.");
        return Command::SUCCESS;
    }
}
