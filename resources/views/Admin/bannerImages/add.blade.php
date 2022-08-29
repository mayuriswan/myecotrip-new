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
					<h1 class="page-header">Add Banner Image
						<a href="{{ url('admin/addBannerImages') }}" title="Edit">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="createBannerImages" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
												<a href="bannerImages" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
											</div>
											Banner Image details
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
														<div class="col-xs-3"><strong>Type &nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" required name="type" id="type" required>
																<option value="">Select the Type</option>
																<option value="homepage">HomePage</option>
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Upload Banner Image *</strong></div>
														<div class="col-xs-5">
															<input name="path" id="path" type="file" required>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Hyper Link <span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<input name="href" type="text" class="form-control validate[required] text-input" id="href">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Title <span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<input name="title" type="text" class="form-control">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Title color<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<input name="title_color" type="text" class="form-control">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Short Description <span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<input name="short_description" type="text" class="form-control validate[required] text-input">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Button Name <span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<input name="button_name" type="text" class="form-control validate[required] text-input">
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