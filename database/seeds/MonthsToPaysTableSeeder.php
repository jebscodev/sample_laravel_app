<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthsToPaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('months_to_pays')->insert([
            [
                'no_of_months' => 12,
                'description' => '12 months to pay', 
                'discount' => 7.0, 
                'created_by' => 1, 
                'updated_by' => 1
            ],
            [
                'no_of_months' => 18,
                'description' => '18 months to pay', 
                'discount' => 5.0, 
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'no_of_months' => 24,
                'description' => '24 months to pay', 
                'discount' => 0.0,
                'created_by' => 1, 
                'updated_by' => 1
            ]
        ]);
    }
}
