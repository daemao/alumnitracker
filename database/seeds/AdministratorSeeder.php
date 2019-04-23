<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mona_administator = [
            "first_name" => "Mona",
            "last_name" => "Rizvi",
            "password" => bcrypt(123456),
            "role_id" => 1,
            "email" =>"mona.rizvi@nu.edu.kz",
        ];
        $admin = \App\Role::create(["original_name"=>'admin']);
        $admin->translateOrNew("en")->name = "administrator";
        $admin->translateOrNew("ru")->name = "администратор";
        $admin->save();
        $alumni = \App\Role::create(["original_name"=>'alumni']);
        $alumni->translateOrNew("en")->name = "alumni";
        $alumni->translateOrNew("ru")->name = "выпускник";
        $alumni->save();
        \App\User::create($mona_administator);
    }
}
