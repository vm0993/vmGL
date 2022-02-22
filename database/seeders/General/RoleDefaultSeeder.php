<?php

namespace Database\Seeders\General;

use Illuminate\Database\Seeder;

class RoleDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'owner']);
        $role->givePermissionTo(Permission::all());
    }
}
