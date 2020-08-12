<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'department_id' => '1',
            'name' => 'drc',
            'email' => 'test1@qq.com',
            'password' => bcrypt('drc123'),
        ]);
        DB::table('users')->insert([
            'department_id' => '2',
            'name' => 'red',
            'email' => 'red@qq.com',
            'password' => bcrypt('red123'),
        ]);
    }
}
