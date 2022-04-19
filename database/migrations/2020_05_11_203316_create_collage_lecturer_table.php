<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollageLecturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collage_lecturer', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('collage_id');
            $table->unsignedInteger('lecturer_id');
            $table->date('date_of_registration');
            $table->timestamps();
            
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';

            $table->foreign('collage_id')->references('id')->on('collages')
                ->onUpdate('cascade')->onDelete('no action');
            $table->foreign('lecturer_id')->references('id')->on('users')
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
        Schema::dropIfExists('collage_lecturer');
    }
}
