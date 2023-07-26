<?php

namespace App\Http\Controllers;


use App\Models\KataModel;
use App\Models\NickNameModel;
use Illuminate\Http\Request;
use Sastrawi\Stemmer\Stemmer;
use Sastrawi\Stemmer\StemmerFactory;


class KamusController extends Controller
{
    public function prosesKalimatIndo(Request $request)
    {
        // Kalimat yang dikirimkan dari ajax
        $kalimat = strip_tags($request->input("kalimatIndo"));

        // ===================================================================================================
        // ================================== CODE PEMISAHAN KATA PERKATA ====================================
        // ===================================================================================================
        // $pattern = '/\b|\s+|(?=\p{P})|(?<=\p{P})/';
        $pattern = '/\b|\s+|(?=\p{P}(?<!-))|(?<=(?<!-)\p{P})/';
        $kalimat = preg_split($pattern, $kalimat, -1, PREG_SPLIT_NO_EMPTY);

        // ===================================================================================================
        // ================================ CODE PEMROSESAN KATA BERULANG ====================================
        // ===================================================================================================
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

        $cekNama = NickNameModel::all();
        $nama = array();
        foreach ( $cekNama as $cek){
            $nama[] = $cek->nickName;
        }

        // ===================================================================================================
        // ==================================== CODE PEMROSESAN IMBUHAN ======================================
        // ===================================================================================================
        // Proses IMBUHAN
        // Cek kata
        $cekKata = KataModel::all();
        $dicek = array();
        foreach ( $cekKata as $kata){
            $dicek[] = $kata->kataIndo;
        }

        // ================================= IMBUHAN AKHIRAN =================================================
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

        // ================================== DI dan KE =================================================
        foreach($kalimat as $index => $klmt){
            if(in_array($klmt, $dicek)){
                $kalimat[$index] = $kalimat[$index];
            }
            else {
                $awalan = ["di", "ke"];
                foreach($awalan as $awal){
                    if(substr($klmt, 0, strlen($awal)) === $awal){ // jika akhiran klmt = $akhiran 
                        $kalimat[$index] = $awal ." ". substr($klmt, strlen($awal), strlen($klmt));
                        break;
                    }
                }
            }
        }
        $kalimat = implode(" ", $kalimat);
        $kalimat = explode(" ", $kalimat);

        // ================================= IMBUHAN STEMMER =================================================
        
        // LIBRARY SASTRAWI UNTUK MENGHILANGKAN IMBUHAN DEPAN
        $factory = new StemmerFactory();
        $stemmer = $factory->createStemmer();
        
        for($z=0;$z<count($kalimat);$z++){

            if(in_array($kalimat[$z], $dicek)){
                $kalimat[$z] = $kalimat[$z];
            } else {            
                $kalimat[$z] = $stemmer->stem($kalimat[$z]);
            }
        }


        // ===================================================================================================
        // =========================== CODE PEMROSESAN BAHASA INDONESIA KE BAHASA MUNA =======================
        // ===================================================================================================
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
        }
        
        // ===================================================================================================
        // ================================= CODE PEMROSESAN KATA DAN KALIMAT ================================
        // ===================================================================================================
        if(count($result) == 1){

            echo json_encode(implode(" ", $result));
        }
        
        else 
        
