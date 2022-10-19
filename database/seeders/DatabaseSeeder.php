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

        $event_id = DB::table( 'events' )->insertGetId( array(
            'name' => 'Birthday Party',
            'description' => ( 'Party arranged in new york ' ),
            'event_cost' => 4000,
            'created_by' => $user_id,
            'event_date' => date( 'Y-m-d H:i:s' ),
            'payment_mode' => 1,
            'cash_by_funds' => 4000,
            'status' => 'finished',
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' ),
        ) );

        $collections_id = DB::table( 'funding_collections' )->insertGetId( array(
            'user_id' => $user_id,
            'funding_type_id' => 1,
            'amount' => 24000,
            'is_received' => 1,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' ),
        ) );

    }
}
