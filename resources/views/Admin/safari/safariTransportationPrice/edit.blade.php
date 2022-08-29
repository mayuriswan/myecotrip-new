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
					<h1 class="page-header">Edit Safari Transportation Price</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateSafariTransportationPrice', 'files' => true)) }}
				<input type="hidden" name="id" value="{{$safariTransportationPrice['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<form action="createSafariTransportationPrice" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="safariTransportationPrice" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Safari Transportation Price details
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
															<div class="col-xs-3"><strong>Safari Transportation Price<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" required name="safari_id" id="safari_id" required disabled>
																	<option value="">Select the Safari</option>
																	@foreach($safariData as $safariList)
																		<option @if($safariTransportationPrice['safari_id'] == $safariList['id']) selected @endif value="{{$safariList['id']}}">{{$safariList['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Transportation<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" required name="transportation_id" id="transportation_id" required>
																	<option value="">Select the transportation</option>
																	@foreach($transporttypesData as $transporttypesList)
																		<option @if($safariTransportationPrice['transportation_id'] == $transporttypesList['id']) selected @endif  value="{{$transporttypesList['id']}}">{{$transporttypesList['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-lg-3"><strong>Price&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-9">
																<table class="table table-bordered">
																	<tr><th></th><th>Indian</th><th>Foriegn</th></tr>
																	<tr><td>Senior Citizen</td>
																		<td><input type="text" name="senior_price_india" id="senior_price_india" class="form-control validate[required]" value="{{$safariTransportationPrice['senior_price_india']}}" required></td>
																		<td><input type="text" name="senior_price_foreign" id="senior_price_foriegn" class="form-control validate[required]" value="{{$safariTransportationPrice['senior_price_foreign']}}" required></td>
																	</tr>
																	<tr><td>Adult</td>
																		<td><input type="text" name="adult_price_india" id="adult_price_india" class="form-control validate[required]" value="{{$safariTransportationPrice['adult_price_india']}}" required></td>
																		<td><input type="text" name="adult_price_foreign" id="adult_price_foreign" class="form-control validate[required]" value="{{$safariTransportationPrice['adult_price_foreign']}}" required></td>
																	</tr>

																	<tr><td>Child</td>
																		<td><input type="text" name="child_price_india" id="child_price_india" class="form-control validate[required]" value="{{$safariTransportationPrice['child_price_india']}}" required></td>
																		<td><input type="text" name="child_price_foreign" id="child_price_foreign" class="form-control validate[required]" value="{{$safariTransportationPrice['child_price_foreign']}}" required></td>
																	</tr>

																</table>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-lg-3"><strong>No. of Seats&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<input type="text" name="no_of_seats" id="no_of_seats" class="form-control validate[required]" required placeholder="No. of Seats" type="text" value="{{$safariTransportationPrice['no_of_seats']}}">
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Allow Seat Selection<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" required name="allow_seat_selection" id="allow_seat_selection" required>
																	<option @if ($safariTransportationPrice['allow_seat_selection'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($safariTransportationPrice['allow_seat_selection'] == 0) selected @endif value="0">No</option>
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" required name="isActive" id="isActive" required>
																	<option @if ($safariTransportationPrice['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($safariTransportationPrice['isActive'] == 0) selected @endif value="0">No</option>
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

	<script>

        $('#safari_id').on('change', function() {
            var id;
            $('#vehicle_no').val('');
            $('#displayName').val('');
            id = this.value;
            if(id.length == 1){
                id = 'My0'+this.value;
            }else{
                id = 'My'+this.value;
            }
            var vehicle_no = $(this).val();
            vehicle_no = vehicle_no.slice(-4);
            var displayName = id + vehicle_no;
            $('#displayName').val(displayName)
        });

        $('#vehicle_no').on("change paste keyup", function() {
            var safariid = document.getElementById('safari_id').value;
            $('#displayName').val('');
            var vehicle_no = $(this).val();
            vehicle_no = vehicle_no.slice(-4);
            if(safariid.length == 1){
                safariid = 'My0'+safariid;
            }else{
                safariid = 'My'+safariid;
            }
            var displayName = safariid + vehicle_no;
            $('#displayName').val(displayName);
        });

	</script>
	<script>
	$('#btnModify').click(function () {
        $("#safari_id").removeAttr("disabled");
    })
	</script>
@endsection
