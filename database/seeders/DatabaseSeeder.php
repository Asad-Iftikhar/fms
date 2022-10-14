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

    }
}
