<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBloodGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('blood_groups')->insert(
            array(
                array('name' => 'এ+'),
                array('name' => 'বি+'),
                array('name' => 'এবি+'),
                array('name' => 'ও+'),
                array('name' => 'এ-'),
                array('name' => 'বি-'),
                array('name' => 'এবি-'),
                array('name' => 'ও-'),
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
        Schema::dropIfExists('blood_groups');
    }
}
