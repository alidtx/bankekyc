<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from freebw.com/templates/insurance/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jun 2020 05:40:01 GMT -->
<head>
    <meta charset="UTF-8">
    <title>e-KYC Admin Login</title>
    <meta name="referrer" content="no-referrer">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <!--Styles-->
    <link href="{{asset('customer_theme/vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('customer_theme/vendor/animate.css/animate.min.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('customer_theme/vendor/jQuery.mmenu/dist/css/jquery.mmenu.all.css')}}" rel="stylesheet"> -->
    <link href="{{asset('customer_theme/assets/css/pages/users/login-3.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('customer_theme/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('customer_theme/assets/css/style.bundle.css')}}" rel="stylesheet"> -->
 
    <!-- Fonts-->
    <!-- <link href="{{asset('customer_theme/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('customer_theme/fonts/Linearicons-Free-v1.0.0/style.css')}}" rel="stylesheet"> -->

    <!--Theme style-->
    <link href="{{asset('customer_theme/css/custom.min.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Header main-->
    <header> 
        <div class="header-main">
            <div class="container">
                <div class=" ">
                    <a href="/agent/login">
              
                        <img class="img-responsive" src="/customer_theme/img/logo.png" alt="Logo" style="margin: 0 auto;width: 150px;padding: 8px;"/>
                    </a>
                </div>
               
            </div>
        </div>
     
     
    </header>
    <!-- End header main-->
    <div class="page-content home-page-1">
    	 
            <div class="d-flex flex-column flex-root login-form">
                <!--begin::Login-->
                <div class="login login-signin-on login-3 d-flex flex-row-fluid " id="kt_login">
                    <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat bg-white">
                        <div class="login-form text-center p-7 position-relative overflow-hidden">
                            <!--begin::Login Header-->
                           
                            <!--end::Login Header-->
                            <!--begin::Login Sign in form-->
                            <div class="login-signin">
                                <div class="mb-10">
                                    <h2>e-KYC Admin Login</h2>
                                    <div class="text-muted font-weight-bold">Enter your login details:</div>
                                </div>
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                
                                    <div class="form-group mb-5">

                                        <input id="email" type="email" class="form-control h-auto form-control-solid py-4 px-8 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-5">
                                        <input id="password" type="password" class="form-control h-auto form-control-solid py-4 px-8 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                                        <label class="checkbox m-0 text-muted">
                                        <input type="checkbox" name="remember" id="remember" class="remember" {{ old('remember') ? 'checked' : '' }}/>Remember me

                                        <span></span></label>
                                        <a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a>
                                    </div>
                                <a href="deposit-form.html"><button id=" " class="btn btn-primary font-weight-bold px-9 my-3 mx-4">Sign In</button></a>	
                                </form>
                               
                            </div>
                            <!--end::Login Sign in form-->
                       
                            <!--begin::Login forgot password form-->
                            <div class="login-forgot">
                                <div class="mb-8">
                                    <h3>Forgotten Password ?</h3>
                                    <div class="text-muted font-weight-bold">Enter your email to reset your password</div>
                                </div>
                                <form class="form mb-0">
                                    <div class="input-group mb-10 ">
                                        <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off" />
                                    </div>
                                    <div class="form-group d-flex flex-wrap flex-center mt-10 mb-2">
                                        <button id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9  mx-2">Request</button>
                                        <button id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 mx-2">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <!--end::Login forgot password form-->
                        </div>
                    </div>
                </div>
                <!--end::Login-->
            </div>
            
    <!--Scripts-->
    </div>
 <!-- FOOTER-->
 <footer> 
     <div class="sub-footer">
        <div class="container">
            <p class="copyright mb-0">Copyright © 2020. All rights reserved.</p> 
        </div>
    </div>
</footer>
<!-- END FOOTER-->
<!--     <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="vendor/jquery/dist/jquery.min.js"></script> -->
    <script src="{{asset('customer_theme/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('customer_theme/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- <script src="{{asset('customer_theme/jQuery.mmenu/dist/js/jquery.mmenu.min.umd.js')}}"></script> -->
    <!-- <script src="{{asset('customer_theme/js/mmenu-function.js')}}"></script> -->
    <!-- <script src="{{asset('customer_theme/js/revo-custom.js')}}"></script> -->
    <!-- <script src="{{asset('customer_theme/vendor/matchHeight/dist/jquery.matchHeight-min.js')}}"></script> -->
    <!-- <script src="{{asset('customer_theme/js/match-height-custom.js')}}"></script> -->
    <!-- <script src="{{asset('customer_theme/js/custom.js')}}"></script> -->

    <!--end::Main-->
 
    <!--begin::Global Config(global config for global JS scripts)-->
   
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <!-- <script src="{{asset('customer_theme/assets/plugins/global/plugins.bundle.js')}}"></script> -->
    <!-- <script src="{{asset('customer_theme/assets/js/scripts.bundle.js')}}"></script> -->
    <script src="{{asset('customer_theme/assets/js/pages/custom/login/login.js')}}"></script>
    
    <!--End script-->
</body>

</html>