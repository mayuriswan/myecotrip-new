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
                <h1 class="page-header">Edit Trail admin</h1>
            </div>
        </div>
		{{ Form::open(array('url' => 'admin/updateTrailAdmin')) }}
		<input type="hidden" name="id" value="{{$adminData['id']}}">
		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="name" placeholder="Admin Name" name="name" value="{{$adminData['name']}}" required>
			</div>
		</div>

		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Trail</label>
			<div class="col-sm-5">
				<select class="form-control" required name="trail_id">
					<option>Select the Trail</option>
					@foreach($trialList as $trail)
						<option @if($adminData['trail_id'] == $trail['id']) selected @endif value="{{$trail['id']}}">{{$trail['name']}}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Designation</label>
			<div class="col-sm-5">
				<select class="form-control" required name="designation">
					<option>Select the role</option>
					<option @if($adminData['designation'] == "Drfo") selected @endif value="Drfo">Drfo</option>
					<option @if($adminData['designation'] == "Forest Guard") selected @endif value="Forest Guard">Forest Guard</option>
					<option @if($adminData['designation'] == "Forest Watcher") selected @endif value="Forest Watcher">Forest Watcher</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
			<div class="col-sm-5">
				<input type="email" class="form-control" id="email" placeholder="Admin email" name="email" value="{{$adminData['email']}}" required>
			</div>
		</div>

		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Phone No</label>
			<div class="col-sm-5">
				<input type="number" min="0" class="form-control" placeholder="Admin Phone No" name="phone_no" value="{{$adminData['phone_no']}}" required>
			</div>
		</div>

		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="password"  placeholder="Admin password" name="password">
			</div>
		</div>

		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">Confirm password</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" id="confirmPassword"  placeholder="Admin confirmPassword" name="confirmPassword">
			</div>
		</div>



		<div class="modal-footer">
	      <button type="submit" class="btn btn-success">Update</button>
	    </div>
	    {{ Form::close() }}
	</div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


@endsection
