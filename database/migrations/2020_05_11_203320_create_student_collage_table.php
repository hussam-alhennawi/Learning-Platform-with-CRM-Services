<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentCollageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_collage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('collage_id');
            $table->unsignedInteger('student_id');
            $table->date('date_of_registration');
            $table->timestamps();
            
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';

            $table->foreign('collage_id')->references('id')->on('collages')
                ->onUpdate('cascade')->onDelete('no action');
            $table->foreign('student_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_collage');
    }
}
