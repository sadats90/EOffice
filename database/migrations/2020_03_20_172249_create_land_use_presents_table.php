<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandUsePresentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_use_presents', function (Blueprint $table) {
            $table->id();
            $table->string('plut_name');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by');
            $table->string('created_ip');
            $table->integer('updated_by')->nullable();
            $table->string('updated_ip')->nullable();
            $table->timestamps();
        });

        // Insert some
        DB::table('land_use_presents')->insert(
            array(
                array(
                    'plut_name' => 'আবাসিক',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'বাণিজ্যিক',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'শিল্প',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'ধর্মীয়',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'কৃষি',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'ডোবা/পুকুর',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'ফাঁকা',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'মিশ্র',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'plut_name' => 'অন্যান্য',
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),

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
        Schema::dropIfExists('land_use_presents');
    }
}
