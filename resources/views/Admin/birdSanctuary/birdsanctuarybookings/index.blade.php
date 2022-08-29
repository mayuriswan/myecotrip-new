@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.superAdmin.topNav')

    @include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">BirdSanctuary Bookings</h1>
                </div>
            </div>
            <!-- /.row -->
            <br>
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            BirdSanctuary Bookings list
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Booking Date</th>
                                    <th>No of Visitors</th>
                                    <th>Amount</th>
                                    <th>Booking Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($birdSanctuaryBookingData) > 0)
                                    @foreach($birdSanctuaryBookingData as $index => $birdSanctuaryBooking)
                                        <tr class="odd gradeX">
                                            <td>{{$index + 1}}</td>
                                            <td>{{$birdSanctuaryBooking['date_of_booking']}}</td>
                                            <td>{{$birdSanctuaryBooking['no_of_seats']}}</td>
                                            <td>{{$birdSanctuaryBooking['amount']}}</td>
                                            <td>{{$birdSanctuaryBooking['booking_status']}}</td>
                                            <td class="text-center"><a href="{{ url('admin/viewBirdSanctuaryBookings/') }}/{{$birdSanctuaryBooking['id']}}/{{$birdSanctuaryBooking['user_id']}}" title="View"><i class="fa fa-eye fa-fw"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">
                                        <strong>Sorry!</strong> No Bookings Found.
                                    </div>
                                @endif

                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <br>
                            <div class="well">
                                <h4>Information to be know :</h4>
                                <p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website.</p>

                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection
