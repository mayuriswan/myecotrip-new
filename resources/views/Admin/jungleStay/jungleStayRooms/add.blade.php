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
					<h1 class="page-header">Add Jungle Stay Rooms
						<a href="{{ url('admin/addJungleStayRooms') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="createJungleStayRooms" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
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
														<div class="col-xs-3"><strong>JungleStay Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" name="jungleStay_id" id="jungleStay_id" required>
																<option value="">Select the JungleStay</option>
																@foreach($jungleStaylist as $jungleStay)
																	<option value="{{$jungleStay['id']}}">{{$jungleStay['name']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="type" required type="text" class="form-control validate[required] text-input" id="type">
														</div>
													</div>
													<br>
													</div>
												<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="SEO-tab">
													<div class="row">
														<div class="col-xs-3"><strong>Description<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="description" required type="text" class="form-control validate[required] text-input" id="description">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Remarks<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="remarks" required type="text" class="form-control validate[required] text-input" id="remarks">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Minimum Stay<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="minimum_stay" required type="text" class="form-control validate[required] text-input" id="minimum_stay">
														</div>
													</div>
													<br>

													<div class="row">
														<div class="col-xs-3"><strong>No of Rooms<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="no_of_rooms" required type="text" class="form-control validate[required] text-input" id="no_of_rooms">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Inclusive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="inclusive" required type="text" class="form-control validate[required] text-input" id="inclusive">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Exclusive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="exclusive" required type="text" class="form-control validate[required] text-input" id="exclusive">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>CheckIn<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="checkin" required type="text" class="form-control validate[required] text-input" id="checkin">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>CheckOut<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9"> <input name="checkout" required type="text" class="form-control validate[required] text-input" id="checkout">
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
												<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="Images-tab">
													<bR>
													<div class="row">
														<div class="col-xs-3"><strong>Upload Jungle Stay Room Images</strong></div>
														<div class="col-xs-5">
															<input name="jungleStayRoomsImages[]" id="jungleStayRooms[]" type="file" multiple required>
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




@endsection