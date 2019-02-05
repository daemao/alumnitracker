<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("roles",function (Blueprint $table){
            $table->increments("id");
            $table->string("original_name");
        });

        Schema::create("role_translations",function(Blueprint $table){
            $table->increments("id");
            $table->integer("role_id")->unsigned();
            $table->string("name");
            $table->string("locale")->index();
            $table->unique(["role_id","locale"]);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
