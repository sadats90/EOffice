<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('role');
            $table->string('address');
            $table->integer('designation_id');
            $table->string('signature')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_work_handover')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('mobile_verified_code')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name'      => 'জাকির আহম্মেদ',
            'email'     => 'jakir.ruet.bd@gmail.com',
            'mobile'     => '01740857126',
            'role'      => 'user',
            'address'      => 'অলোকার মোড়, রাজশাহী',
            'designation_id' => 1,
            'signature'      => 'uploads/users/signature/default.png',
            'photo' => 'uploads/users/photo/default.png',
            'mobile_verified_code' => 857126,
            'password'  => bcrypt('noc@857126')
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
