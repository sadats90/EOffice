<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpazilasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upazilas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('upazilas')->insert(
            array(
                array('district_id' => 1, 'name' => 'বোয়ালিয়া'),
                array('district_id' => 1, 'name' => 'পবা'),
                array('district_id' => 1, 'name' => 'চারঘাট'),
                array('district_id' => 1, 'name' => 'পুঠিয়া')
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
        Schema::dropIfExists('upazilas');
    }
}
