<?php

namespace Database\Seeders;

use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PositionsSeeder;
use Database\Seeders\StaffSeeder;
use Database\Seeders\UserSeeder;
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
            DepartmentSeeder::class,
            PositionsSeeder::class,
            StaffSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
