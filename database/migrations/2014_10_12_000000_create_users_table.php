<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('user_lock_count')->default('0');
            $table->tinyInteger('user_is_blocked')->default('0');
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('role_id');
            $table->tinyInteger('created_by');
            $table->tinyInteger('updated_by');
            $table->rememberToken();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('updated_date')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
