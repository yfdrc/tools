<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration
{
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('desc', 4096);
            $table->string('memo', 4096)->nullable();
            $table->timestamps();
            $table->unique('name');
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->unsigned();
            $table->string('name', 64);
            $table->string('description', 10240)->nullable();
            $table->string('telephone', 256)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('address', 256)->nullable();
            $table->timestamps();
            $table->unique('name');
            $table->foreign('parent_id') ->references('id') ->on('departments')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->string('name', 64);
            $table->string('email', 64);
            $table->string('password', 256);
            $table->rememberToken();
            $table->timestamps();
            $table->unique('email');
            $table->unique('name');
            $table->foreign('department_id') ->references('id') ->on('departments')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('label', 64);
            $table->integer('right')->default(0);
            $table->string('description', 256)->nullable();
            $table->timestamps();
            $table->unique('name');
            $table->unique('label');
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('label', 64);
            $table->string('description', 256)->nullable();
            $table->timestamps();
            $table->unique('name');
            $table->unique('label');
        });
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('permission_id') ->references('id') ->on('permissions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id') ->references('id') ->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['permission_id', 'role_id']);
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id') ->references('id') ->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id') ->references('id') ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropifexists('password_resets');
        Schema::dropifexists('role_user');
        Schema::dropifexists('permission_role');
        Schema::dropifexists('permissions');
        Schema::dropifexists('roles');
        Schema::dropifexists('users');
        Schema::dropifexists('departments');
        Schema::dropifexists('systems');
    }
}
