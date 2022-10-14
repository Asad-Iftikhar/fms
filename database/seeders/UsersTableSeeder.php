<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTablesSeeder extends Seeder {

    public function run() {
        //Default Roles
        $role_id = DB::table( 'roles' )->insertGetId( array(
            'name' => 'super_admin',
            'level' => 10,
            'description' => 'This role has all permissions by default',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ) );

        DB::table( 'roles' )->insert( array(
            array('name' => 'client_admin', 'description' => 'Client Member with Admin Access', 'level' => 9, 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'client', 'description' => 'Normal Client Access', 'level' => 5, 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
        ) );

        $email = 'admin@fms.com';
        $user_id = DB::table( 'users' )->insertGetId( array(
            'username' => 'fms_admin',
            'password' => bcrypt( 'fms12345' ),
            'email' => $email,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0
        ) );

        DB::table( 'role_user' )->insert( array(
            'role_id' => $role_id,
            'user_id' => $user_id,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ) );

        //Create Permissions
        DB::table( 'permissions' )->insert( array(
            array('name' => 'admin', 'description' => 'Can Access Admin Section', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'manage_users', 'description' => 'Manage Users. Create, Edit,  and Delete Members', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'manage_roles', 'description' => 'Manage Member Roles', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'manage_funding_types', 'description' => 'Manage Funding Types', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'manage_funding_collections', 'description' => 'Manage Funding Collections', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'manage_permissions', 'description' => 'Manage Permissions & Assign Permissions to User Roles', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'manage_menus', 'description' => 'Can Manage Site Menus', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
            array('name' => 'manage_settings', 'description' => 'Manage Site Settings. Change Site Logo', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
        ) );

    }

}