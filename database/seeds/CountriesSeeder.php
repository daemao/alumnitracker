<?php

use Illuminate\Database\Seeder;
use App\Country;
class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
          ["en"=>"Kazakhstan","ru"=>"Казахстан"],
          ["en"=>"America","ru"=>"Америка"]
        ];
        foreach ($countries as $country){
            $new_country  = Country::create([]);
            $new_country->translateOrNew("en")->name=$country["en"];
            $new_country->translateOrNew("ru")->name=$country['ru'];
            $new_country->save();
        }
    }
}
