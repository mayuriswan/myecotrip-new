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

    <!-- Captcha  -->
    <script src='https://www.google.com/recaptcha/api.js'></script>


    <!-- /GOOGLE FONTS -->
    <script src="{{asset('assets/js/modernizr.js') }} "></script>
    <link rel="stylesheet" href="{{ asset('assets/css/customCalander.css') }} ">

    <link rel="stylesheet" href="{{ asset('assets/css/myecotrip.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/myecotrip.css') }} ">

    <!-- <link rel="stylesheet" href="{{ asset('assets/css/switcher.css') }} " /> -->


    <!-- <script type="text/javascript">
        if (location.protocol != 'https:')
        {
         location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
        }
    </script> -->

    <!-- Google Tag Manager -->
    <!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WLJNP8D');</script> -->
    <!-- End Google Tag Manager -->

    <!-- Google Analytics -->
    <!-- <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-105078987-1', 'auto');
      ga('send', 'pageview');

    </script>

 -->
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


    <script src="{{asset('assets/js/myecotrip.min.js') }} "></script>
    <script src="{{asset('assets/js/custom.js') }} "></script>
    <script src="{{asset('assets/js/myecotrip.js') }} "></script>
    <script src="{{asset('assets/js/customCalander.js') }} "></script>

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

    <script type="text/javascript">

    $('#newPassword2').on("change", function () {
        var password = $('#newPassword').val();
        var confPass = $('#newPassword2').val();

        if(password != confPass) {
            newPassword2.setCustomValidity("Passwords Don't Match");
        } else {
            newPassword2.setCustomValidity('');
        }
    });
    </script>

    <!-- Request user to login model -->
    @if(!empty(Session::get('message')))
        <script>
        $(function() {
            $('#myModal').modal('show');
        });
        </script>
    @endif

    @if(!empty(Session::get('sentOtp')))
        <script>
        $(function() {
            $('#myModal2').modal('show');
        });
        </script>
    @endif

    <!-- Social login get user mobile number -->
    @if(!empty(Session::get('getPhoneNumber')))
        <script>
        $(function() {
            $('#myModal3').modal('show');
        });
        </script>
    @endif

    <!-- User password reset-->
    <script type="text/javascript">

    function openLoginModal() {
        $('#myModal').modal('show');
    }

    $('#resetPassword2').on("change", function () {
        var password = $('#resetPassword').val();
        var confPass = $('#resetPassword2').val();

        if(password != confPass) {
            resetPassword2.setCustomValidity("Passwords Don't Match");
        } else {
            resetPassword2.setCustomValidity('');
        }
    });
    </script>

    @if(count($_GET) > 0 && isset($_GET['reset']) && $_GET['reset'] == 'true')
        <script>
        $(function() {
            $('#resetPasswordModal').modal('show');
        });
        </script>
    @endif

    <!-- Train Booking check in date -->
    <script type="text/javascript">
        $(document).ready(function(){
            var currentD = new Date();
            var startHappyHourD = new Date();
            startHappyHourD.setHours(10,0,0);

            if(currentD >= startHappyHourD){
                console.log('Next day booking')
                $('input.date-pick, .input-daterange2 input[name="start"]').datepicker({
                    startDate :'+1d',
                    // todayHighlight: true,
                    autoclose:true,
                    endDate: '+15d',
                    format: 'yyyy-mm-dd',
                });
            }else{
                console.log('Today booking')
                $('input.date-pick, .input-daterange2 input[name="start"]').datepicker({
                    startDate : new Date(),
                    // todayHighlight: true,
                    autoclose:true,
                    endDate: '+15d',
                    format: 'yyyy-mm-dd',
                });
            }


            $('#start').on('input', function(e){
                document.getElementById('start').value = '';
            });
        });
    </script>

