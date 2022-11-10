<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trip::create(['vehicle_id' => '1', 'route_id' => '2','date' => '2022-05-25','rate' => '32000','status' => 'Started', 'latitude' => '33.6665', 'longitude' => '73.0516', 'notify_start' => '1']);

        Trip::create(['vehicle_id' => '2', 'route_id' => '1','date' => '2022-05-28','rate' => '62000','status' => 'In Queue']);
        
        Trip::create(['vehicle_id' => '3', 'route_id' => '3','date' => '2022-04-22','rate' => '22000','status' => 'Completed', 'notify_complete' => '1']);
    }
}