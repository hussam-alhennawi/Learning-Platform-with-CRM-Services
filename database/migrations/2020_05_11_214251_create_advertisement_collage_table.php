<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementCollageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_collage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('advertisement_id');
            $table->unsignedInteger('collage_id');
            $table->timestamps();
            
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            
            $table->foreign('advertisement_id')->references('id')->on('advertisements')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('collage_id')->references('id')->on('collages')
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
        Schema::dropIfExists('advertisement_collage');
    }
}
