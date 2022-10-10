<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBettermentFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('betterment_fee_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('letter_issue_id');
            $table->date('payment_date');
            $table->double('payment_amount');
            $table->string('payment_method');
            $table->string('trxn_id');
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
        Schema::dropIfExists('betterment_fee_payments');
    }
}
