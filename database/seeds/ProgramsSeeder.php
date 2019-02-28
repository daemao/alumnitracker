<?php

use Illuminate\Database\Seeder;

class ProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = ["bachelor","master","phd"];
        foreach ($programs as $program){
            \App\Program::create([
                "name"=>$program
            ]);
        }

    }
}
