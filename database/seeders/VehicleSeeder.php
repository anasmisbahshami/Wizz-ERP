<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::create(['name' => 'ISUZU-7160', 'number_plate' => 'ISB-6532', 'ownership' => 'Company','gps_id' => 'GPS-6780', 'type' => 'HTV', 'driver_id' => '4']);

        Vehicle::create(['name' => 'MAZDA-2142', 'number_plate' => 'LHR-7543', 'ownership' => 'Company','gps_id' => 'GPS-3456', 'type' => 'HTV', 'driver_id' => '4']);

        Vehicle::create(['name' => 'FORD-8635', 'number_plate' => 'KHI-5364', 'ownership' => 'Company','gps_id' => 'GPS-6756', 'type' => 'HTV', 'driver_id' => '4']);

        Vehicle::create(['name' => 'BMW-6343', 'number_plate' => 'PES-0154', 'ownership' => 'Company','gps_id' => 'GPS-1355', 'type' => 'HTV', 'driver_id' => '4']);
    }
}
