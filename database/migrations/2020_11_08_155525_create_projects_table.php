<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('project_type');
            $table->timestamps();
        });

        DB::table('projects')->insert(
            array(
                array('name' => 'নাটোর-নবাবগঞ্জ সড়ক সরলীকরণ ও প্রশস্তকরণ', 'project_type' => 1),
                array('name' => 'গ্রেটার রোড বর্ধিতকরণ','project_type' => 1),
                array('name' => 'কল্পনা সিনেমা হল হতে সেরিকালচার বিক্রয় কেন্দ্র পর্যন্ত রাস্তা প্রশস্তকরণ', 'project_type' => 1),
                array('name' => 'রাজশাহী গ্রেটার রোড হতে রাজশাহী বাইপাস সড়ক পর্যন্ত সংযোগ সড়ক নির্মাণ', 'project_type' => 1),
                array('name' => 'সাহেব বাজার হতে গৌরহাঙ্গা পর্যন্ত রাস্তা নির্মাণ ও প্রশস্থকরণ', 'project_type' => 1),
                array('name' => 'কোর্ট হতে বাইপাস রোড পর্যন্ত রাস্তা প্রশস্তকরণ', 'project_type' => 1),
                array('name' => 'নাটোর রোড (রুয়েট) হতে রাজশাহী বাইপাস রোড পর্যন্ত রাস্তা প্রশস্থকরণ', 'project_type' => 1),
                array('name' => 'বনলতা আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'মহানন্দা আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'বারনই আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'পারিজাত আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'প্রান্তিক আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'পদ্মা আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'ছায়ানীড় আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'চন্দ্রিমা আবাসিক এলাকা', 'project_type' => 2),
                array('name' => 'আকাশ লীনা আবাসিক এলাকা', 'project_type' => 2),
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
        Schema::dropIfExists('projects');
    }
}
