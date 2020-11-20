<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtherChargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('other_charges')->insert([
            [
                'name' => 'Late Payment',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        ]);
    }
}
