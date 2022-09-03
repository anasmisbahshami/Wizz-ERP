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
        Trip::create(['vehicle_id' => '1', 'route_id' => '2','date' => '2022-05-25','rate' => '32000']);

        Trip::create(['vehicle_id' => '2', 'route_id' => '1','date' => '2022-05-28','rate' => '62000']);
        
        Trip::create(['vehicle_id' => '3', 'route_id' => '3','date' => '2022-04-22','rate' => '22000']);
        
        Trip::create(['vehicle_id' => '4', 'route_id' => '4','date' => '2022-03-21','rate' => '12000']);
    }
}