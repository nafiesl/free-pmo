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
            ['type' => 0, 'name' => 'customer', 'label' => 'Customer'],
            ['type' => 0, 'name' => 'worker', 'label' => 'Worker'],
            ['type' => 0, 'name' => 'vendor', 'label' => 'Vendor'],
            ['type' => 1, 'name' => 'manage_users', 'label' => 'Manage Users'],
            ['type' => 1, 'name' => 'manage_role_permissions', 'label' => 'Manage Users Role\'s Permission'],
            ['type' => 1, 'name' => 'manage_backups', 'label' => 'Manage Database Backups'],
            ['type' => 1, 'name' => 'manage_options', 'label' => 'Manage Site Options'],
            ['type' => 1, 'name' => 'manage_projects', 'label' => 'Manage Projects'],
            ['type' => 1, 'name' => 'manage_payments', 'label' => 'Manage Payments'],
            ['type' => 1, 'name' => 'manage_subscriptions', 'label' => 'Manage Subscriptions'],
            ['type' => 1, 'name' => 'see_reports', 'label' => 'See Reports'],
        ]);
    }
}
