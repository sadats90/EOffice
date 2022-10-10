<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_maps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_report_id');
            $table->foreign('application_report_id')->references('id')->on('application_reports')->onDelete('cascade')->onUpdate('no action');
            $table->string('path');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_maps');
    }
}
