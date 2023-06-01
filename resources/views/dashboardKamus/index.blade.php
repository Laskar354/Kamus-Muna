@extends('dashboardKamus.layout.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Kamus Indonesia Muna : {{ auth()->user()->name }}</h1>
    </div>

    <div class="col-lg-10">
        @if (session()->has("success"))
            <div class="alert alert-info" role="alert">
                {{session('success')}}
            </div>
        @endif
    </div>

    <a href="/dashboardKamus/create" class="text-decoration-none btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Add Kata</a>

    <div class="table-responsive col-lg-10">
        <table class="table table-striped table-sm">

            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Indonesia</th>
                <th scope="col">Muna</th>
                <th scope="col">Jenis Kata</th>
                <th scope="col">Verba Saya</th>
                <th scope="col">Verba Kami</th>
                <th scope="col">Verba Kamu</th>
                <th scope="col">Verba Dia</th>
                <th scope="col">Verba Mereka</th>
                <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($words as $word)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$word->kataIndo}}</td>
                    <td>{{$word->kataMuna}}</td>
                    <td>{{$word->jns_kata}}</td>
                    <td>{{$word->vSaya}}</td>
                    <td>{{$word->vKami}}</td>
                    <td>{{$word->vKamu}}</td>
                    <td>{{$word->vDia}}</td>
                    <td>{{$word->vMereka}}</td>
                    <td class="justify-content-center d-flex">
                        {{-- Route itu bisa menggunakan route.name atau route saja --}}
                        <a href="{{route("kamus.edit", $word->id)}}" class="badge bg-warning mx-2 border-0 text-decoration-none">Edit</a>
                        <form action="{{route("kamus.delete", $word->id)}}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" onclick="return confirm('Yakin tod?')" class="badge bg-danger border-0">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection

{{-- <span data-feather="trash-2"></span> <span data-feather="edit"> --}}