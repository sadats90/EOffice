<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('application_fee');
            $table->double('emergency_fee');
            $table->double('vat');
            $table->timestamps();
        });

        DB::table('fees')->insert(
            array(
                array('application_fee' => 500, 'emergency_fee' => 1000, 'vat' => 15)
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
