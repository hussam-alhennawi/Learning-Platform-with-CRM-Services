<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLectureCheckInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_check_in', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_class_id');
            $table->unsignedInteger('lecture_id');
            $table->timestamps();
            
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';

            $table->foreign('student_class_id')->references('id')->on('student_class')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lecture_id')->references('id')->on('lectures')
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
        Schema::dropIfExists('lecture_check_in');
    }
}
