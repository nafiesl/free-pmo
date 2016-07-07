<?php

use Illuminate\Database\Seeder;

class RolesPermissionTableSeeder extends Seeder
{
    private $tableToSeed = 'user_role_permission';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->tableToSeed)->truncate();
        DB::table($this->tableToSeed)->insert([
            ['role_id' => 1, 'permission_id' => 3],
            ['role_id' => 1, 'permission_id' => 4],
            ['role_id' => 1, 'permission_id' => 5],
            ['role_id' => 1, 'permission_id' => 6],
        ]);
    }
}
