<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralCertificateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_certificate_applicants', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('general_certificate_id');
            $table->foreign('general_certificate_id')->references('id')->on('general_certificates')->onDelete('cascade')->onUpdate('no action');

            $table->string('name');
            $table->string('father');

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
        Schema::dropIfExists('general_certificate_applicants');
    }
}
