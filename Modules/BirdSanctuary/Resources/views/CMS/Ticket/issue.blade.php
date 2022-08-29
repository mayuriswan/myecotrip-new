@extends('birdsanctuary::layouts.master')

@section('title', 'Bird Sanctuary Admin')

@section('navBar')
    @include('birdsanctuary::layouts.topNav')
    @include('birdsanctuary::layouts.sideNav')
@endsection

@section('content')
<div id="page-wrapper">
   	<div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Book Now</h1>
      </div>
      <!-- /.col-lg-12 -->
   	</div>

   	<div class="row">
   		<div class="col-md-9">
   			<div class="flash-message">
				@foreach (['danger', 'warning', 'success', 'info'] as $msg)
					@if(Session::has('alert-' . $msg))
						<p class="alert alert-{{ $msg }}" >{{ Session::get('alert-' . $msg) }}</p>
					@endif
				@endforeach
			</div>
   		</div>
   		<div class="col-md-3">
   			<div class="float-right">
	         	<input style="float: right" type="button" class="btn btn-primary" onclick="validateRequest()" value="Generate ticket" />
	         </div>
   		</div>
   	</div>

   	


	<div class="container-fluid">

		<ul class="nav nav-tabs">
		    <li class="active"><a data-toggle="tab" href="#home">Entrance</a></li>
		    @if($hasCameraTypes)
		    	<li><a data-toggle="tab" href="#menu1">Camera</a></li>
		    @endif
		    @if($hasBoating)
		    	<li><a data-toggle="tab" href="#menu2">Boating</a></li>
		    @endif
		    @if(count($parkingPricing))
		    	<li><a data-toggle="tab" href="#menu3">Parking</a></li>
		    @endif
	  	</ul>

		<form method="POST" action="{{url('/')}}/bs-admin/book-ticket" id="myForm">

		  	<div class="tab-content">
			    <div id="home" class="tab-pane fade in active">
			      <h3>Enter entrance ticket details : </h3>
			      <hr>
                    <div class="row" id="entryAlert" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color:red" id="alertMessage">Please enter atleast one Entry ticket.</label>
                            </div>
                        </div>
                    </div>

			      	<div class="row">
			            <div class="col-md-8">
			                <div class="row" id="entryAlert" style="display: none;">
			                    <div class="col-md-12">
			                        <div class="form-group">
			                            <label style="color:red" id="alertMessage">Please enter atleast one Entry ticket.</label>
			                        </div>
			                    </div>
			                </div>

			                <input type="hidden" id="numberOfEntranceType" value="{{count($entryPricing)}}">
			                @foreach($entryPricing as $index => $entranceType)
			                    <div class="row">
			                        <div class="col-md-6">
			                            <div class="form-group">
			                                <label class="priceMasterLabel">{{$entranceType['name']}}</label>
			                            </div>
			                        </div>
			                        <div class="col-md-3">
			                        	<label>&#8377; {{$entranceType['price']}} / Person</label>
			                        </div>
			                        <div class="col-md-3">
			                            <div class="form-group col-md-8">
			                                <input class="form-control numberTextbox" id="entry_{{$index}}" name="entry[{{$entranceType['id']}}]" type="number" min="0" value="0" required />
			                                
			                            </div>
			                        </div>
			                                               
			                    </div>
			                @endforeach
			            </div>
			        </div>
			    </div> <!-- End of entrance div -->

			    @if($hasCameraTypes)
				    <div id="menu1" class="tab-pane fade">
				      <h3>Enter camera details : </h3>
				      <hr>
				      <div class="row">
				      	@foreach($camers as $camera)
		                    <div class="row">
		                        <div class="col-md-4">
		                            <div class="form-group">
		                                <label class="priceMasterLabel">{{$camera['type']}}</label>
		                            </div>
		                        </div>
		                        <div class="col-md-3">
		                        	<label>&#8377; {{$camera['price']}} / Camera</label>
		                        </div>
		                        <div class="col-md-3">
		                            <div class="form-group col-md-8">
		                                <input class="form-control numberTextbox" name="camera[{{$camera['id']}}]" type="number" min="0" value="0" required />
		                                
		                            </div>
		                        </div>
		                                               
		                    </div>
		                @endforeach
				      </div>
				    </div>
				
				@endif
				@if($hasBoating)
				    <div id="menu2" class="tab-pane fade">
				      <h3>Enter boating details : </h3>
				      <hr>
				      <div class="row">
				      	@foreach($boatings as $type => $boating)
	                        <div class="row">
	                            <div class="col-md-12">
	                                <div class="form-group">
	                                    <label><h5>Category : {{$type}}</h5></label>
	                                </div>
	                            </div>
	                        </div>

	                        @foreach($boating as $index => $botingType)
	                            <div class="row">
	                                <div class="col-md-4">
	                                    <div class="form-group">
	                                        <label>{{$botingType['name']}}</label>
	                                    </div>
	                                </div>
	                                <div class="col-md-3">
			                        	<label>&#8377; {{$botingType['price']}} {{$botingType['shortDesc']}}</label>
			                        </div>
	                                <div class="col-md-3">
	                                    <div class="form-group col-md-8">
	                                        <input class="form-control numberTextbox" id="entry7" name="boating[{{$botingType['id']}}]" type="number" min="0" value="0" required />
	                                    </div>
	                                </div>
	                                
	                            </div>

	                        @endforeach
	                        <hr>
	                    @endforeach
				      </div>
				    </div>
			    @endif


			   	@if(count($parkingPricing))
				    <div id="menu3" class="tab-pane fade">
				      <h3>Enter parking details : </h3>
				      <hr>
				      <div class="row">
				      	@foreach($parkingPricing as $parking)
		                    <div class="row">
		                        <div class="col-md-4">
		                            <div class="form-group">
		                                <label class="priceMasterLabel">{{$parking['name']}}</label>
		                            </div>
		                        </div>
		                        <div class="col-md-3">
		                        	<label>&#8377; {{$parking['price']}} {{$parking['shortDesc']}}</label>
		                        </div>
		                        <div class="col-md-3">
		                            <div class="form-group col-md-8">
		                                <input class="form-control numberTextbox" name="parking[{{$parking['id']}}]" type="number" min="0" value="0" required />
		                                
		                            </div>
		                        </div>
		                                               
		                    </div>
		                @endforeach
				      </div>
				    </div>
				@endif
		  	</div>
	  	</form>
	</div>
   
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
	function validateRequest() {

        // Validate user has selected at least one ticket
        var hasEntry = false;
        for(var i = 0; i < 7; i++)
        {
            if (document.getElementById('entry_' + i).value > 0) {
                hasEntry = true;
                break;
            }
        } 

        if (!hasEntry) {
            document.getElementById("entryAlert").style.display = "block";
            document.getElementById("alertMessage").innerHTML  = "Please enter atleast one Entry ticket.";
            return;
        }else{
            document.getElementById("entryAlert").style.display = "none";
        }



        //Validate teacher s seleted without selecting students 
        var validated = true;
        // if (document.getElementById('entry7').value > 0 && (document.getElementById('entry5').value < 1 && document.getElementById('entry6').value < 1)) {
        //     validated = false;
        // }

        // if (!validated) {
        //     document.getElementById("entryAlert").style.display = "block";
        //     document.getElementById("alertMessage").innerHTML  = "You can not book 'Teachers / Lecturers' ticket without selecting 'Primary school / High school / College' ticket. ";
        // }else{
        //     document.getElementById("entryAlert").style.display = "none";
        // }

        //If all Okay. Submit
        if (hasEntry && validated) {
            document.getElementById("myForm").submit();
        }
    }
</script>

@endsection

