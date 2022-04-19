<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_class', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('advertisement_id');
            $table->unsignedInteger('class_id');
            $table->timestamps();
            
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            
            $table->foreign('advertisement_id')->references('id')->on('advertisements')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('class_id')->references('id')->on('classes')
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
        Schema::dropIfExists('advertisement_class');
    }
}
