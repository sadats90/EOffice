<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('letter_type_id');
            $table->string('subject');
            $table->string('sl_no')->nullable(true);
            $table->string('year');
            $table->longText('message')->nullable(true);
            $table->string('name')->nullable(true);
            $table->longText('address')->nullable(true);
            $table->date('expired_date');
            $table->bigInteger('version');
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_solved')->default(0);
            $table->tinyInteger('is_issued')->default(0);
            $table->tinyInteger('is_paper_submit')->default(0);
            $table->tinyInteger('is_bm_fee_payment')->default(0);
            $table->date('issue_date')->nullable(true);
            $table->bigInteger('user_id')->nullable(true);
            $table->bigInteger('on_behalf_of')->nullable(true);
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('letter_type_id')->references('id')->on('letter_types')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letter_issues');
    }
}
