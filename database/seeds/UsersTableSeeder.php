<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $tableToSeed = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->tableToSeed)->truncate();
        DB::table($this->tableToSeed)->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@app.dev',
                'password' => bcrypt('admin'),
                'remember_token' => str_random(10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Customer',
                'email' => 'member@app.dev',
                'password' => bcrypt('member'),
                'remember_token' => str_random(10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
