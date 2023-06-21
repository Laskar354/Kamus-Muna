@extends('dashboardKamus.layout.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Kata</h1>
    </div>

    <div class="col-lg-5 mb-5">

        <form action="{{route("kamus.update", $word->id)}}" method="post">
            @method("put")
            @csrf
            <div class="mb-3">
                <label for="kataIndo" class="form-label">Indonesia</label>
                <input type="text" class="form-control @error('kataIndo') is-invalid @enderror" id="kataIndo" placeholder="kata Indonesia" name="kataIndo" value="{{old("kataIndo", $word->kataIndo)}}">
                @error('kataIndo')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kataMuna" class="form-label">Muna</label>
                <input type="text" class="form-control @error('kataMuna') is-invalid @enderror" id="kataMuna" placeholder="kata Muna" name="kataMuna" value="{{old("kataMuna", $word->kataMuna)}}">
                @error('kataMuna')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jns_kata" class="form-label">Jenis Kata</label>
                <select class="form-select @error('jns_kata') is-invalid @enderror" id="jns_kata" aria-label="Default select example" name="jns_kata">
                    <option value="noun" {{$word->jns_kata == "noun" ? "selected" : ""}}>noun</option>
                    <option value="pronoun" {{$word->jns_kata == "pronoun" ? "selected" : ""}}>pronoun</option>
                    <option value="kedua" {{$word->jns_kata == "kedu" ? "selected" : ""}}>kedua</option>
                    <option value="adverb" {{$word->jns_kata == "adverb" ? "selected" : ""}}>adverb</option>
                    <option value="sambung" {{$word->jns_kata == "sambung" ? "selected" : ""}}>sambung</option>
                    <option value="tanda" {{$word->jns_kata == "tanda" ? "selected" : ""}}>tanda</option>
                    <option value="angka" {{$word->jns_kata == "angka" ? "selected" : ""}}>angka</option>
                    <option value="verba" {{$word->jns_kata == "verba" ? "selected" : ""}}>verba</option>
                </select>
                @error('jns_kata')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vSaya" class="form-label">Verba Saya</label>
                <input type="text" class="form-control @error('vSaya') is-invalid @enderror" id="vSaya" placeholder="verba saya" name="vSaya" value="{{old("vSaya", $word->vSaya)}}">
                @error('vSaya')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide"> 
                <label for="vKami" class="form-label">Verba Kami</label>
                <input type="text" class="form-control @error('vKami') is-invalid @enderror" id="vKami" placeholder="verba kami" name="vKami" value="{{old("vKami", $word->vKami)}}">
                @error('vKami')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vKamu" class="form-label">Verba Kamu</label>
                <input type="text" class="form-control @error('vKamu') is-invalid @enderror" id="vKamu" placeholder="verba kamu" name="vKamu" value="{{old("vKamu", $word->vKamu)}}">
                @error('vKamu')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vDia" class="form-label">Verba Dia</label>
                <input type="text" class="form-control @error('vDia') is-invalid @enderror" id="vDia" placeholder="verba dia" name="vDia" value="{{old("vDia", $word->vDia)}}">
                @error('vDia')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3 hide">
                <label for="vMereka" class="form-label">Verba Mereka</label>
                <input type="text" class="form-control @error('vMereka') is-invalid @enderror" id="vMereka" placeholder="verba mereka" name="vMereka" value="{{old("vMereka", $word->vMereka)}}">
                @error('vMereka')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-dark text-warning border-0 mt-2">Update Kata</button>
            </div>
        </form>

    </div>
@endsection