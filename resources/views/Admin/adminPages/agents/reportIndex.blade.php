
@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.agent.topNav')

    @include('layouts.Admin.agent.sideNav')
@endsection

@section('content')

    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Download</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <form action="downloadReport" method="POST">
        	<div class="row">
            <input type="hidden" name="requestFrom" value="trailAdmin">
        	<div class="container">
			   	 <div class="row">
			   	 	<div class="col-sm-3">
		                <select id="selectMonth" name="selectMonth" class="form-control" required>
                            <option value="">Select Month</option>
                            <?php for ($i = 0; $i <= 12; ++$i) {
                                $time = strtotime(sprintf('-%d months', $i));
                                $value = date('Y-m', $time);
                                $label = date('F Y', $time);
                                printf('<option value="%s">%s</option>', $value, $label);
                            } ?>

	                    </select>
			   	 	</div>
			   	 	<div class="col-sm-3">
	                    <select name="type" class="col-sm-3 form-control" required>
	                    	<option value="">Select type</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
	                    </select>
	                </div>
			        <div class='col-sm-5'>
			            <div class="form-group">
			                <button type="submit" class="btn btn-success">Download</button>
			            </div>
			        </div>
			    </div>
			</div>                
        </form>

        @if(isset($getBooking))
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Success Bookings
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <!-- <th>Sl No</th> -->
                                    <th>Action</th>
                                    <th>Booking Id</th>
                                    <th>Name</th>
                                    <!-- <th>Email</th> -->
                                    <th>Phone no</th>
                                    <th>Trail</th>
                                    <th>Date of booking</th>
                                    <th>Check In</th>
                                    <th>Tickets</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody class="tblFont">
                            @if(count($getBooking['success']) > 0)
                                @foreach($getBooking['success'] as $index => $booking)
                                    
                                    <tr class="odd gradeX">
                                        <!-- <td>{{$index + 1}}</td> -->
                                        <td class="text-center"><a href="{{ url('admin/SAtrailDetail/') }}/{{$booking['id']}}/{{$booking['user_id']}}" title="Edit"><i class="fa fa-eye fa-fw"></i></a></td>                     
                                        <td>{{$booking['display_id']}}</td>
                                        <td>{{$booking['userData']['name']}}</td>
                                        
                                        <td>{{$booking['userData']['phone_no']}}</td>
                                        <td>{{$booking['trailName']}}</td>
                                        <td>{{substr($booking['date_of_booking'],0,10)}}</td>
                                        <td>{{substr($booking['checkIn'],0,10)}}</td>
                                        <td>{{$booking['number_of_trekkers']}}</td>
                                        <td>{{$booking['booking_status']}}</td>
                                    </tr>
                                    
                                @endforeach                                                          
                            @else
                                <div class="alert alert-warning">
                                    <strong>Sorry!</strong> No Product Found.
                                </div>                                  
                            @endif

                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                        
                    </div>
                </div>
                
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        @endif

    </div>
    <!-- /.container-fluid -->
</div>
    <!-- /#page-wrapper -->

@endsection

