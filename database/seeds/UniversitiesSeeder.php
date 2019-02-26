<?php

use Illuminate\Database\Seeder;
use App\University;
class UniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Kazakhstan id  = 1;
        $universities=[
            ["en"=>"Nazarbayev University","ru"=>"Назарбаев Университет","country_id"=>1],
        ];
        foreach ($universities as $university){
            $university_record = University::create(["country_id"=>$university['country_id']]);
            $university_record->translateOrNew("en")->name=$university["en"];
            $university_record->translateOrNew("ru")->name=$university["ru"];
            $university_record->save();
        }
    }
}
