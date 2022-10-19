<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Add calls to Seeders here
        // Base User related entries
        $this->call( UsersTablesSeeder::class );
        // Collection Types
        // Add calls to Seeders here
        $this->call( FundingTypesTableSeeder::class );


        for($i=0; $i<15; $i++){
            $email = 'admin'.$i.'@fms.com';
            $user_id = DB::table( 'users' )->insertGetId( array(
                'username' => 'fms_admin'.$i,
                'password' => bcrypt( 'fms12345' ),
                'email' => $email,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'updated_at' => date( 'Y-m-d H:i:s' ),
                'activated' => 1,
                'disabled' => 0
            ) );
        }

    }
}
