<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecievedApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recieved_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('to_user_id');
            $table->date('in_date');
            $table->tinyInteger('is_back');
            $table->tinyInteger('is_wait')->default(0);
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
        Schema::dropIfExists('recieved_applications');
    }
}
