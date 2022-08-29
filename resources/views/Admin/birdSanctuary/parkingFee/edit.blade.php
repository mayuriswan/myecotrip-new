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
					<h1 class="page-header">Edit Parking Fee</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateParkingFee', 'files' => true)) }}
				<input type="hidden" name="parkingFeeId" value="{{$parkingFeeData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createParkingFee" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="parkingFee" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Parking Fee Details
											</h3>
										</div>
										<div class="panel-body">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-xs-3"><strong>Bird Sanctuary Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" id="birdSanctuary_id" name="birdSanctuary_id" required disabled>
																	<option value="">Select the Bird Sanctuary</option>
																	@foreach($birdSanctuaryList as $birdSanctuary)
																		<option @if($parkingFeeData['birdSanctuary_id'] == $birdSanctuary['id']) selected @endif value="{{$birdSanctuary['id']}}">{{$birdSanctuary['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														
														<div class="row">
															<div class="col-xs-3"><strong>Vehicle Type&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" id="vehicletype_id" name="vehicletype_id" required disabled>
																	<option value="">Select the Vehicle Type</option>
																	@foreach($parkingVehicleTypeList as $parkingVehicleType)
																		<option @if($parkingFeeData['vehicletype_id'] == $parkingVehicleType['id']) selected @endif value="{{$parkingVehicleType['id']}}">{{$parkingVehicleType['type']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Price&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="price" type="text" class="form-control validate[required] text-input" id="price" value="{{$parkingFeeData['price']}}" required>
															</div>
														</div>
														<br> 
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($parkingFeeData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($parkingFeeData['isActive'] == 0) selected @endif value="0">No</option>
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
		$('#btnModify').click(function () {
            $("#birdSanctuary_id").removeAttr("disabled");
            $("#parkingtype_id").removeAttr("disabled");
            $("#vehicletype_id").removeAttr("disabled");
        })
	</script>
@endsection
