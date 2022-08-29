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
					<h1 class="page-header">Edit Safari Counts</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateSafariTimeslotsTransportationtype', 'files' => true)) }}
				<div class="row">
					<div class="col-lg-12">
						<form action="createSafariTimeslotsTransportationtype" method="post" enctype="multipart/form-data">
							<input type="hidden" value="{{$hiddenVehicles}}" name="oldVehicles">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="{{url('/')}}/admin/safariTimeslotsTransportationtype" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Safari Count details
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
																<select class="form-control" name="safari_id" id="safari_id" required disabled>
																	<option value="">Select the Safari</option>
																	@foreach($safariData as $safariList)
																		<option @if($requestData['safariId']== $safariList['id']) selected @endif value="{{$safariList['id']}}">{{$safariList['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Transportation<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="transportation_id" id="transportation_id" required disabled >
																	@foreach($transporttypeslist as $transporttypes)
																		<option @if($requestData['transportationId']== $transporttypes['id']) selected @endif value="{{$transporttypes['id']}}" >{{$transporttypes['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>TimeSlot<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="timeslot_id" id="timeslot_id" required disabled>
																	<option value="">Select the timeslot</option>
																	@foreach($timeSlotsData as $timeSlotsDataList)
																		<option @if($requestData['timeslotsId']== $timeSlotsDataList['id']) selected @endif value="{{$timeSlotsDataList['id']}}">{{$timeSlotsDataList['timeslots']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Vehicles<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9" id="vehicle_id">
																@foreach($allVehicles as $vehicle)
																	@if (in_array($vehicle['id'],$oldVehicles))
																		<input type="checkbox" name="vehicle_id[]" id="vehicle_id" checked value="{{$vehicle['id']}}">&nbsp;&nbsp;{{$vehicle['displayName']}}&nbsp;&nbsp;
																	@else
																		<input type="checkbox" name="vehicle_id[]" id="vehicle_id"  value="{{$vehicle['id']}}">&nbsp;&nbsp;{{$vehicle['displayName']}}&nbsp;&nbsp;
																	@endif
																@endforeach
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
			{{ Form::close() }}
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->
	<script>
        $('#btnModify').click(function () {
            $("#safari_id").removeAttr("disabled");
            $("#transportation_id").removeAttr("disabled");
            $("#timeslot_id").removeAttr("disabled");
        })
	</script>
@endsection
