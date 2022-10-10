<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBettermentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('betterment_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('letter_issue_id');
            $table->unsignedBigInteger('project_id');
            $table->string('road_section')->nullable(true);
            $table->double('betterment_fee')->default(0);
            $table->double('vat')->default(0);
            $table->tinyInteger('is_promise_required')->default(0);
            $table->timestamps();
            $table->foreign('letter_issue_id')->references('id')->on('letter_issues')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('betterment_fees');
    }
}
