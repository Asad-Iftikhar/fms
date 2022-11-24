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
            array('name' => 'manage_events', 'description' => 'Manage Events, Add , Update and Delete', 'created_at' => date( 'Y-m-d H:i:s' ), 'updated_at' => date( 'Y-m-d H:i:s' )),
        ) );


        $user_id = DB::table( 'users' )->insertGetId( array(
            'username' => 'saadaan_ali',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'saadaan.ali@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Saadaan',
            'last_name' => 'Ali'
        ) );
        DB::table( 'role_user' )->insert( array(
            'role_id' => $role_id,
            'user_id' => $user_id,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'abdul_hannan',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'abdul.hanan@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1999-07-23' ),
            'gender' => 'male',
            'first_name' => 'Abdul',
            'last_name' => 'Hannan'
        ) );
        $user_id = DB::table( 'role_user' )->insert( array(
            'role_id' => $role_id,
            'user_id' => $user_id,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'anees_muhammad',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'anees.muhammad@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Anees',
            'last_name' => 'Muhammad'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'arif_muhammad',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'arif.muhammad@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Arif',
            'last_name' => 'Muhammad'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'asim_shahzad',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'asim.shahzad@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Asim',
            'last_name' => 'Shahzad'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'raja_rizwan',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'raja.rizwan@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Raja',
            'last_name' => 'Rizwan'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'faisal_shahzad',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'faisal.shahzad@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Faisal',
            'last_name' => 'Shahzad'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'tariq_abbasi',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'tariq.abbasi@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Tariq',
            'last_name' => 'Abbasi'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'yasir_rehman',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'yasir.rehman@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Yasir',
            'last_name' => 'Rehman'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'sohail_maroof',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'sohail.maroof@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Sohail',
            'last_name' => 'Maroof'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'haroon_khan',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'haroon.khan@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Haroon',
            'last_name' => 'Khan'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'ishaq_zahoor',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'ishaq.zahoor@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Ishaq',
            'last_name' => 'Zahoor'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'zia_tariq',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'zia.tariq@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Zia',
            'last_name' => 'Tariq'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'shahzaib_khan',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'shahzaib.khan@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Shahzaib',
            'last_name' => 'Khan'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'ahmad_ali',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'ahmad.ali@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Ahmad',
            'last_name' => 'Ali'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'arslan_azhar',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'arslan.azhar@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Arslan',
            'last_name' => 'Azhar'
        ) );
        $user_id = DB::table( 'users' )->insertGetId( array(
            'username' => 'syeda_quratulain',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'syeda.quratulain@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'female',
            'first_name' => 'Syeda',
            'last_name' => 'Qurat-ul-ain'
        ) );
        DB::table( 'role_user' )->insert( array(
            'role_id' => $role_id,
            'user_id' => $user_id,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ) );
        $user_id = DB::table( 'users' )->insertGetId( array(
            'username' => 'asad_iftikhar',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'asad.iftikhar@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Asad',
            'last_name' => 'Iftikhar'
        ) );
        DB::table( 'role_user' )->insert( array(
            'role_id' => $role_id,
            'user_id' => $user_id,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' )
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'bushra_mushtaq',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'bushra.mushtaq@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'female',
            'first_name' => 'Bushra',
            'last_name' => 'Mushtaq'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'noreen_gul',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'noreen.gul@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'female',
            'first_name' => 'Noreen',
            'last_name' => 'Gul'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'abubakar_siddique',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'abubakar.siddique@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Abubakar',
            'last_name' => 'Siddique'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'taimoor_ali',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'taimoor.ali@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Taimoor',
            'last_name' => 'Ali'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'izaz_khan',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'izaz.khan@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Izaz',
            'last_name' => 'Khan'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'sajjad_hussain',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'sajjad.hussain@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Sajjad',
            'last_name' => 'Hussain'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'aziz_hassan',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'aziz.hassan@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Aziz',
            'last_name' => 'Hassan'
        ) );
        DB::table( 'users' )->insertGetId( array(
            'username' => 'ali_hasnain',
            'password' => bcrypt( 'fms12345' ),
            'email' => 'ali.hasnain@nxb.com.pk',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'activated' => 1,
            'disabled' => 0,
            'dob' => date( '1998-10-12' ),
            'gender' => 'male',
            'first_name' => 'Ali',
            'last_name' => 'Hasnain'
        ) );
    }
}
