<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->string('location');
            $table->string('land_class');
            $table->string('seat_no');
            $table->string('spz_no')->nullable();
            $table->string('zone');
            $table->string('documents_correct');
            $table->longText('is_include_design');
            $table->tinyInteger('is_dev_plan');
            $table->longText('dev_plan_desc')->nullable();
            $table->string('information_correct');
            $table->string('road_condition')->nullable();
            $table->string('applicable_betterment_fee');

            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('no action');
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
        Schema::dropIfExists('application_reports');
    }
}
