<?php

use Illuminate\Database\Seeder;

class CangkuSeeder extends Seeder
{
    public function run()
    {
        factory(App\Models\Cangku::class, 5)->create();
    }
}
