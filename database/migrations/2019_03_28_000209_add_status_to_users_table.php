<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->increments("id");
        });
        Schema::create('user_status_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("locale")->index();
            $table->integer("user_status_id")->unsigned();
            $table->unique(["user_status_id","locale"]);
            $table->foreign("user_status_id")->references("id")->on("user_statuses")->onDelete("restrict");
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer("status_id")->unsigned();
            $table->integer("current_university_id")->unsigned()->nullable();
            $table->integer("current_work_id")->unsigned()->nullable();
            $table->foreign("current_university_id")->references("id")->on("alumni_info")->onDelete("restrict");
            $table->foreign("current_work_id")->references("id")->on("work_experiences")->onDelete("restrict");
        });
        $statuses=[
            ["ru"=>"работает","en"=>"working"],
            ["en"=>"studying","ru"=>"учится"]
        ];
        foreach ($statuses as $status){
            $new_status=\App\UserStatus::create();
            $new_status->translateOrNew("ru")->name=$status["ru"];
            $new_status->translateOrNew("en")->name=$status["en"];
            $new_status->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
