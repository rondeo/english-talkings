<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_levels', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('users', function (Blueprint $table){
           $table->string('nickname');
           $table->string('skype');
           $table->string('sex');
           $table->integer('age');
           $table->string('goal');
           $table->unsignedInteger('country_id');
           $table->unsignedInteger('language_id');
           $table->unsignedInteger('language_level_id');

           $table->foreign('language_id')->references('id')->on('languages');
           $table->foreign('country_id')->references('id')->on('countries');
           $table->foreign('language_level_id')->references('id')->on('language_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
