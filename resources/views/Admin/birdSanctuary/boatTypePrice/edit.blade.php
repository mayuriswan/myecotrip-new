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
					<h1 class="page-header">Edit Boat Type Price</h1>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::open(array('url' => 'admin/updateBoatTypePrice', 'files' => true)) }}
				<input type="hidden" name="boatTypePriceId" value="{{$boatTypePriceData['id']}}">
				<div class="row">
					<div class="col-lg-12">
						<!-- <form action="createBoatTypePrice" method="post" enctype="multipart/form-data"> -->
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default ">
										<div class="panel-heading">
											<h3>
												<div class='pull-right'>
													<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
													<a href="boatTypePrice/{{$boatTypePriceData['birdSanctuary_id']}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
												</div>
												Boat Type Price Details
											</h3>
										</div>
										<div class="panel-body">
											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
														<div class="row">
															<div class="col-xs-3"><strong>Bird Sanctuary<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="birdSanctuary_id" id="birdSanctuary_id" required>
																	<option value="">Select the Bird Sanctuary</option>
																	@foreach($birdSanctuarylist as $birdSanctuaryDataList)
																		<option @if($boatTypePriceData['birdSanctuary_id'] == $birdSanctuaryDataList['id']) selected @endif value="{{$birdSanctuaryDataList['id']}}">{{$birdSanctuaryDataList['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Boat Type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9" id="boatType">
																<select class="form-control" name="boatType_id" id="boatType_id" required readonly disabled="">
																	<option value="">Select the Boat Type</option>
																	@foreach($boatTypeData as $boatType)
																		<option @if($boatTypePriceData['boatType_id'] == $boatType['id']) selected @endif  value="{{$boatType['id']}}">{{$boatType['name']}}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<br>
														<div class="row" id="normal_boat">
															<div class="col-lg-3"><strong>Bird Sanctuary Price&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-9">
																<table class="table table-bordered">
																<tr><th></th><th>Indian</th><th>Foriegn</th></tr>
																<tr><td>Senior Citizen</td>
																	<td><input type="text" name="senior_price_india" id="senior_price_india" class="form-control validate[required]" value="{{$boatTypePriceData['senior_price_india']}}" required></td>
																	<td><input type="text" name="senior_price_foreign" id="senior_price_foriegn" class="form-control validate[required]" value="{{$boatTypePriceData['senior_price_foreign']}}" required></td>
																</tr>
																<tr><td>Adult</td>
																	<td><input type="text" name="adult_price_india" id="adult_price_india" class="form-control validate[required]" value="{{$boatTypePriceData['adult_price_india']}}" required></td>
																	<td><input type="text" name="adult_price_foreign" id="adult_price_foreign" class="form-control validate[required]" value="{{$boatTypePriceData['adult_price_foreign']}}" required></td>
																</tr>

																<tr><td>Child</td>
																	<td><input type="text" name="child_price_india" id="child_price_india" class="form-control validate[required]" value="{{$boatTypePriceData['child_price_india']}}" required></td>
																	<td><input type="text" name="child_price_foreign" id="child_price_foreign" class="form-control validate[required]" value="{{$boatTypePriceData['child_price_foreign']}}" required></td>
																</tr>
															</table>
															</div>
														</div>
														<br>
														<div class="row" id="full_boat">
															<div class="col-lg-3"><strong>Bird Sanctuary Price&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
																<div class="col-lg-9">
																	<table class="table table-bordered">
																		<tr><th></th><th>Indian</th><th>Foriegn</th></tr>
																		<tr><td>Price</td>
																			<td><input type="text" name="price_india" id="price_india" class="form-control validate[required]" value="{{$boatTypePriceData['price_india']}}" required></td>
																			<td><input type="text" name="price_foreign" id="price_foreign" class="form-control validate[required]" value="{{$boatTypePriceData['price_foreign']}}" required></td>
																		</tr>
																	</table>
																</div>
														</div>
														<br>
														<div class="row">
															<div class="col-lg-3"><strong>From Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-3 ">
																<input type="date" name="from_date" id="from_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="{{$boatTypePriceData['from_date']}}">
															</div>
															<div class="col-lg-3" style="text-align: right"><strong>To Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-lg-3">
																<input type="date" name="to_date" id="to_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="{{$boatTypePriceData['to_date']}}">
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>Full Booking<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="full_booking" id="full_booking" required>
																	<option @if ($boatTypePriceData['full_booking'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($boatTypePriceData['full_booking'] == 0) selected @endif value="0">No</option>
																</select>
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-lg-3"><strong>Remarks<span class="text-red dk-font-18"></span>&nbsp;</strong></div>
															<div class="col-lg-9">
																<input type="text" name="remarks" id="remarks" class="form-control validate[required]" placeholder="Remarks" value="{{$boatTypePriceData['remarks']}}">
															</div>
														</div>
														<br>
														<div class="row">
															<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
															<div class="col-xs-9">
																<select class="form-control" name="isActive" id="isActive" required>
																	<option @if ($boatTypePriceData['isActive'] == 1) selected @endif value="1">Yes</option>
																	<option @if ($boatTypePriceData['isActive'] == 0) selected @endif value="0">No</option>
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
		$(document).ready(function () {

			var boatTypeVal = $('#boatType_id').val();
			if(boatTypeVal == '1'){
				$('#normal_boat').show();
				$('#full_boat').hide();
			}else{
				$('#normal_boat').hide();
				$('#full_boat').show();
			}
        });

        $('#btnModify').on('click',function () {
            var from_date = new Date($('#from_date').val());
            var to_date = new Date($('#to_date').val());

            if (Date.parse(from_date) > Date.parse(to_date)) {
                alert("Invalid Date Range!\nFrom Date cannot be after To Date!")
                return false;
            }
        });

        $("#birdSanctuary_id").change(function()
        {
            birdSanctuaryId = $("#birdSanctuary_id").val();
            if(birdSanctuaryId > 0) {
                var strURL = "getBoatTypes/" + birdSanctuaryId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }

                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#boatType").html(req.responseText);
            }
        });

        $(document).on('change','#boatType_id',function(){
			var boatTypeVal = $('#boatType_id').val();
        	if(boatTypeVal == '1'){
        		$('#normal_boat').show();
        		$('#full_boat').hide();
        		return true;
        	}else{
        		$('#full_boat').show();
        		$('#normal_boat').hide();
        		return true;
        	}
        });
	</script>
@endsection
