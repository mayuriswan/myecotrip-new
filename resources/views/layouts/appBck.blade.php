<!DOCTYPE HTML>
<html>
<head>
    <title>Myecotrip @yield('title')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon"/>

    @yield('meta')
    <!-- <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="Myecotrip - Ecotrial booking, KEDB Booking, Event Boooking, Bird festivals">
    <meta name="author" content="Myecotrip">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

    <!-- GOOGLE FONTS -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/mystyles.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/myecotrip.css') }} ">
    <script src="{{asset('assets/js/modernizr.js') }} "></script>

    <link rel="stylesheet" href="{{ asset('assets/css/switcher.css') }} " />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/bright-turquoise.css') }} " title="bright-turquoise" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/turkish-rose.css') }} " title="turkish-rose" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/salem.css') }} " title="salem" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/hippie-blue.css') }} " title="hippie-blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/mandy.css') }} " title="mandy" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/green-smoke.css') }} " title="green-smoke" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/horizon.css') }} " title="horizon" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/cerise.css') }} " title="cerise" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/brick-red.css') }} " title="brick-red" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/de-york.css') }} " title="de-york" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/shamrock.css') }} " title="shamrock" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/studio.css') }} " title="studio" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/leather.css') }} " title="leather" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/denim.css') }} " title="denim" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="{{ asset('assets/css/schemes/scarlet.css') }} " title="scarlet" media="all" />

    <script type="text/javascript">
        if (location.protocol != 'https:')
        {
         location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
        }
    </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WLJNP8D');</script>
    <!-- End Google Tag Manager -->
    
    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-105078987-1', 'auto');
      ga('send', 'pageview');

    </script>


</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WLJNP8D"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
    <!-- End Google Tag Manager (noscript) -->

    <div>
        @yield('content')
    </div>    

    <!--Footer  -->
    @include('layouts.footer')


    <script src="{{asset('assets/js/jquery.js') }} "></script>
    <script src="{{asset('assets/js/bootstrap.js') }} "></script>
    <script src="{{asset('assets/js/slimmenu.js') }} "></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.js') }} "></script>
    <script src="{{asset('assets/js/bootstrap-timepicker.js') }} "></script>
    <script src="{{asset('assets/js/nicescroll.js') }} "></script>
    <script src="{{asset('assets/js/dropit.js') }} "></script>
    <script src="{{asset('assets/js/ionrangeslider.js') }} "></script>
    <script src="{{asset('assets/js/icheck.js') }} "></script>
    <script src="{{asset('assets/js/fotorama.js') }} "></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
    <script src="{{asset('assets/js/typeahead.js') }} "></script>
    <script src="{{asset('assets/js/card-payment.js') }} "></script>
    <script src="{{asset('assets/js/magnific.js') }} "></script>
    <script src="{{asset('assets/js/owl-carousel.js') }} "></script>
    <script src="{{asset('assets/js/fitvids.js') }} "></script>
    <script src="{{asset('assets/js/tweet.js') }} "></script>
    <script src="{{asset('assets/js/countdown.js') }} "></script>
    <script src="{{asset('assets/js/gridrotator.js') }} "></script>
    <script src="{{asset('assets/js/custom.js') }} "></script>
    <script src="{{asset('assets/js/switcher.js') }} "></script>
    <script src="{{asset('assets/js/myecotrip.js') }} "></script>

    <script type="text/javascript">

    $('#confirm_password').on("change", function () {
        var password = $('#password').val();
        var confPass = $('#confirm_password').val();

        if(password != confPass) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    });
    </script>

    @if(!empty(Session::get('message')))
        <script>
        $(function() {
            $('#myModal').modal('show');
        });
        </script>
    @endif
</body>


<!-- Mirrored from remtsoy.com/tf_templates/traveler/demo_v1_7/index-7.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 30 Jul 2017 10:41:23 GMT -->
</html>



