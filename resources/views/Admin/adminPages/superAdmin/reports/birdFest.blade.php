
@extends('layouts.Admin.app')

@section('title', 'Bird fest reports')

@section('navBar')
     @include('layouts.Admin.superAdmin.topNav')

    @include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')
<!-- Multi select -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/multiselect.css')}}">
<script src="{{ URL::asset('assets/js/multiselect.js')}}"></script>

    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Download bird fest report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <form action="{{url('/')}}/admin/downloadBirdFestReport" method="POST">
        	<div class="row">
            <input type="hidden" name="requestFrom" value="circleAdmin">
        	<div class="container">
			   	<div class="row">
                    <div class="col-sm-3">

                        <select id="dates-field2" name="id" class="multiselect-ui form-control" required>
                            <option value="">Select the event</option>
                            @foreach($data as $id => $rows)
                                <option value="{{$rows['id']}}">{{$rows['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class='col-sm-4'>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Download</button>
                        </div>
                    </div>
                </div>
			</div>                
        </form>

    </div>
    <!-- /.container-fluid -->
</div>
    <!-- /#page-wrapper -->
@endsection

