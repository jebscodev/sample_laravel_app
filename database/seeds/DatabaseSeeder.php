<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            ModulesTableSeeder::class,
            RoleModuleTaggingTableSeeder::class,
            UnitTypesTableSeeder::class,
            ProcessingDaysTableSeeder::class,
            OtherChargesTableSeeder::class,
            EquityPercentagesTableSeeder::class,
            MonthsToPaysTableSeeder::class
        ]);
    }
}
