<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments=[
            ["en"=>"Computer Science","ru"=>"Вычислительные науки"],
            ["en"=>"Mathematics","ru"=>"Математика"],
            ["en"=>"Physics","ru"=>"Физика"],
            ["en"=>"Chemistry","ru"=>"Химия"],
            ["en"=>"Biology","ru"=>"Биология"],
            ["en"=>"Economics","ru"=>"Экономика"],
            ["en"=>"Linguistics","ru"=>"Лингвистика"],
        ];

        foreach ($departments as $department){
            $department_record = \App\Department::create([]);
            $department_record->translateOrNew("ru")->name=$department["ru"];
            $department_record->translateOrNew("en")->name=$department["en"];
            $department_record->save();
        }
    }
}
