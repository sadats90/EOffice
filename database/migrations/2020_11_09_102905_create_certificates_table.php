<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('certificate_type_id');
            $table->longText('subject');
            $table->string('old_swarok')->nullable(true);
            $table->longText('condition_to_be_followed');
            $table->string('certificate_no');
            $table->bigInteger('created_by');
            $table->string('created_ip');
            $table->tinyInteger('is_issue')->default(0);
            $table->unsignedBigInteger('issue_by')->nullable();
            $table->unsignedBigInteger('on_behalf_of')->nullable();
            $table->string('issue_ip')->nullable();
            $table->date('issue_date')->nullable();
            $table->integer('year');
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('certificate_type_id')->references('id')->on('certificate_types')->onDelete('cascade')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificates');
    }
}
