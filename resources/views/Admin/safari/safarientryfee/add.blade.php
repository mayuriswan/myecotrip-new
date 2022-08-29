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
					<h1 class="page-header">Add Safari Entry Fee
						<a href="{{ url('admin/addsafariEntryFee') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<form action="createsafariEntryFee" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
												<a href="safariEntryFee" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
											</div>
											Safari Entry Fee details
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
														<div class="col-xs-3"><strong>Safari<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" required name="safari_id" id="safari_id" required>
																<option value="">Select the Safari</option>
																@foreach($safariList as $safariDataList)
																	<option value="{{$safariDataList['id']}}">{{$safariDataList['name']}}</option>
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
																	<td><input type="text" name="senior_price_india" id="senior_price_india" class="form-control validate[required]" required></td>
																	<td><input type="text" name="senior_price_foreign" id="senior_price_foriegn" class="form-control validate[required]" required></td>
																</tr>
																<tr><td>Adult</td>
																	<td><input type="text" name="adult_price_india" id="adult_price_india" class="form-control validate[required]" required></td>
																	<td><input type="text" name="adult_price_foreign" id="adult_price_foreign" class="form-control validate[required]" required></td>
																</tr>

																<tr><td>Child</td>
																	<td><input type="text" name="child_price_india" id="child_price_india" class="form-control validate[required]" required></td>
																	<td><input type="text" name="child_price_foreign" id="child_price_foreign" class="form-control validate[required]" required></td>
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
														<div class="col-xs-3"><strong>isActive<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
														<div class="col-xs-9">
															<select class="form-control" required name="isActive" id="isActive" required>
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

        var id;
        $('#safari_id').on('change', function() {
            id = this.value;
            if(id.length == 1){
                id = 'My0'+this.value;
            }else{
                id = 'My'+this.value;
            }
            getdisplayName();
        });
        function getdisplayName() {
            $('#vehicle_no').val('');
            $("#displayName").val('');
            $('#vehicle_no').on("keyup", function(){
                var vehicle_no = document.getElementById('vehicle_no').value;
                vehicle_no = vehicle_no.slice(-4);
                var displayName = id + vehicle_no;
                $("#displayName").val(displayName);
            });
        }

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