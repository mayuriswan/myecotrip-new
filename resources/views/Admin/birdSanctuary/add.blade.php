@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
	@include('layouts.Admin.superAdmin.topNav')

	@include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')
	
<!-- include summernote wysiwyg css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>    

<!-- Multi select -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/multiselect.css')}}">
<script src="{{ URL::asset('assets/js/multiselect.js')}}"></script>

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Add Bird Sanctuary
						<a href="{{ url('admin/addBirdSanctuary') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="createBirdSanctuary" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
												<a href="birdSanctuary" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
											</div>
											Bird Sanctuary Details
										</h3>
									</div>
									<div class="panel-body">
										<div class="" role="tabpanel" data-example-id="togglable-tabs">
											<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
												<li role="presentation" class="active">
													<a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
												</li>
												<li role="presentation" class="">
													<a href="#tab_content3" role="tab" id="SEO-tab" data-toggle="tab"  aria-expanded="false">SEO</a>
												</li>
												<li role="presentation" class="">
													<a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Images</a>
												</li>
											</ul>
											<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
												<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
													<div class="row">
														<div class="col-xs-3"><strong>Park Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" name="park_id" id="park_id" required>
																<option value="">Select the park</option>
																@foreach($parkList as $park)
																	<option value="{{$park['id']}}">{{$park['name']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Bird Sanctuary Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="name" type="text" class="form-control validate[required] text-input" id="name" required>
														</div>
													</div>
													<br>

													<div class="row">
														<div class="col-xs-3"><label> Map iframe&nbsp; * &nbsp;</label></div>
														<div class="col-xs-9"> <input name="map_url" type="text" class="form-control validate[required] text-input" id="map_url" required>
														</div>
													</div>
													<br>

<div class="row">
	<div class="col-xs-3"><label>Boat types &nbsp; * &nbsp;</label></div>
	<div class="col-xs-9">

		<select id="dates-field2" name="boat_types[]" class="multiselect-ui form-control" multiple="multiple" required>
			@foreach($boatTypeList as $boats)
			<option value="{{$boats['id']}}">{{$boats['name']}}</option>
			@endforeach
		</select>

	</div>
</div>
													<br>



<div class="row">
	<div class="col-xs-3"><label>Parking types &nbsp; * &nbsp;</label></div>
	<div class="col-xs-9">

		<select id="dates-field2" name="vehicle_types[]" class="multiselect-ui form-control" multiple="multiple" required>
			@foreach($parkingVehicleType as $vehicle)
			<option value="{{$vehicle['id']}}">{{$vehicle['type']}}</option>
			@endforeach
		</select>

	</div>
</div>

<br>

<div class="row">
	<div class="col-xs-3"><label>Camera types &nbsp; * &nbsp;</label></div>
	<div class="col-xs-9">

		<select id="dates-field2" name="camera_types[]" class="multiselect-ui form-control" multiple="multiple" required>
			@foreach($cameraTypeList as $camera)
			<option value="{{$camera['id']}}">{{$camera['type']}}</option>
			@endforeach
		</select>

	</div>
</div>

<br>



													<div class="row">
														<div class="col-xs-3"><strong>Description<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <textarea name="description" class="summernote form-control" required></textarea>
														</div>
													</div>
													<br>

												</div>
												<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="home-tab">
													
													<div class="row">
														<div class="col-xs-3"><strong>Meta Desc<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="meta_desc" required type="text" class="form-control validate[required] text-input" id="meta_desc">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Meta Title&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="meta_title" required type="text" class="form-control validate[required] text-input" id="meta_title">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Keywords<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="keywords" required type="text" class="form-control validate[required] text-input" id="keywords">
														</div>
													</div>
													<br>

													<div class="row">
														<div class="col-xs-3"><strong>Activity<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="activity" required type="text" class="form-control validate[required] text-input" id="activity">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Contact Info<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="contactinfo" required type="text" class="form-control validate[required] text-input" id="contactinfo">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" name="isActive" id="isActive" required>
																<option value="1">Yes</option>
																<option value="0">No</option>
															</select>
														</div>
													</div>
													<br>
												</div>
												<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">
													<bR>
													<div class="row">
														<div class="col-xs-3"><strong>Upload New Logo</strong></div>
														<div class="col-xs-9">
															<input name="logo" id="logo" type="file" required>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Upload Bird Sanctuary images</strong></div>
														<div class="col-xs-5">
															<input name="birdSanctuaryImages[]" id="birdSanctuary[]" type="file" multiple required>
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
        $(document).ready(function() {
            $('.summernote').summernote();
        });

	    $('.multiselect-ui').multiselect({
	        includeSelectAllOption: true
	    });

</script>


@endsection