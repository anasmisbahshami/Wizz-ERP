@extends('layout.master2')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 -->


































<div class="page-content  align-items-center justify-content-center" style="background:#101920">
    <img src="{{ asset('assets/images/logo.png') }}" width="100px" style="display:block;margin:auto; margin-bottom:35px">
    <div >
        <span style="text-align: center;color:white; font-family: 'akira'; font-size:18px;"><h1 style="font-size:18px">REGISTER TO</h1></span>
        <span  style="text-align: center;color:#E09946; font-family: 'akira'; font-size:22px; "><h1 style="font-size:22px">WIZZ LOGISTICS</h1></span>
    
        <div class="row w-100 mx-0 auth-page" style="margin-top:35px">
            
            <div class="col-lg-4 col-md-9 col-xl-3 mx-auto" >
                <div class="card" style="background: #172128; border: 1px solid #262F36; border-radius: 10px;box-shadow:none;">
                    
                    <div class="row">
                        <div class="col-md-12 col-xl-12 pl-md-0">
                            <div class="auth-form-wrapper px-5 py-5">
                                <a href="#" class="text-center noble-ui-logo d-block ">
                                </a>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Enter Full Name</label>
                                        <input id="email" type="email" placeholder="Full Name" style="margin-bottom: 35px; background:#101920;  border: 1px solid #262F36; border-radius: 5px;box-shadow:none; color:white; height:45px; font-family:Montserrat;" 
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Enter Email</label>
                                        <input id="email" type="email" placeholder="Email" style="margin-bottom: 35px; background:#101920;  border: 1px solid #262F36; border-radius: 5px;box-shadow:none; color:white; height:45px; font-family:Montserrat;" 
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Enter your Password</label>
                                        <input id="password" type="password" placeholder="Password" style="margin-bottom: 35px; background:#101920;  border: 1px solid #262F36; border-radius: 5px;box-shadow:none; color:white; height:45px; font-family:Montserrat;"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                        
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary btn-block" style=" background:#E09946;  border: 1px solid #FFBF74; border-radius: 5px; box-shadow:none; color:#172128; height:45px; font-family:'akira'; font-size:18px">Register</button>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
