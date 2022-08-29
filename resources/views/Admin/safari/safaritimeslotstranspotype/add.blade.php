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
					<h1 class="page-header">Add Safari Counts
						<a href="{{ url('admin/addSafariTimeslotsTransportationtype') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="createSafariTimeslotsTransportationtype" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
												<a href="safariTimeslotsTransportationtype" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
											</div>
											Safari details
										</h3>
									</div>
									<div class="panel-body">
										<div class="" role="tabpanel" data-example-id="togglable-tabs">
											<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
												<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a></li>
											</ul>
											<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
												<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
													<div class="row">
														<div class="col-xs-3"><strong>Safari<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" required name="safari_id" id="safari_id" required>
																<option value="">Select the Safari</option>
																@foreach($safariData as $safariList)
																	<option value="{{$safariList['id']}}">{{$safariList['name']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Transportation<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9" id="transportation_id">
															<select class="form-control" name="transportation_id" required>
																<option value="">Select the transportation</option>
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>TimeSlot<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" required name="timeslot_id" id="timeslot_id" required>
																<option value="">Select the timeslot</option>
																@foreach($timeSlotsData as $timeSlotsDataList)
																	<option value="{{$timeSlotsDataList['id']}}">{{$timeSlotsDataList['timeslots']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Vehicles<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9" id="vehicle_id">
															{{--@foreach($vehicleList as $vehicle)
																<input type="checkbox" name="vehicle_id[]" id="vehicle_id" value="{{$vehicle['id']}}">&nbsp;&nbsp;{{$vehicle['displayName']}}&nbsp;&nbsp;
															@endforeach--}}
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>isActive &nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" required name="isActive" id="isActive" required>
																<option value="1">Yes</option>
																<option value="0">No</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->
	<script>
        $("#safari_id").change(function()
        {
            safariId = $("#safari_id").val();
            if(safariId > 0) {
                var strURL = "getSafariTransportation/" + safariId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }

                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#transportation_id").html(req.responseText);
            }
        });

        $("#timeslot_id").change(function()
        {
            transportationId = $("#transportation").val();
            timeslotId = $("#timeslot_id").val();
            var strURL="getTransportationVehicle/"+safariId+"/"+transportationId+"/"+timeslotId;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                req=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                req=new ActiveXObject("Microsoft.XMLHTTP");
            }

            req.open("GET", strURL, false); //third parameter is set to false here
            req.send(null);
            $("#vehicle_id").html(req.responseText);
        });
	</script>
@endsection