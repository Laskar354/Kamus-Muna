@extends('layout.main')

@section('container')
    <div class="row justify-content-center mt-3">
        <div class="col-lg-6">
            <main class="form-signin">

                @if(session()->has("success"))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session()->has("loginErrors"))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{session('loginErrors')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="/translate/loginAdmin" method="post">
                    @csrf
                    <h1 class="h3 mb-3 fw-normal text-center fw-bold mb-3">Form Login Admin</h1>
                
                    <div class="form-floating">
                        <input type="email" value="{{old("email")}}" class="form-control @error("email") is-invalid @enderror" id="email" placeholder="name@example.com" name="email" required autofocus>
                        <label for="email">Email address</label>
                        @error('email')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control @error("password") is-invalid @enderror" id="password" placeholder="Password" name="password">
                        <label for="password">Password</label>
                        @error('password')
                            {{$message}}
                        @enderror
                    </div>
                    <button class="w-100 btn btn-lg btn-dark mt-3 text-warning" type="submit">Sign in</button>
                </form>

            </main>
        </div>
    </div>
@endsection