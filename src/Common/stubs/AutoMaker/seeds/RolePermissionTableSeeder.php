<?php

use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    public function run()
    {
        for($j=10;$j>6;$j--){
            for($i=1;$i<$j+1;$i++){
                DB::table('permission_role')->insert([
                    'permission_id' => $i,
                    'role_id' =>$j,
                ]);
            }
        }
        DB::table('permission_role')->insert([
            'permission_id' => '6',
            'role_id' => '6',
        ]);
        for($j=5;$j>0;$j--){
            for($i=1;$i<=$j;$i++){
                DB::table('permission_role')->insert([
                    'permission_id' => strval($i),
                    'role_id' =>strval($j),
                ]);
            }
        }
    }
}