<!-- Jungle Stay -->
<script type="text/javascript">
// $("#submit").click(function() {
//     var count_checked = $("[name='selectedRooms[]']:checked").length; // count the checked rows
//         if(count_checked == 0)
//         {
//             alert("Please select at least one room");
//             return false;
//         }else{
//             return $( "#jsForm" ).submit();
//
//         }
//
// });

    $(document).ready(function(){
        var currentD = new Date();
        var startHappyHourD = new Date();
        startHappyHourD.setHours(12,0,0);

        if(currentD >= startHappyHourD){
            // console.log('Next day booking')
            $('.input-daterange input[name="checkIn"]').datepicker({
                startDate :'+1d',
                todayHighlight: true,
                autoclose:true,
                endDate: '+3m',
                format: 'yyyy-mm-dd',
            }).on("changeDate", function(e) {
                $('.checkOut').removeAttr('disabled');
                $('.checkOut').val('');
                var checkInDate = e.date;
                var $checkOut = $(".checkOut");

                var newCheckInDate = new Date(checkInDate)
                newCheckInDate.setDate(newCheckInDate.getDate() + 1)

                var newCheckOutDate = new Date(checkInDate)
                newCheckOutDate.setDate(newCheckOutDate.getDate() + 7)

                $checkOut.datepicker("setStartDate", newCheckInDate);
                $checkOut.datepicker("setEndDate", newCheckOutDate);
                $checkOut.datepicker("setDate", checkInDate).focus();
              });

        }else{
            // console.log('Today booking')
            $('.input-daterange input[name="checkIn"]').datepicker({
                startDate : new Date(),
                todayHighlight: true,
                autoclose:true,
                endDate: '+3m',
                format: 'yyyy-mm-dd',
            }).on("changeDate", function(e) {
                $('.checkOut').removeAttr('disabled');
                $('.checkOut').val('');
                var checkInDate = e.date;
                var $checkOut = $(".checkOut");

                var newCheckInDate = new Date(checkInDate)
                newCheckInDate.setDate(newCheckInDate.getDate() + 1)

                var newCheckOutDate = new Date(checkInDate)
                newCheckOutDate.setDate(newCheckOutDate.getDate() + 7)

                $checkOut.datepicker("setStartDate", newCheckInDate);
                $checkOut.datepicker("setEndDate", newCheckOutDate);
                $checkOut.datepicker("setDate", checkInDate).focus();
              });
        }

        $('.input-daterange input[name="checkOut"]').datepicker({
          format: "yyyy-mm-dd",
          todayHighlight: true,
          autoclose: true
        });

    });

    function incrementValue(e) {
      e.preventDefault();
      var fieldName = $(e.target).data('field');
      var parent = $(e.target).closest('div');
      var currentVal = parseInt(parent.find('input[name="' + fieldName + '"]').val(), 10);
      var maxVal = parseInt(parent.find('input[name="' + fieldName + '"]').attr('max'), 10);

      // var max = parseInt($(this).attr('max'));

      if (!isNaN(currentVal)) {
        var newValue = currentVal + 1;
        if (maxVal >= newValue) {
            parent.find('input[name="' + fieldName + '"]').val(currentVal + 1);
        }
      } else {
        parent.find('input[name="' + fieldName + '"]').val(0);
      }
    }

    function decrementValue(e) {
      e.preventDefault();
      var fieldName = $(e.target).data('field');
      var parent = $(e.target).closest('div');
      var currentVal = parseInt(parent.find('input[name="' + fieldName + '"]').val(), 10);


      if (!isNaN(currentVal) && currentVal > 0) {
        parent.find('input[name="' + fieldName + '"]').val(currentVal - 1);
      } else {
        parent.find('input[name="' + fieldName + '"]').val(0);
      }
    }

    $('.input-group').on('click', '.button-plus', function(e) {
      incrementValue(e);
    });

    $('.input-group').on('click', '.button-minus', function(e) {
      decrementValue(e);
    });

    $( "#jsRoomsForm" ).submit(function( event ) {
        var hasInput=false;
         $('.quantity-field').each(function () {
              if($(this).val()  != 0){
                  hasInput=true;
              }
         });

         if(!hasInput){
             alert("You have to selct at least one Jungle Stay.");
             event.preventDefault();
          }
    });

    $( "#jsFormGuests" ).submit(function( event ) {
        var hasAllAdultsData = false;

        var maxAdults = $('#maxAdults').val();
        var AdultsShown = $('#AdultsShown').val();

        if (parseInt(maxAdults)  !=  parseInt(AdultsShown)) {
            alert("Please do enter all " + maxAdults + " Adult details.");
            event.preventDefault();
            return false;
        }
    });

</script>

    <!-- Bird Sanctuary booking -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btn1").click(function(){
                var MyDiv1 = document.getElementById('entranceDiv');
                $("#divToAdd").append(MyDiv1.innerHTML);
            });

        });
    </script>

    @yield('script')

    
</body>
</html>
