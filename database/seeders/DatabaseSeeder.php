<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            CitySeeder::class,
            RouteSeeder::class,
            VehicleSeeder::class,
            TripSeeder::class,
            SubscriptionSeeder::class,
            UserSubscriptionSeeder::class,
        ]);
    }
}
