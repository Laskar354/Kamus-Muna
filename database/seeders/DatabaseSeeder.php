<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\KataModel;
use App\Models\User;
use App\Models\JenisKataModel;
use App\Models\NickNameModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            "name" => "Laskar Jihad",
            "username" => "laskar",
            "email" => "laskar@gmail.com",
            "password" => bcrypt("laskar")
        ]);
        NickNameModel::create([
            "nickName" => "hobbit"
        ]);

        KataModel::create([
            "kataIndo" => "makan",
            "kataMuna" => "fuma",
            "jns_kata" => "verba",
            "vSaya" => "afuma",
            "vKami" => "tafuma",
            "vKamu" => "ofuma",
            "vDia" => "nofuma",
            "vMereka" => "dofuma"
        ]);
        KataModel::create([
            "kataIndo" => "saya",
            "kataMuna" => "inodi",
            "jns_kata" => "pronoun"
        ]);
        KataModel::create([
            "kataIndo" => "mereka",
            "kataMuna" => "andoa",
            "jns_kata" => "pronoun"
        ]);
        KataModel::create([
            "kataIndo" => "kami",
            "kataMuna" => "insaidi",
            "jns_kata" => "pronoun"
        ]);
        KataModel::create([
            "kataIndo" => "kamu",
            "kataMuna" => "ihintu",
            "jns_kata" => "pronoun"  
        ]);
        KataModel::create([
            "kataIndo" => "dia",
            "kataMuna" => "anoa",
            "jns_kata" => "pronoun"
        ]);
        KataModel::create([
            "kataIndo" => "___",
            "kataMuna" => "___",
            "jns_kata" => "empty"
        ]);


    }
}
