<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibProjectSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lib_project_supervisor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lecturer_id');
            $table->unsignedInteger('lib_project_id');
            $table->timestamps();
            
            $table->charset = 'utf8';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            
            $table->foreign('lecturer_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        
            $table->foreign('lib_project_id')->references('id')->on('lib_projects')
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
        Schema::dropIfExists('lib_project_supervisor');
    }
}
