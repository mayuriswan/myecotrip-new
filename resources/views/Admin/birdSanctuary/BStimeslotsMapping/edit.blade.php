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
					<h1 class="page-header">Edit Time Slots Mapping</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateBSTimeSlotsMapping', 'files' => true)) }}
				<input type="hidden" name="id" value="{{$timeslotsMappingData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createBSTimeSlots" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="BStimeslotsMapping" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Time Slots details
											</h3>
										</div>
										<div class="panel-body">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-xs-3"><strong>Bird Sanctuary Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" id="birdSanctuary_id" name="birdSanctuary_id" required>
																	<option value="">Select the Bird Sanctuary</option>
																	@foreach($birdSanctuarylist as $birdSanctuary)
																		<option @if($timeslotsMappingData['birdSanctuary_id'] == $birdSanctuary['id']) selected @endif value="{{$birdSanctuary['id']}}">{{$birdSanctuary['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Boat Type&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9" id="boatType">
																<select class="form-control" name="boatType_id" required>
																	<option value="">Select the Bird Sanctuary</option>
																	@foreach($boatTypeslist as $boatTypes)
																		<option @if($timeslotsMappingData['boatType_id'] == $boatTypes['id']) selected @endif value="{{$boatTypes['id']}}">{{$boatTypes['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Time Slots&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9" id="timeslots">
																<select class="form-control" name="timeslots_id" required>
																	<option value="">Select the Time Slots</option>
																	@foreach($timeslotslist as $timeslots)
																		<option @if($timeslotsMappingData['timeslots_id'] == $timeslots['id']) selected @endif value="{{$timeslots['id']}}">{{$timeslots['timeslots']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" required name="isActive" id="isActive" required>
																	<option @if($timeslotsMappingData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if($timeslotsMappingData['isActive'] == 0) selected @endif value="0">No</option>
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
			{{ Form::close() }}
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->
<script>
		$("#birdSanctuary_id").change(function()
        {
            birdSanctuaryId = $("#birdSanctuary_id").val();
            if(birdSanctuaryId > 0) {
                var strURL = "getBoatTypes/" + birdSanctuaryId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }

                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#boatType").html(req.responseText);
            }
        });

        $(document).on('change','#boatType_id',function(){
            boatTypeId = $("#boatType_id").val();
            if(boatTypeId > 0) {
                var strURL = "getBoatTimeSlots/"+birdSanctuaryId +"/"+ boatTypeId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }

                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#timeslots").html(req.responseText);
            }
        });
	</script>
@endsection
