@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
	@include('layouts.Admin.superAdmin.topNav')

	@include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')
<!-- include summernote wysiwyg css/js-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>    

<!-- Multi select -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/multiselect.css')}}">
<script src="{{ URL::asset('assets/js/multiselect.js')}}"></script>

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Edit Bird Sanctuary</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateBirdSanctuary', 'files' => true)) }}
				<input type="hidden" name="birdSanctuaryId" value="{{$birdSanctuaryData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createBirdSanctuary" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
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
																<select class="form-control" name="park_id" id="parkname" required>
																	<option value="">Select the park</option>
																	@foreach($parkList as $park)
																		<option @if($birdSanctuaryData['park_id'] == $park['id']) selected @endif value="{{$park['id']}}">{{$park['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Bird Sanctuary Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<input name="name" type="text" class="form-control validate[required] text-input" id="name" value="{{ $birdSanctuaryData['name']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><label> Map iframe&nbsp; * &nbsp;</label></div>
															<div class="col-xs-9"> <input name="map_url" type="text" class="form-control validate[required] text-input" value="{{ $birdSanctuaryData['map_url']}}" id="map_url" required>
															</div>
														</div>
														<br>
<div class="row">
	<div class="col-xs-3"><label>Boat types &nbsp; * &nbsp;</label></div>
	<div class="col-xs-9">

		<select id="dates-field2" name="boat_types[]" class="multiselect-ui form-control" multiple="multiple" required>
			@foreach($boatTypeList as $boats)
				@if(!empty($birdSanctuaryData['boat_types']))
					<option @if(in_array($boats['id'], $birdSanctuaryData['boat_types'])) selected @endif value="{{$boats['id']}}">{{$boats['name']}}</option>
				@else
					<option value="{{$boats['id']}}">{{$boats['name']}}</option>
				@endif
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
				@if(!empty($birdSanctuaryData['vehicle_types']))
					<option @if(in_array($vehicle['id'], $birdSanctuaryData['vehicle_types'])) selected @endif value="{{$vehicle['id']}}">{{$vehicle['type']}}</option>
				@else
					<option value="{{$vehicle['id']}}">{{$vehicle['type']}}</option>
				@endif
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
				@if(!empty($birdSanctuaryData['camera_types']))
					<option @if(in_array($camera['id'], $birdSanctuaryData['camera_types'])) selected @endif value="{{$camera['id']}}">{{$camera['type']}}</option>
				@else
					<option value="{{$camera['id']}}">{{$camera['type']}}</option>
				@endif

			@endforeach
		</select>

	</div>
</div>
<br>






														<div class="row">
															<div class="col-xs-3"><strong>Description<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <textarea name="description" class="summernote form-control" required>{{ $birdSanctuaryData['description']}}</textarea>
															</div>
														</div>

														
														<br>


														</div>

													<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="home-tab">
													
														<div class="row">
															<div class="col-xs-3"><strong>Meta Desc<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="meta_desc" type="text" class="form-control validate[required] text-input" id="meta_desc" value="{{ $birdSanctuaryData['meta_desc']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Meta Title&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="meta_title" type="text" class="form-control validate[required] text-input" id="meta_title" value="{{ $birdSanctuaryData['meta_title']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><strong>Keywords<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="keywords" type="text" class="form-control validate[required] text-input" id="keywords" value="{{ $birdSanctuaryData['keywords']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><strong>Activity<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="activity" type="text" class="form-control validate[required] text-input" id="activity" value="{{ $birdSanctuaryData['activity']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Contact Info<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="contactinfo" type="text" class="form-control validate[required] text-input" id="contactinfo" value="{{ $birdSanctuaryData['contactinfo']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($birdSanctuaryData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($birdSanctuaryData['isActive'] == 0) selected @endif value="0">No</option>
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
																<input name="logo" id="logo" type="file"  >
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-6">
																<img class="birdSanctuaryLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$birdSanctuaryData['logo']}}">
															</div>
														</div>

														<br>


														<div class="row">
															<div class="col-xs-3"><strong>Upload Bird Sanctuary Images</strong></div>
															<div class="col-xs-5">
																<input name="birdSanctuaryImages[]" id="birdSanctuary[]" type="file" multiple>
															</div>
														</div>
														<div class="panel-body">
															<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
																<thead>
																<tr>
																	<th>Id</th>
																	<th>Image</th>
																	<th>Action</th>
																</tr>
																</thead>

																<tbody>
																	@foreach($birdSanctuaryDataImages as $index => $birdSanctuary)
																		<tr class="odd gradeX">
																			<td>{{$index + 1}}</td>
																			<td><img class="birdSanctuaryLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$birdSanctuary['name']}}"></td>
																			<td>
																				<a value="{{$birdSanctuary['id']}}" class="birdSanctuaryImageDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
																			</td>
																		</tr>
																	@endforeach
																</tbody>
															</table>
															<!-- /.table-responsive -->
															<br>
															<div class="well">
																<h4>Information to be know :</h4>
																<p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website.</p>

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
	        $(document).ready(function() {
	            $('.summernote').summernote();
	        });

	        $('.multiselect-ui').multiselect({
		        includeSelectAllOption: true
		    });
	</script>

	<script>
        $(".birdSanctuaryImageDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var birdSanctuaryId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteBirdSanctuaryImages?id=')}}" + birdSanctuaryId
            }
        });
	</script>
@endsection
