<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundingTypesTableSeeder extends Seeder
{

    public function run()
    {
        //Create Permissions
        DB::table('funding_types')->insert(array(
            array('name' => 'First Pay', 'description' => 'On Employee First Salary', 'amount' => 500, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
            array('name' => 'Confirmation', 'description' => 'Confirmation', 'amount' => 500, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
            array('name' => 'Promotion', 'description' => 'Promotion', 'amount' => 1000, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
            array('name' => 'Increment', 'description' => 'Increment', 'amount' => 1000, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
            array('name' => 'Bonus', 'description' => 'Bonus', 'amount' => 1000, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
            array('name' => 'Appreciation', 'description' => 'Appreciation', 'amount' => 200, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
            array('name' => 'Gift', 'description' => 'Gift', 'amount' => 1000, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
        ));

    }

}
