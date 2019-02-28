<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumniInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
        });

        Schema::create('alumni_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id")->unsigned();
            $table->integer("department_id")->unsigned()->nullable();
            $table->year("graduate_year")->unsigned()->nullable();
            $table->float("cumulative_gpa")->unsigned()->nullable();
            $table->string("id_in_university")->nullable();
            $table->integer("program_id")->unsigned();
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('restrict');
            $table->integer("university_id")->unsigned();
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('restrict');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumni');
    }
}
