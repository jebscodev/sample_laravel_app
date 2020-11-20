<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleModuleTaggingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 24; $i++) {
            $seed[] = [
                'role_id' => 1,
                'module_id' => $i,
                'read' => 1,
                'write' => 1,
                'update' => 1
            ];
        }

        DB::table('role_module_tagging')->insert($seed);
    }
}
