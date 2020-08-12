<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'index',
            'label' => '列表权限',
            'description' => '可以列表基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'show',
            'label' => '查阅权限',
            'description' => '可以查阅基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'create',
            'label' => '新建权限',
            'description' => '可以新建基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit',
            'label' => '编辑权限',
            'description' => '可以编辑基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete',
            'label' => '删除权限',
            'description' => '可以删除基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'caiwu',
            'label' => '财务人员权限',
            'description' => '可以操作财务数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'dianpu',
            'label' => '店长权限',
            'description' => '可以操作店铺基本和财务数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'department',
            'label' => '分公司经理权限',
            'description' => '可以操作分公司基本和财务数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'manage',
            'label' => '总经理权限',
            'description' => '可以操作所有部门基本和财务数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'admin',
            'label' => '管理员权限',
            'description' => '拥有终极权限',
        ]);
    }
}
