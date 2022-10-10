<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_personal_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');

            $table->string('ta_house_no');
            $table->string('ta_post_code');
            $table->string('ta_road_no')->nullable();
            $table->string('ta_sector_no')->nullable();
            $table->string('ta_area');
            $table->string('ta_post');
            $table->string('ta_thana');
            $table->string('ta_district');

            $table->string('pa_house_no');
            $table->string('pa_post_code');
            $table->string('pa_road_no')->nullable();
            $table->string('pa_sector_no')->nullable();
            $table->string('pa_area');
            $table->string('pa_post');
            $table->string('pa_thana');
            $table->string('pa_district');

            $table->string('mobile');
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_personal_infos');
    }
}
