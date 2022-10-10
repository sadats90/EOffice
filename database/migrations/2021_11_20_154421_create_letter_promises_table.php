<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterPromisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_promises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('letter_issue_id');
            $table->string('attachment');
            $table->timestamps();
            $table->foreign('letter_issue_id')->references('id')->on('letter_issues')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_promises');
    }
}
