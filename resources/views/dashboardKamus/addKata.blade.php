@extends('dashboardKamus.layout.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Kata</h1>
    </div>

    <div class="col-lg-5 mb-5">

        <form action="{{route("kamus.store")}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="kataIndo" class="form-label">Indonesia</label>
                <input type="text" class="form-control @error('kataIndo') is-invalid @enderror" id="kataIndo" placeholder="kata Indonesia" name="kataIndo" value="{{old("kataIndo")}}">
                @error('kataIndo')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kataMuna" class="form-label">Muna</label>
                <input type="text" class="form-control @error('kataMuna') is-invalid @enderror" id="kataMuna" placeholder="kata Muna" name="kataMuna" value="{{old("kataMuna")}}">
                @error('kataMuna')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jns_kata" class="form-label">Jenis Kata</label>
                <select class="form-select @error('jns_kata') is-invalid @enderror" id="jns_kata" aria-label="Default select example" name="jns_kata">
                    <option value="noun" selected>noun</option>
                    <option value="pronoun">pronoun</option>
                    <option value="kedua">kedua</option>
                    <option value="adverb">adverb</option>
                    <option value="sambung">sambung</option>
                    <option value="tanda">tanda</option>
                    <option value="angka">angka</option>
                    <option value="verba">verba</option>
                </select>
                @error('jns_kata')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vSaya" class="form-label">Verba Saya</label>
                <input type="text" class="form-control @error('vSaya') is-invalid @enderror" id="vSaya" placeholder="verba saya" name="vSaya" value="{{old("vSaya")}}">
                @error('vSaya')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide"> 
                <label for="vKami" class="form-label">Verba Kami</label>
                <input type="text" class="form-control @error('vKami') is-invalid @enderror" id="vKami" placeholder="verba kami" name="vKami" value="{{old("vKami")}}">
                @error('vKami')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vKamu" class="form-label">Verba Kamu</label>
                <input type="text" class="form-control @error('vKamu') is-invalid @enderror" id="vKamu" placeholder="verba kamu" name="vKamu" value="{{old("vKamu")}}">
                @error('vKamu')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vDia" class="form-label">Verba Dia</label>
                <input type="text" class="form-control @error('vDia') is-invalid @enderror" id="vDia" placeholder="verba dia" name="vDia" value="{{old("vDia")}}">
                @error('vDia')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vMereka" class="form-label">Verba Mereka</label>
                <input type="text" class="form-control @error('vMereka') is-invalid @enderror" id="vMereka" placeholder="verba mereka" name="vMereka" value="{{old("vMereka")}}">
                @error('vMereka')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-dark text-warning border-0 mt-2">Add Kata</button>
            </div>
        </form>

    </div>
@endsection