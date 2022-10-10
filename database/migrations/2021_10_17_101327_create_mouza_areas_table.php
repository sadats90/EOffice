<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMouzaAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mouza_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('upazila_id');
            $table->string('name');
            $table->string('jl_name');
            $table->timestamps();
            $table->foreign('upazila_id')->references('id')->on('upazilas')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mouza_areas');
    }
}
