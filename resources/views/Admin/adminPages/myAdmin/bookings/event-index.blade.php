
@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.myAdmin.topNav')

    @include('layouts.Admin.myAdmin.sideNav')
@endsection

@section('content')

    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Success Bookings
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="event">
                            <thead>
                                <tr>
                                    <!-- <td>Sl No</td> -->
                                    <td>Sl No</td>
                                    <td>Order id</td>
                                    <td>Booking Id</td>
                                    <td>Event</td>
                                    <td>Name</td>
                                    <td>Phone no</td>
                                    <td>Date of booking</td>
                                    <td>Number of tickets</td>
                                    <td>Status</td>
                                </tr>
                            </thead>

                            <tbody class="tblFont">
                                @foreach($rows as $key => $value)
                                    <a href="{{$value->id}}">
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td><a href="{{url('/myAdmin/SAEventBookings')}}/{{$value->id}}">{{$value->id}}</a></td>
                                        <td>{{$value->display_id}}</td>
                                        <td>{{$value->event->name}}</td>
                                        <td>{{$value->user->first_name}} {{$value->user->last_name}}</td>
                                        <td>{{$value->user->contact_no}}</td>
                                        <td>{{$value->date_of_booking}}</td>
                                        <td>{{$value->number_of_tickets}}</td>
                                        <td>{{$value->booking_status}}</td>
                                    </tr>
                                    </a>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td>Sl No</td>
                                <td>Order id</td>
                                <td>Booking Id</td>
                                <td>Event</td>
                                <td>Name</td>
                                <td>Phone no</td>
                                <td>Date of booking</td>
                                <td>Number of tickets</td>
                                <td>Status</td>
                            </tfoot>
                        </table>
                        <!-- /.table-responsive -->

                    </div>
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

<script type="text/javascript">
$(document).ready(function() {

$('#event').dataTable( {
    dom: 'Bfrtip',
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ],
    initComplete: function () {
            this.api().columns().every( function (i) {

                if (i == 3 || i == 8) {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                }

            } );        }
} );
} );
</script>
@endsection
