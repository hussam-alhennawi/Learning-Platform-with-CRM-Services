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
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->date('DOB');
            $table->string('scientific_degree')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->enum('gender',['male','female']);
            $table->string('username')->unique();
            $table->string('password');
            $table->string('identity_check')->nullable()->comment('file name');
            $table->boolean('active')->default(1);
            $table->boolean('blocked')->default(0);
            $table->rememberToken();
            $table->string('image')->nullable();
            $table->timestamps();
            
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
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
