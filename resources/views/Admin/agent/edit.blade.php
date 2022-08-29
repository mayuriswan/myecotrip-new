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
                <h1 class="page-header">Edit Agent admin</h1>
            </div>
        </div>

    @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    
    {{ Form::open(array('url' => 'admin/updateAgent')) }}
    <input type="hidden" name="id" value="{{$adminData['id']}}">
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" id="name" placeholder="Admin Name" name="name" value="{{$adminData['name']}}" required>
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
