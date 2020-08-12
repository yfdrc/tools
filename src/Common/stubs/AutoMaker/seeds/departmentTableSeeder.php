<?php

use Illuminate\Database\Seeder;

class departmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('departments')->insert([
            'parent_id' => null,
            'name' => '总公司',
            'description' => '用于管理各店铺',
            'telephone' => '138*****',
            'email' => 'zf@qq.com',
            'address' =>'总公司地址',
        ]);
        DB::table('departments')->insert([
            'parent_id' => 1,
            'name' => 'xx分公司',
            'description' => '用于管理分公司各店铺',
            'telephone' => '138*****',
            'email' => 'test1@qq.com',
            'address' =>'分公司地址',
        ]);
        DB::table('departments')->insert([
            'parent_id' => 2,
            'name' => 'xx分公司01店',
            'description' => 'xx分公司01店',
            'telephone' => '2869xxxx',
            'email' => 'test2@qq.com',
            'address' =>'店铺地址',
        ]);
    }
}
