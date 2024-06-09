<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from freebw.com/templates/insurance/services-detail-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jun 2020 05:40:58 GMT -->
<head>
    <meta charset="UTF-8">
    <title>Online Account Opening Form</title>
    <meta name="referrer" content="no-referrer">
    <meta name="description" content="Au theme template">
    <meta name="keywords" content="Au theme template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!--Styles-->
    <link href="{{asset('customer_theme/vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('customer_theme/vendor/animate.css/animate.min.css')}}" rel="stylesheet"> -->
    <link href="{{asset('customer_theme/vendor/jQuery.mmenu/dist/css/jquery.mmenu.all.css')}}" rel="stylesheet">

    <!-- SweetAlert2 -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css"> -->
  
    <!-- Fonts-->
    <link href="{{asset('customer_theme/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('customer_theme/fonts/Linearicons-Free-v1.0.0/style.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('customer_theme/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('customer_theme/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet"> -->
    <!-- <link href="{{asset('customer_theme/assets/css/style.bundle.min.css')}}" rel="stylesheet"> -->
    <!--Theme style-->
    <link href="{{asset('customer_theme/css/main.min.css')}}" rel="stylesheet">
    <link href="{{asset('customer_theme/css/custom.min.css')}}" rel="stylesheet">
    @yield('lib-css')
    @stack('custom-css')
</head>
<style>
    .card.card-custom > .card-body {
    padding: 2.5rem 2.25rem !important;
}
.post-services .post-services-detail-1 {
    margin-bottom: 30px !important;

}
</style>

<body>
    <!-- Header main-->
    <header> 
        <div id="loading">
            <div class="image-load">
                <img src="/customer_theme/img/icons/Marty.gif" alt="loader" />
            </div>
        </div>
        <nav id="mmenu">
            <ul>
                <li style="">
                    <a href="/kyc-form">Account</a> 
                </li>
                <li>
                    <a href="/kyc-form">Credit Card </a>
                </li>
                <li>
                    <a href="/kyc-form">Loan</a>
                </li>
               
                 
            </ul>
        </nav>
       
        <div class="header-main">
            <div class="container">
                <div class=" ">
                    <a href="index.html">
              
                        <img class="img-responsive" src="/customer_theme/img/logo.png" alt="Logo" style="margin: 0 auto;width: 150px;padding: 8px;"/>
                        <!-- <img class="img-responsive" src="/customer_theme/img/logo.jpg" alt="Logo" width="180px" style="margin: 0 auto"/> -->
                    </a>
                </div>
               
            </div>
        </div>
        <div class="navbar-main">
            <div class="container">
                <div class="navbar-holder">
                    <a class="navbar-toggle collapsed" href="#mmenu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <nav class="navbar-menu">
                        <ul class="menu text-center">
                            <li style="background: #003BDE;">
                                <a href="/kyc-form">Account</a> 
                            </li>
                            <li>
                                <a href="/kyc-form">Credit Card </a>
                            </li>
                            <li>
                                <a href="/kyc-form">Loan</a>
                            </li>
                          
                        </ul>
                      
                    </nav>
                   
                </div>
            </div>
        </div>
     
    </header>
   
    <section class="heading-page heading-services-detail-1" style="background: url(/customer_theme/img/slider/slider-2.jpg) center center no-repeat;">
        <div class="container">
            <!-- <ul class="au-breadcrumb">
                <li class="au-breadcrumb-item">
                    <a href="index.html">Home</a>
                </li>
                <li class="au-breadcrumb-item active">
                    <a href="index.html">Claim Insurance</a>
                </li>
            </ul> -->
            <div class="heading-title">
                <h1>Online Account Opening Form</h1>
            </div>
        </div>
    </section>
    <!-- END HEADING PAGE-->


@yield('content')


<!-- FOOTER-->
    <footer>
     
        <div class="sub-footer">
            <div class="container">
                <p class="copyright">Copyright © 2020. All rights reserved.</p> 
            </div>
        </div>
    </footer>
    <!-- END FOOTER-->
    <!--Scripts-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

    <script src="{{asset('customer_theme/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('customer_theme/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <script src="{{asset('customer_theme/vendor/jQuery.mmenu/dist/js/jquery.mmenu.min.umd.js')}}"></script>
    <script src="{{asset('customer_theme/vendor/jQuery.mmenu/dist/js/jquery.mmenu.min.umd.js')}}"></script>
    <script src="{{asset('customer_theme/js/mmenu-function.js')}}"></script>

    <script src="{{asset('customer_theme/js/custom.js')}}"></script>

    <!-- <script src="{{asset('customer_theme/assets/js/scripts.bundle.js')}}"></script> -->




  
    <!--End script-->

    <script>
        // Alert Modal Type
        $(document).ready(function () {
            if (!Modernizr.touch || !Modernizr.inputtypes.date) {
      $('input[type="date"]').each(function() {
        var defaultVal = $(this).val();
        console.log(this.name, defaultVal);
        $(this).attr('type', 'text')
          .val(moment(defaultVal).format('M/D/YYYY'))
          .datetimepicker({
            format: 'M/D/YYYY',
            // widgetParent: ???,
            widgetPositioning: {
              horizontal: "auto",
              vertical: "auto"
            }
          });
      });
    }

            $("#btn-success").click(function (e) {
                swal(
                  'Submitted',
                  'Your Form has been submitted <b style="color:green;">Successfully </b> !',
                  'success'
              )
            });

            $("#btn-error").click(function (e) {
              
              swal(
                'Cancelleed',
                'Form submission <b style="color:red;">Cancelled</b>!',
                'error'
            )
          });

        });
      
    </script>
    @yield('lib-js')
    @stack('custom-js')
</body>

</html>