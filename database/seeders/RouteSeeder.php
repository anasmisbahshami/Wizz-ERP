<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Route::create(['name' => 'Islamabad - Karachi', 'rate' => '45000','source' => 'Islamabad','destination' => 'Karachi']);

        Route::create(['name' => 'Lahore - Faisalabad', 'rate' => '25000','source' => 'Lahore','destination' => 'Karachi']);

        Route::create(['name' => 'Peshawar - Bannu', 'rate' => '18000','source' => 'Peshawar','destination' => 'Bannu']);

        Route::create(['name' => 'Quetta - Waziristan', 'rate' => '55000','source' => 'Quetta','destination' => 'Waziristan']);
    }
}