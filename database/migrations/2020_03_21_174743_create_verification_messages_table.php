<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('on_behalf_of')->nullable();
            $table->unsignedBigInteger('violate_to')->nullable();
            $table->unsignedBigInteger('violate_by')->nullable();
            $table->longText('message')->nullable();
            $table->integer('version');
            $table->integer('same_comment');
            $table->bigInteger('letter_issue_id');
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
        Schema::dropIfExists('verification_messages');
    }
}
