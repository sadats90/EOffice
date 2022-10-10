<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('certificate_id');
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade')->onUpdate('no action');

            $table->string('village');
            $table->string('post_office');
            $table->string('thana');
            $table->string('district');

            $table->string('zone');
            $table->string('mouza');
            $table->string('spot_no');
            $table->string('zl_no');
            $table->unsignedDouble('land_amount');

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
        Schema::dropIfExists('general_certificates');
    }
}
