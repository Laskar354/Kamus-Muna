<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\KataModel;
use App\Models\JenisKataModel;
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
            "kataIndo" => "nasi",
            "kataMuna" => "o ghoti",
            "jns_kata" => "noun"
        ]);
        KataModel::create([
            "kataIndo" => "minum",
            "kataMuna" => "foroghu",
            "jns_kata" => "verba",
            "vSaya" => "aforoghu",
            "vKami" => "taforoghu",
            "vKamu" => "oforoghu",
            "vDia" => "noforoghu",
            "vMereka" => "doforoghu"
        ]);
        KataModel::create([
            "kataIndo" => "kopi",
            "kataMuna" => "o kopi",
            "jns_kata" => "noun"
        ]);
        KataModel::create([
            "kataIndo" => "roti",
            "kataMuna" => "o roti",
            "jns_kata" => "noun"
        ]);
        KataModel::create([
            "kataIndo" => "buku",
            "kataMuna" => "o boku",
            "jns_kata" => "noun"
        ]);
        KataModel::create([
            "kataIndo" => "dan",
            "kataMuna" => "bhe",
            "jns_kata" => "sambung"
        ]);
        KataModel::create([
            "kataIndo" => "mandi",
            "kataMuna" => "kadiu",
            "jns_kata" => "verba",
            "vSaya" => "aekadiu",
            "vKami" => "taekadiu",
            "vKamu" => "omekadiu",
            "vDia" => "nekadiu",
            "vMereka" => "dekadiu"
        ]);
        KataModel::create([
            "kataIndo" => "___",
            "kataMuna" => "___",
            "jns_kata" => "empty"
        ]);
        KataModel::create([
            "kataIndo" => "pergi",
            "kataMuna" => "kala",
            "jns_kata" => "verba",
            "vSaya" => "akala",
            "vKami" => "takala",
            "vKamu" => "okala",
            "vDia" => "nokala",
            "vMereka" => "dokala"
        ]);
        KataModel::create([
            "kataIndo" => "di",
            "kataMuna" => "we",
            "jns_kata" => "sambung"
        ]);
        KataModel::create([
            "kataIndo" => "ke",
            "kataMuna" => "we",
            "jns_kata" => "sambung"
        ]);
        KataModel::create([
            "kataIndo" => "sumur",
            "kataMuna" => "sumu",
            "jns_kata" => "nomina"
        ]);
        KataModel::create([
            "kataIndo" => "sungai",
            "kataMuna" => "laa",
            "jns_kata" => "nomina"
        ]);
        KataModel::create([
            "kataIndo" => "laut",
            "kataMuna" => "tehi",
            "jns_kata" => "nomina"
        ]);
        KataModel::create([
            "kataIndo" => "belum",
            "kataMuna" => "minaho",
            "jns_kata" => "adverb"
        ]);
        KataModel::create([
            "kataIndo" => "tidak",
            "kataMuna" => "miina",
            "jns_kata" => "adverb"
        ]);
        KataModel::create([
            "kataIndo" => "makanan",
            "kataMuna" => "kafuma",
            "jns_kata" => "noun"
        ]);


    }
}
