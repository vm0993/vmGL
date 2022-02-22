<?php

namespace Database\Seeders;

use Database\Seeders\Custom\CustomPermissionSeeder;
use Database\Seeders\Custom\RoleDefaultSeeder;
use Illuminate\Database\Seeder;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomPermissionSeeder::class);
        $this->call(RoleDefaultSeeder::class);
    }
}
