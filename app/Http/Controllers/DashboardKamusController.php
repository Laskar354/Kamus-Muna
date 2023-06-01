<?php

namespace App\Http\Controllers;

use App\Models\KataModel;
use Illuminate\Http\Request;

class DashboardKamusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboardKamus.index', [
            "words" => KataModel::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboardKamus.addKata");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $rules = [
            "kataIndo" => "required",
            "kataMuna" => "required",
            "jns_kata" => "required"
        ];

        if($request->jns_kata == "verba"){
            $rules["vSaya"] = "required";
            $rules["vKami"] = "required";
            $rules["vKamu"] = "required";
            $rules["vDia"] = "required";
            $rules["vMereka"] = "required";
        }

        $dataKamus = $request->validate($rules);

        KataModel::create($dataKamus);

        return redirect('/dashboardKamus')->with("success", "Succesfully added Word!");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KataModel  $kataModel
     * @return \Illuminate\Http\Response
     */
    public function show(KataModel $kataModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KataModel  $kataModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kamus = KataModel::firstWhere('id', $id);
        // dd($kamus);
        return view("dashboardKamus.edit", [
            "word" => $kamus
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KataModel  $kataModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kamus = KataModel::firstWhere('id', $id);
        // dd($request);
        $rules = [
            "kataIndo" => "required",
            "kataMuna" => "required",
            "jns_kata" => "required"
        ];

        if($request->jns_kata == "verba"){
            $rules["vSaya"] = "required";
            $rules["vKami"] = "required";
            $rules["vKamu"] = "required";
            $rules["vDia"] = "required";
            $rules["vMereka"] = "required";
        }

        $dataKamus = $request->validate($rules);

        $kamus->update($dataKamus);

        return redirect('/dashboardKamus')->with("success", "Succesfully updated Word!");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KataModel  $kataModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kamus = KataModel::firstWhere('id', $id);
        $kamus->delete();

        return redirect('/dashboardKamus')->with('success', 'Word has been deleted!');
    }
}
