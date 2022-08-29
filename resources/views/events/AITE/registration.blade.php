@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

<!-- <div  style="background-image: url({{asset('assets/img/Events/AITE/20171227_160948.jpg') }}); background-repeat: no-repeat;    background-size: 100% 100%;"> -->
    <div class="container">
        <h1 class="page-title" style="font-size: 36px !important;">AITE Volunteers registration form</h1>
    </div>

    <div class="container">
        <div class="row">
    		<div class="col-md-12">
                <div class="row">
                    <div class="col-md-5">
                    	@if(Session::has('profileUpdateMessage'))
						    <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('profileUpdateMessage') }}</p>
						@endif

                        <form action="registerAITE" method="POST">
                            <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                <label>Full Name</label>
                                <input class="form-control" name="name"  type="text" required placeholder="Full Name" />
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
                                <label>E-mail</label>
                                <input class="form-control" type="text" placeholder="E-mail" name="email" required/>
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon"></i>
                                <label>Phone Number</label>
                                <input class="form-control" name="contact_no"  type="number" placeholder="Phone Number" required/>
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                <label>VTP ID</label>
                                <input class="form-control" name="VTP_ID" type="text" placeholder="VTP ID" required/>
                            </div>
                            <div class="gap gap-small"></div>
                            <div class="form-group">
                                <label>Volunteering program</label>
                                <select name="program_type" class="form-control" required>
                                	<option value="">Select Volunteering program</option>
	                             	<option value="4 day volunteering program ( 7 - 10 Jan )">4 day volunteering program ( 7 - 10 Jan )</option>
	                             	<option value="7 day volunteering program ( 7 - 13 Jan )">7 day volunteering program ( 7 - 13 Jan )</option>
	                          	</select>
                            </div>
                            <div class="form-group">
                                <label>Tiger reserve</label>
                                <select name="tiger_reserve" class="form-control" required>
                                	<option value="">Select Tiger reserve</option>
	                            	@foreach($tigerReservesList as $tigerReserve)
	                            		<option>{{$tigerReserve['name']}}</option>
	                            	@endforeach
	                            	</select>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-primary" value="Save Changes">
                        </form>
                    </div>
                    <div class="col-md-6 col-md-offset-1"  >
                    	<img src={{asset('assets/img/Events/AITE/20171227_160948.jpg') }} style="height: 523px;"">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="gap"></div>
<!-- </div> --> 
@endsection
