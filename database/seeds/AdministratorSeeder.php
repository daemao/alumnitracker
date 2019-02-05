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
        $yersultan_administator = [
            "first_name" => "Yersultan",
            "last_name" => "Nagashtay",
            "password" => bcrypt(123456),
            "role_id" => 1,
            "email" =>"yersultan.nagashtay@nu.edu.kz",
        ];
        $karina_administator = [
            "first_name" => "Karina",
            "last_name" => "Kim",
            "password" => bcrypt(123456),
            "role_id" => 1,
            "email" =>"karina.kim@nu.edu.kz",
        ];
        $admin = \App\Role::create(["original_name"=>'admin']);
        $admin->translateOrNew("en")->name = "administrator";
        $admin->translateOrNew("ru")->name = "администратор";
        $admin->save();
        $alumni = \App\Role::create(["original_name"=>'alumni']);
        $alumni->translateOrNew("en")->name = "alumni";
        $alumni->translateOrNew("ru")->name = "выпускник";
        $alumni->save();

        \App\User::create($karina_administator);
        \App\User::create($yersultan_administator);
    }
}
