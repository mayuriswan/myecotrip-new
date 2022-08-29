@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.trails.topNav')

    @include('layouts.Admin.trails.sideNav')
@endsection

@section('content')

<div id="page-wrapper">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Offline Bookings</h1>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   

<form action="saveOfflineTrailBooking" method="POST">
    <input type="hidden" name="requestedSeats" value="{{$_POST['number_of_trekkers']}}">
    <input type="hidden" name="requestedChildrenSeats" value="{{$_POST['number_of_children']}}">
    <input type="hidden" name="requestedStudentSeats" value="{{$_POST['number_of_students']}}">

   @if(Session::has('message'))
   <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
   @endif

    <h4>Primary details</h4>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Timeslot</label>
                <select class="form-control" name="time_slot" required="">
                    <option value="">Select time slot</option>
                    @foreach($timeSlots as $timeSlot)
                        <option value="{{$timeSlot['id']}}||{{$timeSlot['timeslots']}}">{{$timeSlot['timeslots']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" type="email" placeholder="example@a.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required />
            </div>
        </div>
    	<div class="col-md-4">
            <div class="form-group">
                <label>Phone_no</label>
                <input class="form-control" name="contat_no" placeholder="+911234567890" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" type="tel" required/>
            </div>
        </div>
    </div>
    <hr>

<?php $trekkerCount =  0; ?>

@if ($_POST['number_of_trekkers'])
    <h4>Enter adults details:</h4>

    @for ($i = 0; $i < $_POST['number_of_trekkers']; $i++)
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>First & Last Name</label>
                    <input class="form-control" name="detail[{{$trekkerCount}}][name]" type="text" required />
                </div>
            </div>
        	<div class="col-md-2">
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control" name="detail[{{$trekkerCount}}][age]" type="number" min="1" required />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Sex</label>
                    <select class="form-control" name="detail[{{$trekkerCount}}][sex]" required >
                    	<option value="M">Male</option>
                    	<option value="F">Female</option>
                    	<option value="O">Other</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="detail[{{$trekkerCount}}][type]" value="adult">
        </div>
        <?php $trekkerCount++ ?>
    @endfor
    <hr>
@endif


@if ($_POST['number_of_children'])
    <h4>Enter children details</h4>

    @for ($i = 0; $i < $_POST['number_of_children']; $i++)
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>First & Last Name</label>
                    <input class="form-control" name="detail[{{$trekkerCount}}][name]" type="text" required />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control" name="detail[{{$trekkerCount}}][age]" type="number" min="1" max="11" required />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Sex</label>
                    <select class="form-control" name="detail[{{$trekkerCount}}][sex]" required >
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        <option value="O">Other</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="detail[{{$trekkerCount}}][type]" value="child">
        </div>
        <?php $trekkerCount++ ?>
    @endfor
    <hr>
@endif



@if ($_POST['number_of_students'])
    <h4>Enter students details</h4>

    @for ($i = 0; $i < $_POST['number_of_students']; $i++)
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>First & Last Name</label>
                    <input class="form-control" name="detail[{{$trekkerCount}}][name]" type="text" required />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control" name="detail[{{$trekkerCount}}][age]" type="number" min="1" required />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Sex</label>
                    <select class="form-control" name="detail[{{$trekkerCount}}][sex]" required >
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        <option value="O">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Id No.</label>
                    <input class="form-control" name="detail[{{$trekkerCount}}][id_no]" type="text" required="">
                </div>
            </div>
            <input type="hidden" name="detail[{{$trekkerCount}}][type]" value="student">


        </div>
        <?php $trekkerCount++ ?>
    @endfor
    <hr>
@endif




    <div class="row">
    	<div class='pull-right'> 
    	     <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Book</button>
    	     <a href="offlineTrailBookNowq" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
      	</div>
    </div>

</form>
@endsection

