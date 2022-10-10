<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotOwnProjectExtraInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('not_own_project_extra_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('not_own_project_info_id');
            $table->unsignedBigInteger('mouza_area_id');
            $table->string('rs_line_no');
            $table->timestamps();
            $table->foreign('not_own_project_info_id')->references('id')->on('not_own_project_infos')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('mouza_area_id')->references('id')->on('mouza_areas')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('not_own_project_extra_infos');
    }
}
