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
					<h1 class="page-header">Edit safari</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateSafari', 'files' => true)) }}
				<input type="hidden" name="safariId" value="{{$safariData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createSafari" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="safari" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												safari details
											</h3>
										</div>
										<div class="panel-body">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" class="active">
														<a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
													</li>
													<li role="presentation" class="">
														<a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Images</a>
													</li>
												</ul>
												<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-xs-3"><strong>Order No.&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="display_order_no" required type="text" class="form-control validate[required] text-input" value="{{ $safariData['display_order_no']}}" id="display_order_no">
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Park Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="park_id" id="parkname" required>
																	<option value="">Select the park</option>
																	@foreach($parkList as $park)
																		<option @if($safariData['park_id'] == $park['id']) selected @endif value="{{$park['id']}}">{{$park['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Safari Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<input name="name" type="text" class="form-control validate[required] text-input" id="name" value="{{ $safariData['name']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Meta Title&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="meta_title" type="text" class="form-control validate[required] text-input" id="meta_title" value="{{ $safariData['meta_title']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Meta Desc<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="meta_desc" type="text" class="form-control validate[required] text-input" id="meta_desc" value="{{ $safariData['meta_desc']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Keywords<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="keywords" type="text" class="form-control validate[required] text-input" id="keywords" value="{{ $safariData['keywords']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Description<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="description" type="text" class="form-control validate[required] text-input" id="description" value="{{ $safariData['description']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Includes<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="includes" type="text" class="form-control validate[required] text-input" id="includes" value="{{ $safariData['includes']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Excludes<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="excludes" type="text" class="form-control validate[required] text-input" id="excludes" value="{{ $safariData['excludes']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Transportation<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																@foreach($transporttypesList as $transporttypes)
																	<input type="checkbox" name="transportation_id[]" @if (in_array($transporttypes['id'], $safariData['transportation_id'])) checked @endif  value="{{$transporttypes['id']}}">&nbsp;<?php echo $transporttypes['name'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
																@endforeach
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($safariData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($safariData['isActive'] == 0) selected @endif value="0">No</option>
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
														<div class="row">
															<div class="col-xs-6">
																<img class="safariLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$safariData['imageBaseUrl']}}{{$safariData['logo']}}">
															</div>
														</div>
														<div class="row">
															<div class="col-xs-3"><strong>Upload safari images</strong></div>
															<div class="col-xs-5">
																<input name="safariImages[]" id="safari[]" type="file" multiple>
															</div>
														</div>
														{{--<div class="row">
															<div class="col-xs-6">
																@foreach($safariImages as $images)
																<img class="safariLogo" src="{{$images['name']}}">
																@endforeach
															</div>
														</div>--}}
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
																	@foreach($safariImages as $index => $safari)
																		<tr class="odd gradeX">
																			<td>{{$index + 1}}</td>
																			<td><img class="safariLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$safariData['imageBaseUrl']}}{{$safari['name']}}"></td>
																			<td>
																				<a value="{{$safari['id']}}" class="safariImageDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
        $(".safariImageDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var safariId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteSafariImages?id=')}}" + safariId
            }
        });
	</script>
@endsection
