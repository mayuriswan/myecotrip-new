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
					<h1 class="page-header">Add pricing for boating
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
					<form action="{{url('/')}}/admin/createBoatTypePrice" method="post" enctype="multipart/form-data">
						<input type="hidden" name="birdSanctuary_id" value="{{$birdSanctuaryId}}">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default ">
									<div class="panel-heading">
										<h3>
											<div class='pull-right'>
												<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
												<a href="{{url('/')}}/admin/boatTypePrice/{{$birdSanctuaryId}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
											</div>
											Boat Type Price Details
										</h3>
									</div>
									<div class="panel-body">
										<div class="" role="tabpanel" data-example-id="togglable-tabs">
											<div id="myTabContent" class="tab-content" >
												<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
													
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Basic</a></li>

    @foreach($boatTypeData as $key => $boats)
    	<li><a data-toggle="tab" href="#menu{{$key}}">{{$boats['name']}}</a></li>

    @endforeach
    
</ul>

<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>Common details </h3>
      <hr>
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
			<div class="col-lg-3"><strong>Remarks<span class="text-red dk-font-18"></span>&nbsp;</strong></div>
			<div class="col-lg-9">
				<input type="text" name="remarks" id="remarks" class="form-control validate[required]" placeholder="Remarks" value="">
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

    @foreach($boatTypeData as $key => $boats)
		<div id="menu{{$key}}" class="tab-pane fade">
	      <h3>Pricing for  {{$boats['name']}}</h3>
  		@if(!$boats['full_booking'])
	      	@foreach($pricinMaster as $key => $type)
	      		@if($type['type'] == 1)
		      		<!-- for indivudual -->
					<div class="row form-group">
					   <label class="control-label col-sm-4">{{$type['name']}}: </label>
					   <div class="col-sm-5">
					      <input type="number" min="0" value="0" class="form-control" name="type[{{$type['id']}}||{{$boats['id']}}]" placeholder="Enter amount for {{$type['name']}}" required>
					   </div>
					</div>
				@endif
			@endforeach
		@elseif($boats['id'] == 2)
			<div class="row form-group">
			   <label class="control-label col-sm-4">Amount: </label>
			   <div class="col-sm-5">
			      <input type="number" min="0" value="0" class="form-control" name="type[8||{{$boats['id']}}]" placeholder="Enter amount for {{$type['name']}}" required>
			   </div>
			</div>
		@else
			<div class="row form-group">
			   <label class="control-label col-sm-4">Amount: </label>
			   <div class="col-sm-5">
			      <input type="number" min="0" value="0" class="form-control" name="type[9||{{$boats['id']}}]" placeholder="Enter amount for {{$type['name']}}" required>
			   </div>
			</div>
      	@endif
	    </div>
    @endforeach

    
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
        	$('#normal_boat').hide();
        	$('#full_boat').hide();
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


    			$('#price_india').removeAttr('required');
    			$('#price_foreign').removeAttr('required');


        		return true;
        	}else{
        		$('#full_boat').show();
        		$('#normal_boat').hide();

        		var divToremoveValidation = ['senior_price_india', 'senior_price_foriegn','adult_price_india' ,'adult_price_foreign', 'child_price_india', 'child_price_foreign'];

        		for (var i = 0; i < divToremoveValidation.length  ; i++) {
    				$('#' + divToremoveValidation[i]).removeAttr('required');
        		}


        		return true;
        	}
        });
	</script>

@endsection