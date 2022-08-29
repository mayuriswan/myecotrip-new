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
					<h1 class="page-header">Add Parking Fee
						<a href="{{ url('admin/addParkingFee') }}" title="Add">
							<button type="button" class="btn btn-primary addNewButton">Add new</button>
						</a>
					</h1>
				</div>
			</div>

			<div class="flash-message">
              @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}" >{{ Session::get('alert-' . $msg) }}</p>
                @endif
              @endforeach
            </div>

			<div class="row">
				<div class="col-lg-12">
					<form action="{{url('/')}}/admin/createParkingFee" method="post" enctype="multipart/form-data">
						<input type="hidden" name="birdSanctuary_id" value="{{$birdSancturyId}}">
						<input type="hidden" name="version" value="{{$currentVersion}}">
						
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
												<a href="{{url('/')}}/admin/parkingFee/{{$birdSancturyId}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
											</div>
											Parking Fee Details
										</h3>
									</div>
									<div class="panel-body">
										<div class="" role="tabpanel" data-example-id="togglable-tabs">
											<div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
												<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
													
													@foreach($data as $key => $type)
<div class="row form-group">
   <label class="control-label col-sm-4">{{$type['type']}}: </label>
   <div class="col-sm-5">
      <input type="number" min="0" value="0" class="form-control" name="type[{{$type['id']}}]" placeholder="Enter amount for {{$type['type']}}" required>
   </div>
</div>

													@endforeach

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
															<select class="form-control" name="isActive" id="isActive" required>
																<option value="1">Yes</option>
																<option value="0">No</option>
															</select>
														</div>
													</div>
													<br>
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
		$("#birdSanctuary_id").change(function()
        {
            birdSanctuaryId = $("#birdSanctuary_id").val();
            if(birdSanctuaryId > 0) {
                var strURL = "getParkingDetails/" + birdSanctuaryId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }

                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#details").html(req.responseText);
            }
        });
	</script>
@endsection