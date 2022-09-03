<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@wizz-logistics.com',
            'password' => Hash::make('superadmin123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@wizz-logistics.com',
            'password' => Hash::make('admin123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Officer',
            'email' => 'officer@wizz-logistics.com',
            'password' => Hash::make('officer123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Driver',
            'email' => 'driver@wizz-logistics.com',
            'password' => Hash::make('driver123'),
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@wizz-logistics.com',
            'password' => Hash::make('user123'),
        ]);

        DB::table('users')->insert([
            'name' => 'Vendor',
            'email' => 'vendor@wizz-logistics.com',
            'password' => Hash::make('vendor123'),
        ]);
    }
}