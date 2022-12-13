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
        //Super Admin User
        $super_admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@wizz.com',
            'color' => '#FFFFFF',
            'password' => Hash::make('superadmin123'),
        ]);

        $super_admin->assignRole('Super Admin');

        //Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@wizz.com',
            'color' => '#f302cd',
            'password' => Hash::make('admin123'),
        ]);

        $admin->assignRole('Admin');

        //Officer User
        $officer = User::create([
            'name' => 'Officer',
            'email' => 'officer@wizz.com',
            'color' => '#E09946',
            'password' => Hash::make('officer123'),
        ]);

        $officer->assignRole('Officer');

        //Driver User
        $driver = User::create([
            'name' => 'Driver',
            'email' => 'driver@wizz.com',
            'color' => '#96fb00',
            'password' => Hash::make('driver123'),
        ]);

        $driver->assignRole('Driver');

        //User
        $user = User::create([
            'name' => 'User',
            'email' => 'user@wizz.com',
            'color' => '#3600e2',
            'password' => Hash::make('user123'),
        ]);

        $user->assignRole('User');

        //Vendor
        $vendor = User::create([
            'name' => 'Vendor',
            'email' => 'vendor@wizz.com',
            'color' => '#00f2fc',
            'password' => Hash::make('vendor123'),
        ]);

        $vendor->assignRole('Vendor');
    }
}