<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("photos",function (Blueprint $table){
           $table->increments("id");
           $table->integer("user_id")->unsigned();
           $table->string("url");
        });
        Schema::table("users",function (Blueprint $table){
           $table->integer("avatar_id")->unsigned()->nullable();
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
