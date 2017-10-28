<?php

use Illuminate\Database\Seeder;

class UserRolesPermissionsTableSeeder extends Seeder
{
    private $tableToSeed = 'roles_permissions';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->tableToSeed)->truncate();
        DB::table($this->tableToSeed)->insert([
            ['type' => 0, 'name' => 'admin', 'label' => 'Admin'],
            ['type' => 0, 'name' => 'worker', 'label' => 'Worker'],
        ]);
    }
}
