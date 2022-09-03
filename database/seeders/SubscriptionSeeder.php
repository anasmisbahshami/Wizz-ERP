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
        Subscription::create(['name' => 'Gold','price' => '5000','weight' => '100']);
        Subscription::create(['name' => 'Silver','price' => '3000','weight' => '80']);
        Subscription::create(['name' => 'Bronze','price' => '2000','weight' => '50']);
    }
}