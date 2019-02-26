<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JoinUniversityProgramDepartmentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("university_program_departments",function(Blueprint $table){
            $table->increments("id");
            $table->integer("university_id")->unsigned();
            $table->integer("program_id")->unsigned();
            $table->integer("department_id")->unsigned();
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
