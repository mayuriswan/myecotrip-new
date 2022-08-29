
@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.agent.topNav')

    @include('layouts.Admin.agent.sideNav')
@endsection

@section('content')

<div id="page-wrapper">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Offline Bookings</h1>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   <!-- /.row -->
   <div class="row">
      <div class="col-lg-3 col-md-6">
         <div class="panel panel-primary">
            <div class="panel-heading">
               <div class="row">
                  <!-- <div class="col-xs-3">
                     <i class="fa fa-comments fa-5x"></i>
                     </div> -->
                  <div class="col-xs-12 text-center">
                     <div class="medium"> {{$numberOfTruckers}}</div>
                     <div></div>
                  </div>
               </div>
            </div>
            <a href="#">
               <div class="panel-footer">
                  <span class="pull-left">Booking for today</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
               </div>
            </a>
         </div>
      </div>
      
      <div class="col-lg-3 col-md-6">
         <div class="panel panel-red">
            <div class="panel-heading">
               <div class="row">
                  <!-- <div class="col-xs-3">
                     <i class="fa fa-support fa-5x"></i>
                     </div> -->
                  <div class="col-xs-12 text-center">
                     <div class="medium">{{date("d-m-Y")}}</div>
                     <div id="time"></div>
                  </div>
               </div>
            </div>
            <a href="#">
               <div class="panel-footer">
                  <span class="pull-left" ></span>
                  <!-- <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span> -->
                  <div class="clearfix"></div>
               </div>
            </a>
         </div>
      </div>
   </div>
   @if(Session::has('message'))
   <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
   @endif
   <div class="row">
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-heading">
             Bookings
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
               <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                     <tr>
                        <th>Sl No</th>
                        <th>Booking Id</th>
                        <th>Name</th>
                        <!-- <th>Email</th> -->
                        <th>Phone no</th>
                        <th>Check In</th>
                        <th>Tickets</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody class="tblFont">
                     @if(count($getBooking) > 0)
                     @foreach($getBooking as $index => $booking)
                     <tr class="odd gradeX">
                        <td>{{$index + 1}}</td>
                        <td>{{$booking['display_id']}}</td>
                        <td>{{$booking['name']}}</td>
                        <td>{{$booking['contat_no']}}</td>
                        <td>{{substr($booking['checkIn'],0,10)}}</td>
                        <td>{{$booking['number_of_trekkers']}}</td>
                        <td class="text-center"><a href="{{ url('admin/offlineBookingDetails/') }}/{{$booking['id']}}" title="Edit"><i class="fa fa-eye fa-fw"></i></a></td>
                     </tr>
                     @endforeach                                                          
                     @else
                     <div class="alert alert-warning">
                        <strong>Sorry!</strong> No Product Found.
                     </div>
                     @endif
                  </tbody>
               </table>
               <!-- /.table-responsive -->
            </div>
         </div>
         
      </div>
      <!-- /.col-lg-12 -->
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@endsection

