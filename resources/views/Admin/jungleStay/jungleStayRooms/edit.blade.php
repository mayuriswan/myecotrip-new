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
					<h1 class="page-header">Edit Jungle Stay Rooms</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateJungleStayRooms', 'files' => true)) }}
				<input type="hidden" name="jungleStayRoomId" value="{{$jungleStayRoomsData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createJungleStayRooms" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="jungleStayRooms" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Jungle Stay Rooms Details
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
															<div class="col-xs-3"><strong>Jungle Stay Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="jungleStay_id" id="jungleStay_id" required>
																	<option value="">Select the JungleStay</option>
																	@foreach($jungleStayList as $jungleStay)
																		<option @if($jungleStayRoomsData['jungleStay_id'] == $jungleStay['id']) selected @endif value="{{$jungleStay['id']}}">{{$jungleStay['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="type" type="text" class="form-control validate[required] text-input" id="type" value="{{ $jungleStayRoomsData['type']}}" required>
															</div>
														</div>
														<br>
														</div>
													<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="SEO-tab">
														<div class="row">
															<div class="col-xs-3"><strong>Description<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="description" type="text" class="form-control validate[required] text-input" id="description" value="{{ $jungleStayRoomsData['description']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Remarks<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="remarks" type="text" class="form-control validate[required] text-input" id="remarks" value="{{ $jungleStayRoomsData['remarks']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Minimum Stay&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="minimum_stay" type="text" class="form-control validate[required] text-input" id="minimum_stay" value="{{ $jungleStayRoomsData['minimum_stay']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><strong>No of Rooms<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="no_of_rooms" type="text" class="form-control validate[required] text-input" id="no_of_rooms" value="{{ $jungleStayRoomsData['no_of_rooms']}}" required>
															</div>
														</div>
														<br>

														<div class="row">
															<div class="col-xs-3"><strong>Inclusive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="inclusive" type="text" class="form-control validate[required] text-input" id="inclusive" value="{{ $jungleStayRoomsData['inclusive']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Exclusive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="exclusive" type="text" class="form-control validate[required] text-input" id="exclusive" value="{{ $jungleStayRoomsData['exclusive']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Check In<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="checkin" type="text" class="form-control validate[required] text-input" id="checkin" value="{{ $jungleStayRoomsData['checkin']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Check Out<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="checkout" type="text" class="form-control validate[required] text-input" id="checkout" value="{{ $jungleStayRoomsData['checkout']}}" required>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($jungleStayRoomsData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($jungleStayRoomsData['isActive'] == 0) selected @endif value="0">No</option>
																</select>
															</div>
														</div>
														<br>
													</div>
													<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">
														<bR>
														<div class="row">
															<div class="col-xs-3"><strong>Upload Jungle Stay Rooms Images</strong></div>
															<div class="col-xs-5">
																<input name="jungleStayRoomsImages[]" id="jungleStayRooms[]" type="file" multiple>
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
																	@foreach($jungleStayRoomsDataImages as $index => $jungleStayRooms)
																		<tr class="odd gradeX">
																			<td>{{$index + 1}}</td>
																			<td><img class="jungleStayRoomsLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$jungleStayRoomsData['imageBaseUrl']}}{{$jungleStayRooms['name']}}"></td>
																			<td>
																				<a value="{{$jungleStayRooms['id']}}" class="jungleStayRoomsImageDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
        $(".jungleStayRoomsImageDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var jungleStayRoomId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteJungleStayRoomsImages?id=')}}" + jungleStayRoomId
            }
        });
	</script>
@endsection
