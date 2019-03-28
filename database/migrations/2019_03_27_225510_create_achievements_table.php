<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration
{

    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime("time");
            $table->integer("user_id")->unsigned();
            $table->string("description");
        });
    }

    public function down()
    {
        Schema::dropIfExists('achievements');
    }
}
