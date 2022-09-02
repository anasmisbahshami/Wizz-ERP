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
        ]);

        $super_admin = Role::create(['name' => 'Super Admin',
                                        'description' => 'This Role has Complete Authority, Not Modifiable',    
        ]);
        User::find(1)->assignRole($super_admin);

        $admin = Role::create(['name' => 'Admin',
                            'description' => 'This is the role with custom permissions',        
        ]);

        // $po_owner->syncPermissions(['Edit Employee',
        //                             'View Supplier',
        //                             'Add Supplier',
        //                             'Edit Supplier',
        //                             'Delete Supplier',
        //                             'View Client',
        //                             'Add Client',
        //                             'Edit Client',
        //                             'Delete Client',
        //                             'View RFQ', 
        //                             'Add RFQ',
        //                             'Edit RFQ', 
        //                             'Delete RFQ', 
        //                             'View PO', 
        //                             'Add PO',
        //                             'Edit PO', 
        //                             'Delete PO',
        //                             'View Report',
        // ]);
        
        // $faker = Faker::create();
    	// foreach (range(1,50) as $index) {
        //     $user = User::create([
        //         'name' => $faker->name,
        //         'email' => $faker->email,
        //         'password' => Hash::make('password123'),
        //     ]);

        //     $user->assignRole($po_owner);
        // }
    }
}