        {
        // ============================================== KALIMAT ============================================
        
            $sisipan = ["miina", "minaho", "padamo", "aini", "awatu", "hunda", "naando"];

            for($a = 0; $a < count($result); $a++) {

                // positif kata Ganti saya -------------------------------------------------------------------
                if($result[$a] == "inodi"){
                    if (empty($result[$a+1])) {
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    }
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    else {
                        $verbaSaya = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaSaya->vSaya;
                        if(empty($jnsKata[$a+2]) || $jnsKata[$a+2] === "empty") {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // sisipan tidak, belum dan sudah
                if($result[$a] == "inodi" && in_array($result[$a+1],$sisipan) || $result[$a] == "inodi" && $jnsKata[$a+1] == "empty"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaSaya = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaSaya->vSaya;
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                if($result[$a] == "inodi" && in_array($result[$a+2],$sisipan) || $result[$a] == "inodi" && $jnsKata[$a+2] == "empty"){
                    if ($jnsKata[$a+3] != "verba"){
                        $result[$a+3] = $result[$a+3];
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaSaya = KataModel::firstWhere("kataMuna", "like", $result[$a+3]);
                        $result[$a+3] = $verbaSaya->vSaya;
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }


                // positif kata Ganti Kami -------------------------------------------------------------------
                if($result[$a] == "insaidi"){
                    if (empty($result[$a+1])) {
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    } 
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    else {
                        $verbaKami = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaKami->vKami;
                        if(empty($jnsKata[$a+2]) || $jnsKata[$a+2] === "empty") {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah
                if($result[$a] == "insaidi" && in_array($result[$a+1],$sisipan) || $result[$a] == "insaidi" && $jnsKata[$a+1] == "empty"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaKami = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaKami->vKami;
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                if($result[$a] == "insaidi" && in_array($result[$a+2],$sisipan) || $result[$a] == "insaidi" && $jnsKata[$a+2] == "empty"){
                    if ($jnsKata[$a+3] != "verba"){
                        $result[$a+3] = $result[$a+3];
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaKami = KataModel::firstWhere("kataMuna", "like", $result[$a+3]);
                        $result[$a+3] = $verbaKami->vKami;
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }


                // positif kata Ganti Kamu -------------------------------------------------------------------
                if($result[$a] == "ihintu"){
                    if (empty($result[$a+1])) {
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    } 
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    else {
                        $verbaKamu = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaKamu->vKamu;
                        if(empty($jnsKata[$a+2]) || $jnsKata[$a+2] === "empty") {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah
                if($result[$a] == "ihintu" && in_array($result[$a+1],$sisipan) || $result[$a] == "ihintu" && $jnsKata[$a+1] == "empty"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaKamu = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaKamu->vKamu;
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                if($result[$a] == "ihintu" && in_array($result[$a+2],$sisipan) || $result[$a] == "ihintu" && $jnsKata[$a+2] == "empty"){
                    if ($jnsKata[$a+3] != "verba"){
                        $result[$a+3] = $result[$a+3];
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaKamu = KataModel::firstWhere("kataMuna", "like", $result[$a+3]);
                        $result[$a+3] = $verbaKamu->vKamu;
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }

                // positif kata Ganti Dia -------------------------------------------------------------------
                if($result[$a] == "anoa" || in_array($result[$a], $nama)) {
                    if (empty($result[$a+1])) {
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    } 
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    else {
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+2]) || $jnsKata[$a+2] === "empty") {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah ------------------------------------------------------------------------------------------------
                if($result[$a] == "anoa" && in_array($result[$a+1],$sisipan) || $result[$a] == "anoa" && $jnsKata[$a+1] == "empty" || in_array($result[$a], $nama) && in_array($result[$a+1],$sisipan) || in_array($result[$a], $nama) && $jnsKata[$a+1] == "empty"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                if($result[$a] == "anoa" && in_array($result[$a+2],$sisipan) || $result[$a] == "anoa" && $jnsKata[$a+2] == "empty" || in_array($result[$a], $nama) && in_array($result[$a+2],$sisipan) || in_array($result[$a], $nama) && $jnsKata[$a+2] == "empty"){
                    if ($jnsKata[$a+3] != "verba"){
                        $result[$a+3] = $result[$a+3];
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+3]);
                        $result[$a+3] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }

                // positif kata Ganti Mereka -------------------------------------------------------------------
                if($result[$a] == "andoa") {
                    if (empty($result[$a+1])) {
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    } 
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    else {
                        $verbaMereka = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaMereka->vMereka;
                        if(empty($jnsKata[$a+2]) || $jnsKata[$a+2] === "empty") {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah
                if($result[$a] == "andoa" && in_array($result[$a+1],$sisipan) || $result[$a] == "andoa" && $jnsKata[$a+1] == "empty"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaMereka = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaMereka->vMereka;
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                if($result[$a] == "andoa" && in_array($result[$a+2],$sisipan) || $result[$a] == "andoa" && $jnsKata[$a+2] == "empty"){
                    if ($jnsKata[$a+3] != "verba"){
                        $result[$a+3] = $result[$a+3];
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaMereka = KataModel::firstWhere("kataMuna", "like", $result[$a+3]);
                        $result[$a+3] = $verbaMereka->vMereka;
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // =================================================================================================


                // ===================================================================================================
                // ========================================= NOUN/PRONOUN KEPUNYAAN ==================================
                // ===================================================================================================
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "kedua"){
                    if(empty($result[$a+1])){
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    }
                    if($result[$a+1] === "inodi"){
                        $result[$a+1] = "ku";
                    }
                    if($result[$a+1] === "insaidi"){
                        $result[$a+1] = "mani";
                    }
                    if($result[$a+1] === "ihintu"){
                        $result[$a+1] = "mu";
                    }
                    if($result[$a+1] === "anoa" || $result[$a+1] === "nya"){
                        $result[$a+1] = "no";
                    }
                    if($result[$a+1] === "andoa"){
                        $result[$a+1] = "ndo";
                    }
                }

                // ===================================================================================================
                // ============================= CODE MENGHILANGKAN SPASI PADA KEPUNYAAN =============================
                // ===================================================================================================
                if($jnsKata[$a] === "noun" || $jnsKata[$a] === "kedua" || $jnsKata[$a] === "empty"){
                    if(empty($result[$a+1])){
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    }
                    if($result[$a+1] === "ku" || $result[$a+1] === "mu" || $result[$a+1] === "mani" || $result[$a+1] === "ndo" || $result[$a+1] === "no" || $result[$a+1] === "nya"){
                        $result[$a] = $result[$a].$result[$a+1];
                        array_splice($result, $a+1, 1);
                        array_splice($jnsKata, $a+1, 1);
                    }
                }

                // positif kata Ganti Orang kedua "Hewan/Manusia" -------------------------------------------------------------------
                if($jnsKata[$a] == "kedua") {
                    if (empty($result[$a+1])) {
                        $result = implode(" ", $result);
                        $result = explode(" ", $result);
                        break;
                    } 
                    else if ($jnsKata[$a+1] != "verba"){
                        $result[$a+1] = $result[$a+1];
                        if(empty($jnsKata[$a+2])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    else {
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+1]);
                        $result[$a+1] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+2]) || $jnsKata[$a+2] === "empty") {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // Sisipan tidak, belum dan sudah
                if($jnsKata[$a] == "kedua" && in_array($result[$a+1],$sisipan) || $jnsKata[$a] == "kedua" && $jnsKata[$a+1] == "empty"){
                    if ($jnsKata[$a+2] != "verba"){
                        $result[$a+2] = $result[$a+2];
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+2]);
                        $result[$a+2] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+3])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                if($jnsKata[$a] == "kedua" && in_array($result[$a+2],$sisipan) || $jnsKata[$a] == "kedua" && $jnsKata[$a+2] == "empty"){
                    if ($jnsKata[$a+3] != "verba"){
                        $result[$a+3] = $result[$a+3];
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    } else {
                        $verbaDia = KataModel::firstWhere("kataMuna", "like", $result[$a+3]);
                        $result[$a+3] = $verbaDia->vDia;
                        if(empty($jnsKata[$a+4])) {
                            $result = implode(" ", $result);
                            $result = explode(" ", $result);
                            break;
                        }
                    }
                    $result = $result;
                }
                // ===================================================================================================

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
            $hasilProses = $result;

            $hasil = implode(" ", $hasilProses);
            echo json_encode($hasil);

            // echo json_encode($hasilProses);
            // echo json_encode($jnsKata);


        }
    }
}
