<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('en_name');
            $table->string('father_en');
            $table->string('father_bn');
            $table->string('mother_en');
            $table->string('mother_bn');
            $table->date('date_of_birth');
            $table->string('nid_no');
            $table->string('gender');
            $table->string('religion');
            $table->string('bloodGroup')->nullable(true);
            $table->string('martial_status');
            $table->string('twitter_link')->nullable(true);
            $table->string('facebook_link')->nullable(true);
            $table->string('linkedin_link')->nullable(true);
            $table->string('skypee_link')->nullable(true);
            $table->timestamps();
        });

        DB::table('user_details')->insert([
            'user_id'      => 1,
            'en_name'     => 'Admin',
            'father_en'     => 'N/A',
            'father_bn'     => 'N/A',
            'mother_en'     => 'N/A',
            'mother_bn'     => 'N/A',
            'date_of_birth'     => date('Y-m-d'),
            'nid_no'      => 'N/A',
            'gender'      => 'male',
            'religion' => 'Islam',
            'bloodGroup' => 'A+',
            'martial_status' => 'N/A',

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
