<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserSubscription;

class UserSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserSubscription::create([
            "user_id" => '2',
            "subscription_id" => '1',
            "start_date" => '2022-10-1',
            "end_date" => '2022-11-1',
            "remaining_weight" => '100',
            "status" => 'Subscribed',
            "notify_subscribed" => '1'
        ]);
    
        UserSubscription::create([
            "user_id" => '4',
            "subscription_id" => '2',
            "start_date" => '2022-09-1',
            "end_date" => '2022-10-1',
            "remaining_weight" => '80',
            "status" => 'Subscribed',
            "notify_subscribed" => '1'
        ]);

        UserSubscription::create([
            "user_id" => '5',
            "subscription_id" => '3',
            "start_date" => '2022-08-1',
            "end_date" => '2022-09-1',
            "remaining_weight" => '60',
            "status" => 'Expired',
            "notify_subscribed" => '0'
        ]);

        UserSubscription::create([
            "user_id" => '6',
            "subscription_id" => '1',
            "start_date" => '2022-07-1',
            "end_date" => '2022-08-1',
            "remaining_weight" => '50',
            "status" => 'Expired',
            "notify_subscribed" => '0'
        ]);
    }
}