<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key');
            $table->timestamps();
        });

        DB::table('tasks')->insert(
            array(
                array('name' => 'Admin', 'key' => 'admin'),
                array('name' => 'নতুন আবেদন', 'key' => 'NA'),
                array('name' => 'ফরওয়ার্ড', 'key' => 'FW'),
                array('name' => 'চিঠি তৈরি', 'key' => 'LP'),
                array('name' => 'চিঠি প্রদান', 'key' => 'LI'),
                array('name' => 'এনওসি সনদপত্র তৈরি', 'key' => 'CM'),
                array('name' => 'এনওসি সনদপত্র যাচাই', 'key' => 'CV'),
                array('name' => 'এনওসি সনদপত্র প্রদান', 'key' => 'CD'),
                array('name' => 'এনওসি সনদপত্র দেখা', 'key' => 'CS'),
                array('name' => 'অনুলিপি প্রাপক', 'key' => 'DC'),
                array('name' => 'অবস্থান রিপোর্ট', 'key' => 'PR'),
                array('name' => 'উৎকর্ষ ফি রিপোর্ট', 'key' => 'BFR'),
                array('name' => 'ইস্যু রিপোর্ট', 'key' => 'ER'),
                array('name' => 'ভূমি ব্যবহারের রিপোর্ট', 'key' => 'LUR'),
                array('name' => 'দায়িত্ব হস্তান্তর', 'key' => 'WH'),
                array('name' => 'একই স্বারকে প্রতিস্থাপন', 'key' => 'CR'),
                array('name' => 'অনিস্পত্তি আবেদন', 'key' => 'FA'),
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
        Schema::dropIfExists('tasks');
    }
}
