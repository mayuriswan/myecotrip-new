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
					<h1 class="page-header">Add JungleStay Room Price
						<a href="{{ url('admin/addJungleStayRoomsPrice') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="createJungleStayRoomsPrice" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
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
																@foreach($jungleStayList as $jungleStayDataList)
																	<option value="{{$jungleStayDataList['id']}}">{{$jungleStayDataList['name']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-3"><strong>Room Type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9" id="room_id">
															<select class="form-control" name="jungleStayRooms_id" id="jungleStayRooms_id" required>
																<option value="">Select the Room Type</option>
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
																	<td><input type="text" name="price_india" id="price_india" class="form-control validate[required]" required></td>
																	<td><input type="text" name="price_foreign" id="price_foreign" class="form-control validate[required]" required></td>
																</tr>
																<tr><td>Extra Bed Price</td>
																	<td><input type="text" name="extra_bed_price_india" id="extra_bed_price_india" class="form-control validate[required]" required></td>
																	<td><input type="text" name="extra_bed_price_foreign" id="extra_bed_price_foreign" class="form-control validate[required]" required></td>
																</tr>
															</table>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-lg-3"><strong>From Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-lg-3 ">
															<input type="date" name="from_date" id="from_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="">
														</div>
														<div class="col-lg-3" style="text-align: right"><strong>To Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-lg-3">
															<input type="date" name="to_date" id="to_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-lg-3"><strong>Remarks<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-lg-9">
															<input type="text" name="remarks" id="remarks" class="form-control validate[required]" required placeholder="Remarks" value="">
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

        $("#jungleStay_id").change(function()
        {
            jungleStayId = $("#jungleStay_id").val();
            if(jungleStayId > 0) {
                var strURL = "getJungleStayRooms/" + jungleStayId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }

                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#room_id").html(req.responseText);
            }
        });

        $(document).ready(function () {
            $("#from_date").datepicker();
            $("#to_date").datepicker();
        });

        $('#btnModify').on('click',function () {
            var from_date = new Date($('#from_date').val());
            var to_date = new Date($('#to_date').val());

            if (Date.parse(from_date) > Date.parse(to_date)) {
                alert("Invalid Date Range!\nFrom Date cannot be after To Date!")
                return false;
            }
        });

	</script>

@endsection