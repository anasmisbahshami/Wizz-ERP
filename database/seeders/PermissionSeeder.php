<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['name' => 'Add Role','guard_name' => 'web',],
            ['name' => 'View Role','guard_name' => 'web',],
            ['name' => 'Edit Role','guard_name' => 'web',],
            ['name' => 'Delete Role','guard_name' => 'web',],

            ['name' => 'Add User','guard_name' => 'web',],
            ['name' => 'View User','guard_name' => 'web',],
            ['name' => 'Edit User','guard_name' => 'web',],
            ['name' => 'Delete User','guard_name' => 'web',],

            ['name' => 'Add Vehicle','guard_name' => 'web',],
            ['name' => 'View Vehicle','guard_name' => 'web',],
            ['name' => 'Edit Vehicle','guard_name' => 'web',],
            ['name' => 'Delete Vehicle','guard_name' => 'web',],

        ]);

        //Super Admin
        $super_admin = Role::create(['name' => 'Super Admin', 'description' => 'This Role has Complete Authority, Not Modifiable.' ]);
        User::find(1)->assignRole($super_admin);

        //Admin
        $admin = Role::create(['name' => 'Admin', 'description' => 'This is the role for admin users.' ]);
        User::find(2)->assignRole($admin);

        //Officer
        $officer = Role::create(['name' => 'Officer', 'description' => 'This is the role for office users.' ]);
        User::find(3)->assignRole($officer);

        //Driver
        $driver = Role::create(['name' => 'Driver', 'description' => 'This is the role for drivers.' ]);
        User::find(4)->assignRole($driver);

        //User
        $user = Role::create(['name' => 'User', 'description' => 'This is the role for application users.' ]);
        User::find(5)->assignRole($user);

        //Vendor
        $vendor = Role::create(['name' => 'Vendor', 'description' => 'This is the role for vendors.' ]);
        User::find(6)->assignRole($vendor);
    }
}
