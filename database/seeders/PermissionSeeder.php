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

            ['name' => 'Add Route','guard_name' => 'web',],
            ['name' => 'View Route','guard_name' => 'web',],
            ['name' => 'Edit Route','guard_name' => 'web',],
            ['name' => 'Delete Route','guard_name' => 'web',],

            ['name' => 'Add City','guard_name' => 'web',],

            ['name' => 'Add Subscription','guard_name' => 'web',],
            ['name' => 'View Subscription','guard_name' => 'web',],
            ['name' => 'Edit Subscription','guard_name' => 'web',],
            ['name' => 'Delete Subscription','guard_name' => 'web',],

            ['name' => 'Add User Subscription','guard_name' => 'web',],
            ['name' => 'View User Subscription','guard_name' => 'web',],
            ['name' => 'Edit User Subscription','guard_name' => 'web',],
            ['name' => 'Delete User Subscription','guard_name' => 'web',],
            ['name' => 'Renewal Mail User Subscription','guard_name' => 'web',],
            ['name' => 'Acknowledge User Subscription','guard_name' => 'web',],

            ['name' => 'Add Trip','guard_name' => 'web',],
            ['name' => 'View Trip','guard_name' => 'web',],
            ['name' => 'Edit Trip','guard_name' => 'web',],
            ['name' => 'Delete Trip','guard_name' => 'web',],
            ['name' => 'Acknowledge Trip','guard_name' => 'web',],
            ['name' => 'Edit Trip Status','guard_name' => 'web',],
            ['name' => 'GPS Coordinates Trip','guard_name' => 'web',],


            ['name' => 'View Bill','guard_name' => 'web',],
            ['name' => 'Generate Monthly Bill','guard_name' => 'web',],
            ['name' => 'Generate Monthly Range Bill','guard_name' => 'web',],
            ['name' => 'Generate Date Range Bill','guard_name' => 'web',],

            ['name' => 'Book Order','guard_name' => 'web',],
            ['name' => 'Track Order','guard_name' => 'web',],

            ['name' => 'View Order','guard_name' => 'web',],
            ['name' => 'Delete Order','guard_name' => 'web',],
            ['name' => 'Download Order Invoice','guard_name' => 'web',],
            ['name' => 'Acknowledge Order','guard_name' => 'web',],
            ['name' => 'View Order Details','guard_name' => 'web',],
            ['name' => 'Edit Order Details','guard_name' => 'web',],
                        
            ['name' => 'Add Job','guard_name' => 'web',],
            ['name' => 'View Job','guard_name' => 'web',],
            ['name' => 'Edit Job','guard_name' => 'web',],
            ['name' => 'Delete Job','guard_name' => 'web',],

            ['name' => 'View Job Application','guard_name' => 'web',],
            ['name' => 'Edit Job Application','guard_name' => 'web',],
            ['name' => 'Delete Job Application','guard_name' => 'web',],

            ['name' => 'View Job Applicant','guard_name' => 'web',],
            ['name' => 'Shortlist Job Applicant','guard_name' => 'web',],
            ['name' => 'Delete Job Applicant','guard_name' => 'web',],

            ['name' => 'View GPS','guard_name' => 'web',],
            ['name' => 'Track GPS','guard_name' => 'web',],

            
        ]);

        //Super Admin
        $super_admin = Role::create(['name' => 'Super Admin', 'description' => 'This Role has Complete Authority, Not Modifiable.' ]);
        User::find(1)->assignRole($super_admin);

        //Admin Role
        $admin = Role::create(['name' => 'Admin', 'description' => 'This is the role for admin users.' ]);
        
        //Admin Permissions
        $admin->syncPermissions([
        'Add User','View User','Edit User','Delete User',
        'Add Vehicle','View Vehicle','Edit Vehicle','Delete Vehicle',
        'Add Route','View Route','Edit Route','Delete Route',
        'Add User Subscription','View User Subscription','Edit User Subscription','Delete User Subscription','Renewal Mail User Subscription','Acknowledge User Subscription',
        'Add Trip','View Trip','Edit Trip','Delete Trip','Acknowledge Trip','Edit Trip Status','GPS Coordinates Trip',
        'View Bill','Generate Monthly Bill','Generate Monthly Range Bill','Generate Date Range Bill',
        'Add Job','View Job','Edit Job','Delete Job',
        'View Job Application','Edit Job Application','Delete Job Application',
        'View Job Applicant','Shortlist Job Applicant','Delete Job Applicant',
        'View GPS','Track GPS',
        'View Order','Delete Order','Download Order Invoice','Acknowledge Order','View Order Details','Edit Order Details','Add Subscription','View Subscription','Edit Subscription','Delete Subscription','Add City','Track Order']);

        //Assigning Permission To Admin Role
        // User::find(2)->assignRole($admin);

        //Officer Role
        $officer = Role::create(['name' => 'Officer', 'description' => 'This is the role for office users.' ]);
        
        //Officer Permissions
        $officer->syncPermissions(['Book Order','Track Order','View Order','Download Order Invoice','View Order Details','Edit Order Details']);        
        
        //Assigning Permission To Officer Role
        // User::find(3)->assignRole($officer);

        //Driver Role
        $driver = Role::create(['name' => 'Driver', 'description' => 'This is the role for drivers.' ]);

        //Driver Permissions
        // $driver->syncPermissions(['View Trip','Edit Trip Status','GPS Coordinates Trip']);

        //Assigning Permission To Driver Role
        // User::find(4)->assignRole($driver);

        //User Role
        $user = Role::create(['name' => 'User', 'description' => 'This is the role for application users.' ]);

        //User Permissions
        $user->syncPermissions(['View Order','View Order Details','Download Order Invoice', 'Acknowledge Order', 'Track Order', 'View Subscription']);

        //Assigning Permission To User Role
        // User::find(5)->assignRole($user);

        //Vendor
        $vendor = Role::create(['name' => 'Vendor', 'description' => 'This is the role for vendors.' ]);
        // User::find(6)->assignRole($vendor);
    }
}
