<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnProjectInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('own_project_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_land_info_id');
            $table->unsignedBigInteger('project_id');
            $table->string('plot_no');
            $table->timestamps();
            $table->foreign('application_land_info_id')->references('id')->on('application_land_infos')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('own_project_infos');
    }
}
