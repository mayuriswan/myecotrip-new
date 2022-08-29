
@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="gap"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Enter Visitors's Details:</h3>
             
                <form action="confirmjungleStayBooking" method="POST">
                	@for ($i = 1; $i <= $displayData['no_of_stays']; $i++)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First & Last Name</label>
                                <input class="form-control" name="detail[{{$i}}][name]" type="text" required />
                            </div>
                        </div>
						<div class="col-md-2">
                            <div class="form-group">
                                <label>Age</label>
                                <input class="form-control" name="detail[{{$i}}][age]" type="number" min="1" required />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sex</label>
                                <select class="form-control" name="detail[{{$i}}][sex]" required >
                                	<option value="M">Male</option>
                                	<option value="F">Female</option>
                                	<option value="O">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Foreigner</label><input type="checkbox" name="detail[{{$i}}][visitorType]" value="1">
                            </div>
                        </div>
                    </div>
                    @endfor
                   

	                <strong><span style="color: red;">Note :</span> Please make sure you carry at least one Government Id proof.</strong>
	                <hr>
	                <div class="row">           
	                    <div class="col-md-6">
	                        <input class="btn btn-primary" type="submit" value="Proceed Payment" />
	                    </div>
	                </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="booking-item-payment">
                    <header class="clearfix">
                        <a class="booking-item-payment-img" href="#">
                            <img src="{{asset($displayData['stayLogo'])}}" alt="Image Alternative" title="Stay Image" />
                        </a>
                        <h2 class="booking-item-payment-title"><a href="#">{{$displayData['stayName']}}</a></h2>
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Booking Details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">No of {{$displayData['stayTypeName']}}</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['no_of_stays']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Check in </p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['travelDate']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Stay Type</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['stayTypeName']}}
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
            <div class="gap"></div>
    </div>

@endsection