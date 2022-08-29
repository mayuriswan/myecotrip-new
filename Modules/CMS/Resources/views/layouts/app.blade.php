<html>
    <head>
        <title>Myecotrip Admin</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('assets/Admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{ asset('assets/Admin/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('assets/Admin/dist/css/sb-admin-2.css') }}" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="{{ asset('assets/Admin/vendor/morrisjs/morris.css') }}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{ asset('assets/Admin/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="{{ asset('assets/Admin/css/myecotrip.css') }} ">
        
        <!--datepicker  -->
        <link rel="stylesheet" href="{{ asset('assets/Admin/css/datepicker.css') }} ">

        <!-- DataTables CSS -->
        <link href="{{ asset('assets/Admin/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="{{ asset('assets/Admin/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

        <!-- jQuery -->
        <script src="{{ asset('assets/Admin/vendor/jquery/jquery.min.js') }} "></script>

        
    </head>
    <body onload="startTime()">
        <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img class="navbarLogo" src="{{asset('assets/Admin/img/myecotrip/logo.png') }}" alt="Image Alternative text" title="Image Title" />
                <img class="navbarLogo" src="{{asset('assets/Admin/img/myecotrip/Karnataka_Forest_Department_Logo_2016.png') }}" alt="Image Alternative text" title="Image Title" />
            </div>
            <!-- /.navbar-header -->

            @yield('navBar')

            
        </nav>

            @yield('content')

        </div>        

        <!-- Bootstrap Core JavaScript -->
        <script src="{{ asset('assets/Admin/vendor/bootstrap/js/bootstrap.min.js') }} "></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{ asset('assets/Admin/vendor/metisMenu/metisMenu.min.js') }} "></script>

        <!-- Morris Charts JavaScript -->
        <script src="{{ asset('assets/Admin/vendor/raphael/raphael.min.js') }} "></script>
        <script src="{{ asset('assets/Admin/vendor/morrisjs/morris.min.js') }} "></script>
        <script src="{{ asset('assets/Admin/data/morris-data.js') }} "></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{ asset('assets/Admin/dist/js/sb-admin-2.js') }} "></script>


        <!-- DataTables JavaScript -->
        <script src="{{ asset('assets/Admin/vendor/datatables/js/jquery.dataTables.min.js') }} "></script>
        <script src="{{ asset('assets/Admin/vendor/datatables-plugins/dataTables.bootstrap.min.js') }} "></script>
        <script src="{{ asset('assets/Admin/vendor/datatables-responsive/dataTables.responsive.js') }} "></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });

            if ($('#failedBookings')) {
                $('#failedBookings').DataTable({
                    responsive: true
                });
            }


        });
        </script>
        
        <script type="text/javascript">
            $('#confirmPassword').on("change", function () {
                var password = $('#password').val();
                var confPass = $('#confirmPassword').val();

                if(password != confPass) {
                    confirmPassword.setCustomValidity("Passwords Don't Match");
                } else {
                    confirmPassword.setCustomValidity('');
                }
            });
        </script>
        <!-- Real time -->
        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('time').innerHTML =
                h + ":" + m + ":" + s;
                var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                return i;
            }
        </script>

        <!--Datepicker  -->
        <!-- <script src="{{ asset('assets/Admin/js/jquery.min.js') }} "></script>
        <script src="{{ asset('assets/Admin/js/moments.js') }} "></script>
        <script src="{{ asset('assets/Admin/js/bootstrap-datetimepicker.min.js') }} "></script> -->
        
    </body>
</html>