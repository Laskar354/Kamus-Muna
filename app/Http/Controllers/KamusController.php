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
        // -------------------------------------------------------------------------------------

        // Pakai library sastrawi -> menghilangkan imbuhan
        $factory = new StemmerFactory();
        $stemmer = $factory->createStemmer();

        // ----------------------------------------------------
        // Proses IMBUHAN
        // Cek kata
        $cekKata = KataModel::all();
        $dicek = array();
        foreach ( $cekKata as $kata){
            $dicek[] = $kata->kataIndo;
        }
        // ----------------------------------------------------

        // imbuhan akhiran
        foreach($kalimat as $index => $klmt){
            if(in_array($klmt, $dicek)){
                $kalimat[$index] = $kalimat[$index];
            }
            else {
                $akhiran = ["ku", "mu", "nya"];
                foreach($akhiran as $akhir){
                    if(substr($klmt, -strlen($akhir)) === $akhir){ // jika akhiran klmt = $akhiran 
                        $kalimat[$index] = substr($klmt, 0, -strlen($akhir))." ". $akhir;
                        break;
                    }
                }
            }
        }
        $kalimat = implode(" ", $kalimat);
        $kalimat = explode(" ", $kalimat);

        // echo json_encode($kalimat);exit;

        // Imbuhan awalan
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
        
        else 
        
        {

            // -------------------------- proses Kalimat banyak kata/result disini ---------------------------


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
                // sisipan tidak, belum dan sudah
                if($result[$a] == "inodi" && $result[$a+1] == "miina" || $result[$a] == "inodi" && $result[$a+1] == "minaho" || $result[$a] == "inodi" && $result[$a+1] == "padamo"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    } else {
                        $verbaSaya = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaSaya->vSaya;
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
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
                // Sisipan tidak, belum dan sudah
                if($result[$a] == "insaidi" && $result[$a+1] == "miina" || $result[$a] == "insaidi" && $result[$a+1] == "minaho" || $result[$a] == "insaidi" && $result[$a+1] == "padamo"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    } else {
                        $verbaKami = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaKami->vKami;
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                }


                // positif kata Ganti Kamu -------------------------------------------------------------------
                if($result[$a] == "ihintu"){
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
                        $verbaKamu = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaKamu->vKamu;
                        if(empty($jnsKata[$a+2])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah
                if($result[$a] == "ihintu" && $result[$a+1] == "miina" || $result[$a] == "ihintu" && $result[$a+1] == "minaho" || $result[$a] == "ihintu" && $result[$a+1] == "padamo"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    } else {
                        $verbaKamu = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaKamu->vKamu;
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }

                // positif kata Ganti Dia -------------------------------------------------------------------
                if($result[$a] == "anoa"){
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
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+2])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah
                if($result[$a] == "anoa" && $result[$a+1] == "miina" || $result[$a] == "anoa" && $result[$a+1] == "minaho" || $result[$a] == "anoa" && $result[$a+1] == "padamo"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    } else {
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }

                // positif kata Ganti Mereka -------------------------------------------------------------------
                if($result[$a] == "andoa") {
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
                        $verbaMereka = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaMereka->vMereka;
                        if(empty($jnsKata[$a+2])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah
                if($result[$a] == "andoa" && $result[$a+1] == "miina" || $result[$a] == "andoa" && $result[$a+1] == "minaho" || $result[$a] == "andoa" && $result[$a+1] == "padamo"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    } else {
                        $verbaMereka = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaMereka->vMereka;
                        if(empty($jnsKata[$a+3])) {
                            echo json_encode($result);
                            exit;
                        }
                    }
                    $result = $result;
                }

                // MENGATASI NOUN/PRONOUN KEPUNYAAN ================================================================
                // Saya
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "pronoun2"){
                    if(empty($result[$a+1])){
                        echo json_encode($result);
                        exit;
                    }
                    if($result[$a+1] === "inodi"){
                        $result[$a+1] = "ku";
                    }
                }
                // Kami
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "pronoun2"){
                    if(empty($result[$a+1])){
                        echo json_encode($result);
                        exit;
                    }
                    if($result[$a+1] === "insaidi"){
                        $result[$a+1] = "mani";
                    }
                }
                // Kamu
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "pronoun2"){
                    if(empty($result[$a+1])){
                        echo json_encode($result);
                        exit;
                    }
                    if($result[$a+1] === "ihintu"){
                        $result[$a+1] = "mu";
                    }
                }
                // Dia
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "pronoun2"){
                    if(empty($result[$a+1])){
                        echo json_encode($result);
                        exit;
                    }
                    if($result[$a+1] === "anoa"){
                        $result[$a+1] = "no";
                    }
                }
                // Mereka
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "pronoun2"){
                    if(empty($result[$a+1])){
                        echo json_encode($result);
                        exit;
                    }
                    if($result[$a+1] === "andoa"){
                        $result[$a+1] = "ndo";
                    }
                }
                // Nya
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "pronoun2"){
                    if(empty($result[$a+1])){
                        echo json_encode($result);
                        exit;
                    }
                    if($result[$a+1] === "nya"){
                        $result[$a+1] = "no";
                    }
                }
                // =================================================================================================


                // $hitungKata = 0;
                // $indexVerba = -1;
                // for($b = 0; $b < count($jnsKata); $b++){
    
                //     if($jnsKata[$b] === "pronoun") {
                //         $hitungKata++;
                //     } else if ($jnsKata[$b] === "verba" && $hitungKata > 0){
                //         $indexVerba = $b;
                //         $verbaKami = KataModel::firstWhere("jns_kata", "like", $jnsKata[$indexVerba]);
                //         $ganti = $verbaKami->vKami;
                //         $result[$indexVerba] = $ganti;
                //         // echo json_encode($ganti);
                //         // break;
                //     }
                // }
                // $verbaKami = KataModel::firstWhere("jns_kata", "like", $jnsKata[$indexVerba]);
                // if($indexVerba !== -1){
                //     $verbaKami = KataModel::firstWhere("kataMuna", "like", $result[$indexVerba]);
                //     $result[$indexVerba] = $verbaKami->vKami;
                // }

            }

            // $hasil = implode(" ", $result);
            // echo json_encode($hasil);

            echo json_encode($result);
            // echo json_encode($jnsKata);


        }
    }
}
