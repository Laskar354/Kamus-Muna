@extends('layout.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="my-3">Kamus Indonesia - Muna</h1>
            <h6 class="mb-3 text-dark">Usahakan gunakan kalimat yang sederhana dan berpola SPO atau SPOK</h6>
            <h6 class="mb-3 text-dark">Contoh : Saya(subjek) pergi(predikat) ke pasar(objek)</h6>
            <h6 class="mb-3 text-dark">Contoh : Mereka(subjek) makan(predikat) nasi(objek) di dapur(keterangan)</h6>
            <form action="" id="formTranslateIndo">
                <div class="form-outline">
                    <textarea class="form-control" name="translateIndo" id="translateIndo" rows="5" placeholder="Masukkan kalimat yang ingin diterjemahkan !"></textarea>
                </div>
                <button type="submit">Terjemahkan</button>
            </form>

                <div class="textarea-wrapper mt-4">
                    <input id="translate" class="form-control" readonly>

                    <button id="copy-button" type="cop" class="btn btn-primary copy-button rounded-2 " data-clipboard-target="#translate"><i class="bi bi-clipboard2-check"></i></button>
                </div>

        </div>
    </div>
@endsection