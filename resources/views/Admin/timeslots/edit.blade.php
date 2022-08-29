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
					<h1 class="page-header">Edit Time Slots</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateTimeSlots', 'files' => true)) }}
				<input type="hidden" name="id" value="{{$timeslotsData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createTimeSlots" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="timeslots" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Time Slots details
											</h3>
										</div>
										<div class="panel-body">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a></li>
												</ul>
												<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-xs-3"><strong>Time Slots<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9"> <input name="timeslots" required type="text" class="form-control validate[required] text-input" value="{{ $timeslotsData['timeslots']}}" id="timeslots">
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" required name="isActive" id="isActive" required>
																	<option @if($timeslotsData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if($timeslotsData['isActive'] == 0) selected @endif value="0">No</option>
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
@endsection
