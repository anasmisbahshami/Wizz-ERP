<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
        $json = File::get("database/data/pk.json");
        $cities = json_decode($json);
  
        foreach ($cities as $city) {
            City::create([
                "name" => $city->city,
                "latitude" => $city->lat,
                "longitude" => $city->lng,
            ]);
        }
    }
}