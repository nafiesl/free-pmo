<?php

use Illuminate\Database\Seeder;

class UsersRoleTableSeeder extends Seeder
{
    private $tableToSeed = 'role_user';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->tableToSeed)->truncate();
        DB::table($this->tableToSeed)->insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 2],
        ]);
    }
}
