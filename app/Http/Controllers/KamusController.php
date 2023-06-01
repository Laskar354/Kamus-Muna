<?php

namespace App\Http\Controllers;


use App\Models\KataModel;
use Illuminate\Http\Request;
use Sastrawi\Stemmer\Stemmer;
use Sastrawi\Stemmer\StemmerFactory;


class KamusController extends Controller
{
    public function prosesKataIndo(Request $request)
    {
        $kata = $request->input("kata");
        $hasil =  KataModel::firstWhere("kataIndo", $kata);

        
        if(empty($hasil))
        {
            $bla = "Kata tidak tersedia";
            echo json_encode($bla);
        } else {

            //kirim arti dalam bahasa Muna ke ajaxnya    
            echo json_encode($hasil->kataMuna);
        }


    }

    public function prosesKalimatIndo(Request $request)
    {
        // Kalimat yang dikirimkan dari ajax
        $kalimat = $request->input("kalimatIndo");

        // $pattern = '/\b|\s+|(?=\p{P})|(?<=\p{P})/';
        $pattern = '/\b|\s+|(?=\p{P}(?<!-))|(?<=(?<!-)\p{P})/';
        $kalimat = preg_split($pattern, $kalimat, -1, PREG_SPLIT_NO_EMPTY);

        // Kode menyatukan kata ulang didalam array $kalimat
        $kataGabung = [];
        $i = 0;
        $count = count($kalimat);
        while ($i < $count) {
            $kata2 = $kalimat[$i];
            if ($i < $count - 2 && $kalimat[$i + 1] === "-" && $kalimat[$i + 2] === $kata2) {
                $kataGabung[] = $kata2 . "-" . $kata2;
                $i += 3;
            } else {
                $kataGabung[] = $kata2;
                $i++;
            }
        }
        $kalimat = $kataGabung;
        // echo json_encode($kalimat);exit;
        // -------------------------------------------------------------------------------------

        // Pakai library sastrawi -> menghilangkan imbuhan
        $factory = new StemmerFactory();
        $stemmer = $factory->createStemmer();

        // ----------------------------------------------------
        // Proses IMBUHAN
        // Cek dulu jika kata ada dalam database kata jangan di stemmer. Jika tidak lakukaan stemmer

        $cekKata = KataModel::all();
        $dicek = array();
        foreach ( $cekKata as $kata){
            $dicek[] = $kata->kataIndo;
        }

        for($z=0;$z<count($kalimat);$z++){

            if(in_array($kalimat[$z], $dicek)){
                $kalimat[$z] = $kalimat[$z];
            } else {            
                $kalimat[$z] = $stemmer->stem($kalimat[$z]);
            }
        }


        // Ambil kata indonesia dan ubah ke muna
        $result = array();
        for($i = 0; $i < count($kalimat); $i++){

            $kataMuna = KataModel::firstWhere("kataIndo","like", $kalimat[$i]);
            $kataGanti = KataModel::firstWhere("kataIndo", "___");

            if($kataMuna != null){
                $kataMuna = $kataMuna;
                
            } else {
                $kataMuna = $kataGanti;
            }

            $result[] = $kataMuna->kataMuna;
            $jnsKata[] = $kataMuna->jns_kata;
        }

        // Jika kata tidak ada dalam data, maka ganti dengan input kata aslinya
        foreach($result as $index => $val){
            if($val === "___"){
                $result[$index] = $kalimat[$index];
            }
        } // =====================================================================
        

        if(count($result) == 1){

            echo json_encode($result);
        }
        // Proses kalimat berisi 3 kata saja
        // else if (count($result) <= 3 ) 
        // {
            

        //     if(in_array("inodi", $result)){

        //         //ambil index subjeknya
        //         $i = array_search("inodi", $result);

        //         //$jnsKata[$i+1] == "verba"
        //         //in_array("verba", $jnsKata)
        //         if($jnsKata[$i+1] == "verba"){
        //             $j = array_search($jnsKata[$i+1], $jnsKata);
                    
        //             $verbaSaya = KataModel::firstWhere("kataMuna", "like", "%".$result[$j]);
        //             $result[$j] = $verbaSaya->vSaya;
        //         }
        //         $result = $result;

        //     }

        //                 // $hasil = implode(" ", $result);
        //     // echo json_encode($hasil);


        //     echo json_encode($result);

        // } 
        
        else 
        
        {

            // -------------------------- proses Kalimat banyak kata/result disini --------------------------


            // Proses Kata Ganti Orang dalam verba

            for($a = 0; $a < count($result); $a++) {

                // positif kata Ganti saya -------------------------------------------------------------------
                if($result[$a] == "inodi"){
                    if (empty($result[$a+1])) {
                        echo json_encode($result);
                        exit;
                    } 
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    else {
                        $verbaSaya = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaSaya->vSaya;
                        if(empty($jnsKata[$a+2])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }
                // negasi kata ganti saya
                if($result[$a] == "inodi"){
                    if (empty($result[$a+1])) {
                        echo json_encode($result);
                        exit;
                    } 
                    else if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    else {
                        $verbaSaya = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaSaya->vSaya;
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }


                // positif kata Ganti Kami -------------------------------------------------------------------
                if($result[$a] == "insaidi"){
                    if (empty($result[$a+1])) {
                        echo json_encode($result);
                        exit;
                    } 
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    else {
                        $verbaKami = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaKami->vKami;
                        if(empty($jnsKata[$a+2])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }

                if($result[$a] == "insaidi"){
                    if($jnsKata[$a+2] == "verba"){
                        $verbaKami = KataModel::firstWhere("kataMuna", "like", "%".$result[$a+2]);
                        $result[$a+2] = $verbaKami->vKami;
                    }
                    $result = $result;
                }

            }

            // $hasil = implode(" ", $result);
            // echo json_encode($hasil);


            echo json_encode($result);


        }
    }
}
