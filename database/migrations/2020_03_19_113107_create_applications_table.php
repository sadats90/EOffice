<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('app_id');
            $table->unsignedBigInteger('app_serial')->default(0);
            $table->string('application_for');
            $table->string('app_type');
            $table->date('form_buy_date');
            $table->double('form_buy_price');
            $table->double('vat');
            $table->string('payment_method');
            $table->string('trxn_id');
            $table->integer('year');

            $table->tinyInteger('is_personal_info')->default(0);
            $table->tinyInteger('is_land_info')->default(0);
            $table->tinyInteger('is_document_info')->default(0);
            $table->tinyInteger('is_submit')->default(0);
            $table->dateTime('submission_date')->nullable();

            $table->tinyInteger('is_new')->default(0);
            $table->tinyInteger('is_report_initiate')->default(0);
            $table->date('expired_date')->nullable(true);
            $table->tinyInteger('is_certificate_make')->default(0);
            $table->tinyInteger('is_failed')->default(0);
            $table->tinyInteger('is_cancel')->default(0);
            $table->tinyInteger('is_complete')->default(0);
            $table->tinyInteger('correction_request_status')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
