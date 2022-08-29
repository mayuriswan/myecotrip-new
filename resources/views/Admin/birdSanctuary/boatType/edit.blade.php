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
					<h1 class="page-header">Edit Boat Type</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateBoatType', 'files' => true)) }}
				<input type="hidden" name="boatTypeId" value="{{$boatTypeData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createBoatType" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="boatType" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Boat Type Details
											</h3>
										</div>
										<div class="panel-body">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-xs-3"><strong>Park Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="park_id" id="park_id" required>
																	<option value="">Select the park</option>
																	@foreach($parkList as $park)
																		<option @if($boatTypeData['park_id'] == $park['id']) selected @endif value="{{$park['id']}}">{{$park['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Bird Sanctuary Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9" id="birdSanctuary_id">
																<select class="form-control" name="birdSanctuary_id" required>
																	<option value="">Select the Bird Sanctuary</option>
																	@foreach($birdSanctuarylist as $birdSanctuary)
																		<option @if($boatTypeData['birdSanctuary_id'] == $birdSanctuary['id']) selected @endif value="{{$birdSanctuary['id']}}">{{$birdSanctuary['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Boat Type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="name" type="text" class="form-control validate[required] text-input" id="name" value="{{ $boatTypeData['name']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($boatTypeData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($boatTypeData['isActive'] == 0) selected @endif value="0">No</option>
																</select>
															</div>
														</div>
														<br>
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
	$("#park_id").change(function()
        {
            parkId = $("#park_id").val();
            if(parkId > 0) {
                var strURL = "getBirdSanctuary/" + parkId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }

                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#birdSanctuary_id").html(req.responseText);
            }
        });
</script>
@endsection
