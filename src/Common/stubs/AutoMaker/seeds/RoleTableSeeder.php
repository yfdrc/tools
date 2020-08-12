<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'indexs',
            'label' => '列表角色',
            'right' => 10,
            'description' => '用于列表基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'shows',
            'label' => '查阅角色',
            'right' => 20,
            'description' => '用于列表查阅基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'creaters',
            'label' => '新建角色',
            'right' => 30,
            'description' => '用于列表查阅新建基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'editors',
            'label' => '编辑角色',
            'right' => 40,
            'description' => '用于列表新建查编基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'deleters',
            'label' => '删除角色',
            'right' => 50,
            'description' => '用于列表新建查编删基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'caiwus',
            'label' => '财务角色',
            'right' => 60,
            'description' => '用于操作财务数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'dianpus',
            'label' => '店长角色',
            'right' => 200,
            'description' => '用于操作店铺基本和财务数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'departments',
            'label' => '分公司经理角色',
            'right' => 500,
            'description' => '用于操作分公司基本和财务数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'managers',
            'label' => '总经理角色',
            'right' => 800,
            'description' => '用于操作公司所有基本和财务数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'admins',
            'label' => '管理员角色',
            'right' => 1000,
            'description' => '用于任何操作',
        ]);
    }
}
