<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCangkusTable extends Migration
{
    public function up()
    {
        Schema::create('cangkus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32);
            $table->string('address',256);
            $table->text('gly');
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cangkus');
    }
}
