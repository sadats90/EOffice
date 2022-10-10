<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotOwnProjectInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('not_own_project_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_land_info_id');
            $table->string('is_acquisition');
            $table->string('acquisition_amount')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
            $table->foreign('application_land_info_id')->references('id')->on('application_land_infos')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('not_own_project_infos');
    }
}
