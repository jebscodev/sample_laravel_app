<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessingDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('processing_days')->insert([
            [
                'name' => 'Reservation',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'name' => 'After Notice Sent',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        ]);
    }
}
