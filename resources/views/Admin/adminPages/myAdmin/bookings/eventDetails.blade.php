
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

                            @if(Session::has('success'))
                    			<p class="alert alert-success">{{ Session::get('success') }}</p>
                    		@endif
                            @if(Session::has('error'))
                    			<p class="alert alert-danger">{{ Session::get('error') }}</p>
                    		@endif


                        	<div class="well">
                        		<h4>User Details</h4>
                                <hr class="bookingHr">
                                <table class="table">
                                	<tr class="tblBorder">
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Name:</label>
                                                    {{$row->user->first_name}} {{$row->user->last_name}}

                                				</div>
                                			</div>
                            			</td>
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Email:</label>
                                                    {{$row->user->email}}
                                				</div>
                                			</div>
                                		</td>
                                	</tr>
                                	<tr class="tblBorder">
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Phone No:</label>
                                                    {{$row->user->contact_no}}
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
                                                    {{$row->display_id}}
                                				</div>
                                			</div>
                            			</td>
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Date of Booking:</label>
                                                    {{$row->date_of_booking}}
                                				</div>
                                			</div>
                                		</td>
                                	</tr>
                                	<tr class="tblBorder">
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Date Of CheckIn:</label>
                                                    {{$row->checkIn or 'NA'}}
                                				</div>
                                			</div>
                            			</td>
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>No of Tickets:</label>
                                                    {{$row->number_of_tickets}}
                                				</div>
                                			</div>
                                		</td>
                                	</tr>

                                	<tr class="tblBorder">
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Status:</label>
                                                    {{$row->booking_status}}
                                				</div>
                                			</div>
                            			</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>Event Name:</label>
                                                    {{$row->event->name}}
                                                </div>
                                            </div>
                                        </td>
                                	</tr>

                                    <tr class="tblBorder">
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>Amount:</label>
                                                    {{$row->amount}}
                                				</div>
                                			</div>
                            			</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>GST amount:</label>
                                                    {{$row->gst_amount}}
                                                </div>
                                            </div>
                                        </td>

                                	</tr>

                                    <tr class="tblBorder">
                                		<td>
                                			<div class="row">
                                				<div class="col-lg-12">
                                					<label>KEDB amount:</label>
                                                    {{$row->kedb_amount}}
                                				</div>
                                			</div>
                            			</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>Amount With Tax:</label>
                                                    {{$row->amountWithTax}}
                                                </div>
                                            </div>
                                        </td>

                                	</tr>

                                </table>
                            </div>

                            <?php
                                $data = json_decode($row->users_details, true);
                            ?>
                            <!-- /.table-responsive -->

                            <form action="{{url('myAdmin/SAEventBookings/')}}/{{$row->id}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('put') }}


                            @foreach($data as $ke => $row2)
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table class="table">
                                        @foreach($row2 as $i => $val )
                                                <tr>
                                                    <td>{{ucwords(str_replace("_", " ", $i))}}</td>
                                                    <td><input class="form-control" type="text" name="usersDetails[{{$ke}}][{{$i}}]" value="{{$val}}"> </td>
                                                </tr>
                                        @endforeach
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{url('myAdmin/SAEventBookings/')}}/sendMail/{{$row->id}}"><button type="button" class="btn btn-primary">Send Mail</button></a>
                                    <a href="{{url('myAdmin/SAEventBookings/')}}/sendSMS/{{$row->id}}"><button type="button" class="btn btn-info">Send SMS</button></a>
                                    <a href="{{url('myAdmin/SAEventBookings/')}}/updateSuccess/{{$row->id}}"><button type="button" class="btn btn-warning">Update Booking Status to Success</button></a>
                                </div>
                            </div>
                            </form>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
	</div>
@endsection
