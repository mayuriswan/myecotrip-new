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
         <h1 class="page-header">Booking details</h1>
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
	         	<input style="float: right" type="button" class="btn btn-info" value="Print" />
	         </div>
   		</div>
   	</div>

	<div class="container-fluid">
		<table class="table">
			<thead>
				<tr>
					<th>Sl.no</th>
					<th>Category</th>
					<th>Type</th>
					<th>Number of ticket * Price</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php $slNo = 0; ?>
				@foreach($displayData['entrance'] as $index => $entryTicket)
					<tr>
						<td>{{++$slNo}}</td>
						<td>Entrance</td>
						<td>{{$entryTicket['name']}}</td>
						<td>{{$entryTicket['numbers']}} * {{$entryTicket['price']}}</td>
						<td>{{$entryTicket['numbers'] * $entryTicket['price']}}</td>
					</tr>
				@endforeach

				@if($bookingData['no_of_camera_ticket'])
					@foreach($displayData['camera'] as $index => $entryTicket)
						<tr>
							<td>{{++$slNo}}</td>
							<td>Camera</td>
							<td>{{$entryTicket['name']}}</td>
							<td>{{$entryTicket['numbers']}} * {{$entryTicket['price']}}</td>
							<td>{{$entryTicket['numbers'] * $entryTicket['price']}}</td>
						</tr>
					@endforeach
				@endif

				@if($bookingData['no_of_boating_ticket'])
					@foreach($displayData['boating'] as $index => $entryTicket)
						<tr>
							<td>{{++$slNo}}</td>
							<td>Boating</td>
							<td>{{$entryTicket['name']}}</td>
							<td>{{$entryTicket['numbers']}} * {{$entryTicket['price']}}</td>
							<td>{{$entryTicket['numbers'] * $entryTicket['price']}}</td>
						</tr>
					@endforeach
				@endif

				@if($bookingData['no_of_parking_ticket'])
					@foreach($displayData['parking'] as $index => $entryTicket)
						<tr>
							<td>{{++$slNo}}</td>
							<td>Parking</td>
							<td>{{$entryTicket['name']}}</td>
							<td>{{$entryTicket['numbers']}} * {{$entryTicket['price']}}</td>
							<td>{{$entryTicket['numbers'] * $entryTicket['price']}}</td>
						</tr>
					@endforeach
				@endif


			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td><label>Grand Total</label></td>
					<td><label>{{$bookingData['amount_with_tax']}}</label></td>
				</tr>
			</tfoot>
		</table>
	</div>

@endsection

