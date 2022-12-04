<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create(['name' => 'Bronze','description' => 'Nation Wide Delivery, Weight Upto 50 Kg, 30 Days Validation','price' => '2000','weight' => '50']);
        Subscription::create(['name' => 'Silver','description' => 'Nation Wide Delivery, Weight Upto 80 Kg, 30 Days Validation','price' => '3000','weight' => '80']);
        Subscription::create(['name' => 'Gold','description' => 'Nation Wide Delivery, Weight Upto 100 Kg, 30 Days Validation','price' => '5000','weight' => '100']);
    }
}