<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovernmentCertificateLawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('government_certificate_laws', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('government_certificate_id');
            $table->foreign('government_certificate_id')->references('id')->on('government_certificates')->onDelete('cascade')->onUpdate('no action');

            $table->string('name');
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
        Schema::dropIfExists('government_certificate_laws');
    }
}
