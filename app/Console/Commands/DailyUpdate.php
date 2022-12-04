<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\UserSubscription;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all deadlines, update statuses and send emails.';

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
        //Confirmed Order to Unpaid if not paid in 3 days
        $ConfirmedOrders = Order::whereNull('paid_invoice')->where('status', 'Confirmed')->get();

        foreach ($ConfirmedOrders as $order) {
            if (Carbon::parse($order->created_at)->diffInDays(Carbon::now()) == 3) {
                $order->update([
                    'status' => 'Unpaid'
                ]);
            }
        }

        //Changing Subscription status of user
        $SubscriptionExpired = UserSubscription::where('status', 'Subscribed')->get();

        foreach ($SubscriptionExpired as $user_subscription) {
            if(Carbon::parse($user_subscription->end_date)->diffInDays(Carbon::now()) == 0){
                $user_subscription->update([
                    'status' => 'Expired',
                    'remaining_weight' => '0'
                ]);
            }
        }

        //Sending Subscription about to expire email one day before expiration date!
        $SubscriptionExpirationReminder = UserSubscription::where('status', 'Subscribed')->get();

        foreach ($SubscriptionExpirationReminder as $user_subscription) {
            if(Carbon::parse($user_subscription->end_date)->diffInDays(Carbon::now()) == 1){
                $data = array(
                'email' => $user_subscription->user->email,
                'name' => $user_subscription->user->name,
                'user_subscription' => $user_subscription);
                    
                Mail::send('emails.subscription_one_day_expiration', $data,
                function($message) use($data){
                    $message->to($data['email'], $data['name'])
                    ->subject('Subscription Expiration | One Day Remaining');
                    $message->from('donotreply@wizz.com','Wizz Logistics');
                });
            }
        }

        $this->info('All Notification Sent!');
    }
}
