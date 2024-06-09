<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.2.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
* template implement with laravel by Md Rana Hossain and Md Nazmul Hossain
-->
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="e-KYC">
    <meta name="author" content="e-KYC">
    <meta name="keyword" content="e-KYC">
    <title>e-KYC</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/v-select/v-select.min.css')}}">

@yield('lib-css')
@stack('custom-css')
<!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');
    </script>
    <link href="{{asset('vendors/@coreui/chartjs/css/coreui-chartjs.css')}}" rel="stylesheet">
</head>
<body class="c-app">
    <div id="loading">
        <div class="image-load">
            <img src="/customer_theme/img/icons/Marty.gif" alt="loader" />
        </div>
    </div>
@section('sidebar')
    @include('layout.admin.sidebar')
@show
<div class="c-wrapper c-fixed-components">
    @section('header')
        @include('layout.admin.header')
    @show
    <div class="c-body">
        @yield('content')
        @section('footer')
            @include('layout.admin.footer')
        @show
    </div>
    @include('layout.admin.change_password')
</div>
<!-- CoreUI and necessary plugins-->
<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<!--[if IE]><!-->
<script src="{{asset('vendors/@coreui/icons/js/svgxuse.min.js')}}"></script>
<!--<![endif]-->
<!-- Plugins and scripts required by this view-->
<script src="{{asset('vendors/@coreui/chartjs/js/coreui-chartjs.bundle.js')}}"></script>
<script src="{{asset('vendors/@coreui/utils/js/coreui-utils.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/vuejs/vuejs-dev.js')}}"></script>
<script src="{{asset('js/axios/axios.min.js')}}"></script>
<script src="{{asset('js/vuejs/vee-validation.js')}}"></script>
<script src="{{asset('js/sweet-alert.min.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('js/v-select/v-select.min.js')}}"></script>
<script>

    $(window).on('load', function () {
        $('#loading').fadeOut(500);
    });

    $(".select2").select2();

    VeeValidate.extend('required', {
        validate(value, args) {
            return {
                required: true,
                valid: ['', null, undefined].indexOf(value) === -1
            };
        },
        computesRequired: true
    });
    Vue.component('validation-observer', VeeValidate.ValidationObserver);
    // Register the component globally.
    Vue.component('validation-provider', VeeValidate.ValidationProvider);

    Vue.component('v-select', VueSelect.VueSelect);
    window.$ = $;
    window.ajaxCall = (api, data, method, callback, alert = false, base_url = '') => {
        (async () => {
            await axios[method](base_url + api, {
                ...data
            })
                .then(response => this.responseProcess(response.data, alert, (data, code) => callback(data, code)))
                .catch(function (error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        // text: error.data.message || 'Something went wrong! please try again later',
                        text: 'Something went wrong! please try again later',
                    });
                })
        })();

    };
    window.responseProcess = (response, alert, callback) => {
        {
            if(typeof response.message == 'object'){
                response.message = response.message[0];
            }
            console.log(response.message);
            if (response.status === 'success' || response.code === 200) {
                if (alert)
                    Swal.fire({
                        icon: 'success',
                        title: 'Yahoo..',
                        text: response.message || 'Form stored successfully',
                    });
            } else {
                if (alert)
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Something went wrong! please try again later',
                    });
            }
            callback(response.data, response.code);
        }
    };
    $(".modal").on("hidden.bs.modal", function(){
        $(".modal-body1").html("");
    });
</script>
@yield('lib-js')
@stack('custom-js')
</body>
</html>
