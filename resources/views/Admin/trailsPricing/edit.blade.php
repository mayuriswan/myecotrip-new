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
					<h1 class="page-header">Edit EcoTrail Price
						<a href="{{ url('admin/addTrialPricing') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="updateTrialPricing" method="post" enctype="multipart/form-data">
					<input type="hidden" name="trailPricingId" value="{{$trailPricingData['id']}}">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
												<a href="getTrialPricing" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
											</div>
											Trail Pricing Details
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
														<div class="col-xs-2"><strong>TimeSlot<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-4">
															<select class="form-control" required name="ecotrailTimeSlots_id" id="ecotrailTimeSlots_id" required>
																<option value="">Select the TimeSlot</option>
																@foreach($getEcoTrailTimeSlots as $timeSlots)
																	<option @if($trailPricingData['ecotrailTimeSlots_id'] == $timeSlots['id']) selected @endif value="{{$timeSlots['id']}}">{{$timeSlots['timeslots']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-2"><strong>Trails<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-4">
															<select class="form-control" required name="trail_id" id="trail_id" required>
																<option value="">Select the Trail</option>
																@foreach($getTrails as $trails)
																	<option @if($trailPricingData['trail_id'] == $trails['id']) selected @endif value="{{$trails['id']}}">{{$trails['name']}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-lg-2"><strong>Price&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-lg-10">
															<table class="table table-bordered">
																<col>
																  	<colgroup span="3"></colgroup>
																  	<colgroup span="3"></colgroup>
																  	<tr>
																    	<td rowspan="2"></td>
																    	<th colspan="3" scope="colgroup">India</th>
																    	<th colspan="3" scope="colgroup">Foreign</th>
																  	</tr>
																  	<tr>
																    	<th scope="col">TAC</th>
																    	<th scope="col">Entry Fee</th>
																    	<th scope="col">Guide Fee</th>
																    	<th scope="col">TAC</th>
																    	<th scope="col">Entry Fee</th>
																    	<th scope="col">Guide Fee</th>
																  	</tr>
																  	<tr>
																    	<th scope="row">Adult</th>
																    	<td><input type="text" name="data[India][adult][TAC]" id="india_adult_tac" class="form-control validate[required]" value="{{$prices['india_adult_tac']}}" required></td>
																    	<td><input type="text" name="data[India][adult][entry_fee]" id="india_adult_entryfee" class="form-control validate[required]" value="{{$prices['india_adult_entry_fee']}}" required></td>
																    	<td><input type="text" name="data[India][adult][guide_fee]" id="india_adult_guidefee" class="form-control validate[required]" value="{{$prices['india_adult_guide_fee']}}" required></td>
																    	<td><input type="text" name="data[Foreign][adult][TAC_foreign]" id="foreign_adult_tac" class="form-control validate[required]" value="{{$prices['foreign_adult_tac']}}" required></td>
																    	<td><input type="text" name="data[Foreign][adult][entry_fee_foreign]" id="foreign_adult_entryfee" class="form-control validate[required]" value="{{$prices['foreign_adult_entry_fee']}}" required></td>
																    	<td><input type="text" name="data[Foreign][adult][guide_fee_foreign]" id="foreign_adult_guidefee" class="form-control validate[required]" value="{{$prices['foreign_adult_guide_fee']}}" required></td>
																  	</tr>
																  	<tr>
																    	<th scope="row">Child</th>
																    	<td><input type="text" name="data[India][child][TAC_child]" id="india_child_tac" class="form-control validate[required]" value="{{$prices['india_child_tac']}}" required></td>
																    	<td><input type="text" name="data[India][child][entry_fee_child]" id="india_child_entryfee" class="form-control validate[required]" value="{{$prices['india_child_entry_fee']}}" required></td>
																    	<td><input type="text" name="data[India][child][guide_fee_child]" id="india_child_guidefee" class="form-control validate[required]" value="{{$prices['india_child_guide_fee']}}" required></td>
																    	<td><input type="text" name="data[Foreign][child][TAC_foreign_child]" id="foreign_child_tac" class="form-control validate[required]" value="{{$prices['foreign_child_tac']}}" required></td>
																    	<td><input type="text" name="data[Foreign][child][entry_fee_foreign_child]" id="foreign_child_entryfee" class="form-control validate[required]" value="{{$prices['foreign_child_entry_fee']}}" required></td>
																    	<td><input type="text" name="data[Foreign][child][guide_fee_foreign_child]" id="foreign_child_guidefee" class="form-control validate[required]" value="{{$prices['foreign_child_guide_fee']}}" required></td>
																  	</tr>
																  	<tr>
																    	<th scope="row">Student</th>
																    	<td><input type="text" name="data[India][student][TAC]" id="india_student_tac" class="form-control validate[required]" value="{{$prices['india_student_tac']}}" required></td>
																    	<td><input type="text" name="data[India][student][entry_fee]" id="india_student_entryfee" class="form-control validate[required]" value="{{$prices['india_student_entry_fee']}}" required></td>
																    	<td><input type="text" name="data[India][student][guide_fee]" id="india_student_guidefee" class="form-control validate[required]" value="{{$prices['india_student_guide_fee']}}" required></td>
																    	<td><input type="text" name="data[Foreign][student][TAC_foreign_student]" id="foreign_student_tac" class="form-control validate[required]" value="{{$prices['foreign_student_tac']}}" required></td>
																    	<td><input type="text" name="data[Foreign][student][entry_fee_foreign_student]" id="foreign_student_entryfee" class="form-control validate[required]" value="{{$prices['foreign_student_entry_fee']}}" required></td>
																    	<td><input type="text" name="data[Foreign][student][guide_fee_foreign_student]" id="foreign_student_guidefee" class="form-control validate[required]" value="{{$prices['foreign_student_guide_fee']}}" required></td>
																  	</tr>
															</table>
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-lg-2"><strong>From Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-lg-3 ">
															<input type="date" name="from" id="from_date" class="form-control validate[required]" value="{{$trailPricingData['from']}}" required placeholder="MM/DD/YYY" value="">
														</div>
														<div class="col-lg-2" style="text-align: right"><strong>To Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-lg-3">
															<input type="date" name="to" id="to_date" class="form-control validate[required]" value="{{$trailPricingData['to']}}" required placeholder="MM/DD/YYY" value="">
														</div>
													</div>
													<br>
													<div class="row">
														<div class="col-xs-2"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-4">
															<select class="form-control" required name="status" id="isActive" required>
																<option @if ($trailPricingData['status'] == 1) selected @endif value="1">Yes</option>
																<option @if ($trailPricingData['status'] == 0) selected @endif value="0">No</option>
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