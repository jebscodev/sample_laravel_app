<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_types')->insert([
            [
                'name' => 'Studio Unit',
                'description' => 'Studio Type',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'name' => '1BR Unit',
                'description' => 'One Bedroom Type',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        ]);
    }
}
