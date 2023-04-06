@extends('layout.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-lg-4">

            <h1 class="my-3">Kamus Indonesia - Muna</h1>

            <form action="" id="formKamus">
                <input type="text" id="kataIndo" placeholder="Masukkan kata" name="kataIndo">
                <button id="btnKamus" type="submit">Terjemahkan</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div id="arti" class="form-control"></div>

        </div>
    </div>
@endsection