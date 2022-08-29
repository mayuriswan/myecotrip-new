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
					<h1 class="page-header">Add Event
						<a href="{{ url('admin/addBirdsFest') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="createBirdsFest" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
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
																	<option value="{{$event['id']}}">{{$event['name']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Event Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="name" type="text" class="form-control validate[required] text-input" id="name" required>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Description<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> 
															<textarea name="description" class="summernote form-control validate[required] text-input" id="description" required>
																</textarea>
														</div>
													</div>
													<br>

													<div class="row">
														<div class="col-xs-3"><strong>Map URL<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="map_url" required type="text" class="form-control validate[required] text-input" id="map_url">
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
														<div class="col-xs-3"><strong>Activity</strong></div>
														<div class="col-xs-9"> <input name="activity" required type="text" class="form-control text-input" id="activity">
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
														<div class="col-xs-3"><strong>Upload Birds Fest images</strong></div>
														<div class="col-xs-5">
															<input name="birdsFestImages[]" id="birdsFest[]" type="file" multiple required>
														</div>
													</div>
													<br>

													<div class="row">
														<div class="col-xs-3"><strong>Upload Speakers Images</strong></div>
														<div class="col-xs-5">
															<input name="speakersImages[]" type="file" multiple>
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

<script type="text/javascript">
	//For wysiwyg
    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>


@endsection