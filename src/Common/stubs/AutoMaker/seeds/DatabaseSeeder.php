<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

require_once "SystemTableSeeder.php";
require_once "PermissionTableSeeder.php";
require_once "RoleTableSeeder.php";
require_once "departmentTableSeeder.php";
require_once "UserTableSeeder.php";
require_once "UserRoleTableSeeder.php";
require_once "RolePermissionTableSeeder.php";

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(SystemTableSeeder::class);
        $this->call(departmentTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);

        Model::reguard();
    }
}
