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
            $table->id();
            $table->string('login');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('birth')->nullable();
            $table->foreignId('city_id')->constrained(); // added nullable with migration
            $table->binary('profile_image')->nullable();
            $table->binary('background_image')->nullable();
            $table->text('status')->nullable();
            $table->text('description')->nullable();
        });
        Schema::create('follower_following', function (Blueprint $table) {
            $table->foreignId('following_id')->constrained('users');
            $table->foreignId('follower_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
