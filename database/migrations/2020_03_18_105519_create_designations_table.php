<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority');
            $table->timestamps();
        });

        // Insert some
        DB::table('designations')->insert(
            array(
                array('name' => 'আইটি অ্যাডমিন', 'priority' => 0),
                array('name' => 'আবেদনকারী', 'priority' => 0),
                array('name' => 'চেয়ারম্যান', 'priority' => 1),
                array('name' => 'প্রধান নির্বাহী কর্মকর্তা', 'priority' => 2),
                array('name' => 'নির্বাহী ম্যাজিষ্টেট', 'priority' => 3),
                array('name' => 'নগর পরিকল্পক', 'priority' => 4),
                array('name' => 'সহকারী নগর পরিকল্পক',  'priority' => 5),
                array('name' => 'কম্পিউটার অপারেটর', 'priority' => 6),
                array('name' => 'ড্রাফটসম্যান-১', 'priority' => 7),
                array('name' => 'ড্রাফটসম্যান-২', 'priority' => 8),
                array('name' => 'সার্ভেয়ার', 'priority' => 9),
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
        Schema::dropIfExists('designations');
    }
}
