<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandUseFuturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_use_futures', function (Blueprint $table) {
            $table->id();
            $table->string('flut_name');
            $table->double('cost');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by');
            $table->string('created_ip');
            $table->integer('updated_by')->nullable();
            $table->string('updated_ip')->nullable();
            $table->timestamps();
        });

        // Insert some
        DB::table('land_use_futures')->insert(
            array(
                array(
                    'flut_name' => 'আবাসিক',
                    'cost' => 2000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'বাণিজ্যিক',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'মিশ্র',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'শিক্ষা ও গবেষণা',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'এ্যাসেম্বলি',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'কৃষি',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'পাবলিক এ্যাডমিনিস্ট্রেশন',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'ইন্সিটিটিউট',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'ওপেন স্পেস',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'সিকিউরিটি',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                'flut_name' => 'পাবলিক ইউটিলিটি',
                'cost' => 4000,
                'created_by' => 1,
                'created_ip' => 'localhost'
                ),

                array(
                    'flut_name' => 'সড়ক',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'রেলওয়ে',
                    'cost' => 4000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'ক্ষুদ্র ও মাঝারী শিল্প',
                    'cost' => 10000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'বড় শিল্প',
                    'cost' => 20000,
                    'created_by' => 1,
                    'created_ip' => 'localhost'
                ),
                array(
                    'flut_name' => 'ইটভাটা',
                    'cost' => 20000,
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
        Schema::dropIfExists('land_use_futures');
    }
}
