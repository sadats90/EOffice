<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('to_user_id');
            $table->date('in_date');
            $table->date('out_date')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->tinyInteger('is_verified')->default(0);
            $table->tinyInteger('is_fail')->default(0);
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_routes');
    }
}
