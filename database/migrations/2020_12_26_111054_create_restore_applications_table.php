<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestoreApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restore_applications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('letter_issue_id');
            $table->foreign('letter_issue_id')->references('id')->on('letter_issues')->onDelete('cascade')->onUpdate('no action');
            $table->date('old_expired_date');
            $table->date('new_expired_date');
            $table->string('created_ip');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');

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
        Schema::dropIfExists('restore_applications');
    }
}
