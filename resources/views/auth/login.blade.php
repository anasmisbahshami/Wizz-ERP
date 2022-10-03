@extends('layout.master2')

@section('content')
<div class="page-content  align-items-center justify-content-center" style="background:#101920">
    <img src="{{ asset('assets/images/logo.png') }}" width="100px" style="display:block;margin:auto; margin-bottom:35px">
    <div >
        <span style="text-align: center;color:white; font-family: 'akira'; font-size:18px;"><h1 style="font-size:18px">LOGIN TO</h1></span>
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
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Enter your Your Email</label>
                                        <input id="email" type="email" placeholder="Enter your Email" style="margin-bottom: 35px; background:#101920;  border: 1px solid #262F36; border-radius: 5px;box-shadow:none; color:white; height:45px" 
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
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px; float:right;"><a href="" style="color:#E09946">Forget Password?</a></label>
                                        <input id="password" type="password" placeholder="Password" style="margin-bottom: 35px; background:#101920;  border: 1px solid #262F36; border-radius: 5px;box-shadow:none; color:white; height:45px"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            Remember me
                                        </label>
                                    </div> -->
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary btn-block" style=" background:#E09946;  border: 1px solid #FFBF74; border-radius: 5px; box-shadow:none; color:#172128; height:45px; font-family:'akira'; font-size:18px">Login</button>
                                        
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
