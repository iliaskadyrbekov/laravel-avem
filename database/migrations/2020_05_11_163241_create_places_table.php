<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained();
            $table->string('place_name');
            $table->text('slogan');
            $table->binary('background_image');
            $table->text('description');
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('website')->nullable();
            $table->json('working_hours')->nullable();
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
        Schema::dropIfExists('places');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
