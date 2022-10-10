<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('document_types')->insert(
            array(
                array('name' => 'জমির দলিল'),
                array('name' => 'প্রস্তাবিত আর এস খতিয়ান'),
                array('name' => 'খাজনার রশিদ'),
                array('name' => 'খারিজের রশিদ'),
                array('name' => 'মৌজা ম্যাপ (৮" X ১২")'),
                array('name' => 'ভোটার আইডি কার্ড'),
                array('name' => 'অবস্থান ম্যাপ/হাত নকশা'),
                array('name' => 'অঙ্গিকারনামা'),
                array('name' => 'অবস্থানগত এনওসি সনদপত্র'),
                array('name' => 'অন্যান্য'),
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
        Schema::dropIfExists('document_types');
    }
}
