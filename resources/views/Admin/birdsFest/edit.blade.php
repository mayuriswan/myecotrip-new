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

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Edit Birds Fest</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateBirdsFest', 'files' => true)) }}
				<input type="hidden" name="birdsFestId" value="{{$birdsFestData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createBirdsFest" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="birdsFest" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Birds Fest Details
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
															<div class="col-xs-3"><strong>Event type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="event_id" id="event_id" required>
																	<option value="">Select the type</option>
																	@foreach($eventlist as $event)
																		<option @if($birdsFestData['event_id'] == $event['id']) selected @endif value="{{$event['id']}}">{{$event['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Birds Fest Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<input name="name" type="text" class="form-control validate[required] text-input" id="name" value="{{ $birdsFestData['name']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Map URL<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<input name="map_url" type="text" class="form-control validate[required] text-input" id="name" value="{{ $birdsFestData['map_url']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><strong>Description<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> 
																<textarea name="description" class="summernote form-control validate[required] text-input" id="description" required>{{ $birdsFestData['description']}}
																</textarea>
															</div>
														</div>
														<br>

														</div>
													<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="home-tab">
														
														<div class="row">
															<div class="col-xs-3"><strong>Meta Desc<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="meta_desc" type="text" class="form-control validate[required] text-input" id="meta_desc" value="{{ $birdsFestData['meta_desc']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Meta Title&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="meta_title" type="text" class="form-control validate[required] text-input" id="meta_title" value="{{ $birdsFestData['meta_title']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><strong>Keywords<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="keywords" type="text" class="form-control validate[required] text-input" id="keywords" value="{{ $birdsFestData['keywords']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><strong>Activity<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="activity" type="text" class="form-control validate[required] text-input" id="activity" value="{{ $birdsFestData['activity']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Contact Info<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="contactinfo" type="text" class="form-control validate[required] text-input" id="contactinfo" value="{{ $birdsFestData['contactinfo']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($birdsFestData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($birdsFestData['isActive'] == 0) selected @endif value="0">No</option>
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
														<br />
														<div class="row">
															<div class="col-xs-6">
																@if($birdsFestData['s3_upload'])
																	<img class="birdsFestLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$birdsFestData['logo']}}">
																@else
																	<img class="birdsFestLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$birdsFestData['imageBaseUrl']}}{{$birdsFestData['logo']}}">
																@endif
																
															</div>
														</div>
														<br />

														<div class="row">
															<div class="col-xs-3"><strong>Upload Birds Fest Images</strong></div>
															<div class="col-xs-5">
																<input name="birdsFestImages[]" id="birdsFest" type="file" multiple>
															</div>
														</div>

														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Upload Speakers Images</strong></div>
															<div class="col-xs-5">
																<input name="speakersImages[]" id="birdsFest" type="file" multiple>
															</div>
														</div>
														<br>

														<div class="panel-body">
															<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
																<thead>
																<tr>
																	<th>Id</th>
																	<th>Type</th>
																	<th>Image</th>
																	<th>Action</th>
																</tr>
																</thead>

																<tbody>
																	@foreach($birdsFestDataImages as $index => $birdsFest)
																		<tr class="odd gradeX">
																			<td>{{$index + 1}}</td>
																			<td>
																				@if($birdsFest['image_type'] == 0)
																					Fest Image
																				@else
																					Speaker Image
																				@endif
																			</td>
																			<td>
																@if($birdsFest['s3_upload'])
																	<img class="birdsFestLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$birdsFest['name']}}">
																@else
																	<img class="birdsFestLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$birdsFestData['imageBaseUrl']}}{{$birdsFest['name']}}">
																@endif
																			</td>
																			<td>
																				<a value="{{$birdsFest['id']}}" class="birdsFestImageDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
		//For wysiwyg
        $(document).ready(function() {
            $('.summernote').summernote();
        });

        $(".birdsFestImageDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var birdsFestId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteBirdsFestImages?id=')}}" + birdsFestId
            }
        });
	</script>
@endsection
