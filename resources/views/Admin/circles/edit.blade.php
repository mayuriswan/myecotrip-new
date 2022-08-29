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
                <h1 class="page-header">Edit Circle</h1>
            </div>
        </div>
		<div class="form-group row">
		{{ Form::open(array('url' => 'admin/updateCircle')) }}
			<label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
			<div class="col-sm-10">
				<input type="hidden" name="circleId" value="{{$circleData['id']}}">
				<input type="text" class="form-control" id="name" placeholder="Circle Name" name="name"  value="{{$circleData['name']}}" required>
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
