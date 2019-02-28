<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('company_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("locale")->index();
            $table->integer("company_id")->unsigned();
            $table->unique(["company_id","locale"]);
            $table->foreign('company_id')->references('id')->on('departments')->onDelete('cascade');
        });
        Schema::create("company_country",function (Blueprint $table){
           $table->increments("id");
           $table->integer("company_id")->unsigned();
           $table->integer("country_id")->unsigned();
           $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
           $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_translations');
        Schema::dropIfExists('company_country');

    }
}
