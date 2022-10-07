@extends('layout.master2')
<style>
    #ForgotPassword{
        font-size: 13px !important;
    }
</style>
@section('content')
<div class="page-content  align-items-center justify-content-center" style="background:#101920">
    <img src="{{ asset('assets/images/logo.png') }}" width="100px" style="display:block;margin:auto; margin-bottom:35px">
    <div>
        <span style="text-align: center;color:white; font-family: 'akira'; font-size:18px;"><h1 style="font-size:18px">LOGIN TO</h1></span>
        <span  style="text-align: center;color:#E09946; font-family: 'akira'; font-size:22px; "><h1 style="font-size:22px">WIZZ LOGISTICS</h1></span>
        <div class="row w-100 mx-0 auth-page" style="margin-top:35px">
            <div class="col-lg-4 col-md-9 col-xl-4 mx-auto" >
                <div class="card" style="background: #172128; border: 1px solid #262F36; border-radius: 10px;box-shadow:none;">
                    <div class="row">
                        <div class="col-md-12 col-xl-12 pl-md-0">
                            <div class="auth-form-wrapper px-5 py-5">
                                <a href="#" class="text-center noble-ui-logo d-block ">
                                </a>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Name</label>
                                        <input id="name" name="name" type="name" required placeholder="Enter your name" style="color:white;background:#101920;border: 1px solid #262F36;border-radius: 5px;height:45px;" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" style="font-size:13px;" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Email</label>
                                        <input id="email" name="email" type="email" required placeholder="Enter your email" style="color:white;background:#101920;border: 1px solid #262F36;border-radius: 5px;height:45px;" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" style="font-size:13px;" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Password</label>
                                        <label id="ForgotPassword" style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px; float:right;"><a href="{{url('/forgot-password')}}" style="color:#E09946">Forget Password?</a></label>
                                        <input id="password" type="password" name="password" required placeholder="Enter your password" style="margin-bottom: 20px; background:#101920;border: 1px solid #262F36; border-radius: 5px; height:45px" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                        

                                    <div class="form-group">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-bottom: 10px;">Account Type</label>
                                        <div class="form-check form-check-inline">
                                          <label class="form-check-label" style="color:white;">
                                            <input type="radio" class="form-check-input" name="optionsRadios5" id="optionsRadios6" value="option5">
                                            Default
                                          </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" style="color:white;">
                                              <input type="radio" class="form-check-input" name="optionsRadios5" id="optionsRadios6" value="option5">
                                              Default
                                            </label>
                                        </div>
                                    </div>


                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary btn-block" style=" background:#E09946;  border: 1px solid #FFBF74; border-radius: 5px; box-shadow:none; color:#172128; height:45px; font-family:'akira'; font-size:18px">Login</button>
                                    </div>
                                    <div style="padding-bottom: 0px;">
                                        <label style="font-family:Montserrat;color: white;font: size 16px; margin-top: 34px; text-align: center;width:100%; marin-bottom:0px;">Don't have an account?<a href="{{url('/register')}}" style="color:#E09946"> Register New</a></label>
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
