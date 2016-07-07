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
            ['type' => 0, 'name' => 'member', 'label' => 'Member'],
            ['type' => 1, 'name' => 'manage_users', 'label' => 'Manage Users'],
            ['type' => 1, 'name' => 'manage_role_permissions', 'label' => 'Manage Users Role\'s Permission'],
            ['type' => 1, 'name' => 'manage_backups', 'label' => 'Manage Database Backups'],
            ['type' => 1, 'name' => 'manage_options', 'label' => 'Manage Site Options'],
        ]);
    }
}
