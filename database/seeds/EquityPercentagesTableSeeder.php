<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquityPercentagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equity_percentages')->insert([
            [
                'percentage' => 10.0, 
                'description' => '10-90 scheme', 
                'created_by' => 1, 
                'updated_by' => 1
            ],
            [
                'percentage' => 15.0,
                'description' => '15-85 scheme',  
                'created_by' => 1, 
                'updated_by' => 1
            ],
            [
                'percentage' => 20.0, 
                'description' => '20-80 scheme',
                'created_by' => 1, 
                'updated_by' => 1
            ]
        ]);
    }
}
