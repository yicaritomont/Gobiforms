@extends('layouts.master-mini')

@section('content')
<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: url({{ url('assets/images/auth/login_3.jpg') }}); background-size: cover;">
    <div class="row w-100">
        <div class="col-lg-4 mx-auto">
            @if (session('message'))
                <div class="alert alert-{{session('alert')}}" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            <div class="auto-form-wrapper">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div style="width: 50%;margin: 0 auto;padding-bottom: 10%;">                       
                            <img src="{{url('assets/images/logo_2.jpg')}}"></img>
                    </div>
                    <div class="form-group">
                        <label class="label">Número de Documento</label>
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" placeholder="Correo electrónico">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label">Constraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder="*********">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-dark btn-rounded submit-btn btn-block btn-index">Acceder</button>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <div class="form-check form-check-flat mt-0">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" checked> Mantener mi sesión </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-small forgot-password text-black">Olvidé mi contraseña</a>
                    </div>
                    <div class="text-block text-center my-3">
                        <span class="text-small font-weight-semibold">¿No está registrado?</span>
                        <a href="{{ url('/register') }}" class="text-black text-small">Regístrese aquí</a>
                    </div>
                </form>
            </div>
            
            <p class="footer-text text-center text-black">:)</p>
        </div>
    </div>
</div>
<!--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection
