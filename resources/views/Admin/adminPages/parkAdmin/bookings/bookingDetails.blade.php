
@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.parkAdmin.topNav')

    @include('layouts.Admin.parkAdmin.sideNav')
@endsection

@section('content')
	<div id="page-wrapper">
		<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Transaction Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- <div class="panel-heading">
                            Booking details
                        </div> -->
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                        	<div class="well">
                        		<h4>User Details</h4>
                                <hr class="bookingHr">
                                <table class="table">
                                	<tr class="tblBorder">
                                		<td>                          			
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Name:</label>
                                				
                                					{{$userData['first_name']}} {{$userData['last_name']}}
                                				</div>
                                			</div>
                            			</td>
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Email:</label>
                                				
                                					{{$userData['email']}}
                                				</div>
                                			</div>
                                		</td>
                                	</tr>
                                	<tr class="tblBorder">
                                		<td>                          			
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Phone No:</label>
                                				
                                					{{$userData['contact_no']}}
                                				</div>
                                			</div>
                            			</td>
                                	</tr>

                                </table>

                                <h4>Booking Details</h4>
                                <hr class="bookingHr">
                                <table class="table">
                                	<tr class="tblBorder">
                                		<td>                          			
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Booking Id:</label>
                                					{{$bookingData['display_id']}}
                                					
                                				</div>
                                			</div>
                            			</td>
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Date of Booking:</label>
                                				{{$bookingData['date_of_booking']}}
                                					
                                				</div>
                                			</div>
                                		</td>
                                	</tr>
                                	<tr class="tblBorder">
                                		<td>                          			
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Date Of CheckIn:</label>
                                				{{$bookingData['checkIn']}}
                                					
                                				</div>
                                			</div>
                            			</td>
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>No of Tickets:</label>
                                				{{$bookingData['number_of_trekkers']}}
                                					
                                				</div>
                                			</div>
                                		</td>
                                	</tr>

                                	<tr class="tblBorder">
                                		<td>                          			
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Status:</label>
                                				{{$bookingData['booking_status']}}
                                					
                                				</div>
                                			</div>
                            			</td>
                                        <td>                                    
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>Trail Name:</label>
                                                {{$bookingData['trailName']}}
                                                    
                                                </div>
                                            </div>
                                        </td>
                                	</tr>

                                </table>
                            </div>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Sex</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach($bookingData['trekkers_details'] as $index => $trekker)
	                                	<tr class="odd gradeX">
	                                		<td>{{$index + 1}}</td>
	                                		<td>{{$trekker['name']}}</td>
	                                		<td>{{$trekker['age']}}</td>
	                                		<td>{{$trekker['sex']}}</td>
	                                    </tr>
                                	@endforeach
                                    
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
	</div>	
@endsection