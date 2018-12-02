<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable()->change();
            $table->string('skype')->nullable()->change();
            $table->string('sex')->nullable()->change();
            $table->integer('age')->nullable()->change();
            $table->string('goal')->nullable()->change();
            $table->unsignedInteger('country_id')->nullable()->change();
            $table->unsignedInteger('language_id')->nullable()->change();
            $table->unsignedInteger('language_level_id')->nullable()->change();
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
