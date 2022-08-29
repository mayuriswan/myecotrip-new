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
					<h1 class="page-header">Edit JungleStay Room Price</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateJungleStayRoomsPrice', 'files' => true)) }}
				<input type="hidden" name="jungleStayRoomsPriceId" value="{{$jungleStayRoomPriceData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createJungleStayRoomsPrice" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="jungleStayRoomsPrice" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												JungleStay Room Price Details
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
															<div class="col-xs-3"><strong>Jungle Stay<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="jungleStay_id" id="jungleStay_id" required>
																	<option value="">Select the Jungle Stay</option>
																	@foreach($jungleStaylist as $jungleStayDataList)
																		<option @if($jungleStayRoomPriceData['jungleStay_id'] == $jungleStayDataList['id']) selected @endif value="{{$jungleStayDataList['id']}}">{{$jungleStayDataList['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Room Type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="jungleStayRooms_id" id="jungleStayRooms_id" required>
																	<option value="">Select the Room Type</option>
																	@foreach($jungleStayRoomslist as $jungleStayRoomslist)
																		<option @if($jungleStayRoomPriceData['jungleStayRooms_id'] == $jungleStayRoomslist['id']) selected @endif value="{{$jungleStayRoomslist['id']}}">{{$jungleStayRoomslist['type']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-lg-3"><strong>Room Price&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-9">
																<table class="table table-bordered">
																	<tr><th></th><th>Indian</th><th>Foriegn</th></tr>
																	<tr><td>Room Price</td>
																		<td><input type="text" name="price_india" id="price_india" class="form-control validate[required]" value="{{$jungleStayRoomPriceData['price_india']}}" required></td>
																		<td><input type="text" name="price_foreign" id="price_foreign" class="form-control validate[required]" value="{{$jungleStayRoomPriceData['price_foreign']}}" required></td>
																	</tr>
																	<tr><td>Extra Bed Price</td>
																		<td><input type="text" name="extra_bed_price_india" id="extra_bed_price_india" class="form-control validate[required]" value="{{$jungleStayRoomPriceData['extra_bed_price_india']}}" required></td>
																		<td><input type="text" name="extra_bed_price_foreign" id="extra_bed_price_foreign" class="form-control validate[required]" value="{{$jungleStayRoomPriceData['extra_bed_price_foreign']}}" required></td>
																	</tr>
																</table>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-lg-3"><strong>From Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-3 ">
																<input type="date" name="from_date" id="from_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="{{$jungleStayRoomPriceData['from_date']}}">
															</div>
															<div class="col-lg-3" style="text-align: right"><strong>To Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-3">
																<input type="date" name="to_date" id="to_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="{{$jungleStayRoomPriceData['to_date']}}">
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-lg-3"><strong>Remarks<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-9">
																<input type="text" name="remarks" id="remarks" class="form-control validate[required]" required placeholder="Remarks" value="{{$jungleStayRoomPriceData['remarks']}}">
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($jungleStayRoomPriceData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($jungleStayRoomPriceData['isActive'] == 0) selected @endif value="0">No</option>
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
