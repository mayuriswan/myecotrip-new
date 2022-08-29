
@extends('layouts.app')

@section('title', '')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="gap"></div>

    @if($event->event_id == 3)
        @include('events.book')
    @else
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Enter Details:</h3>

                <form action="../initiateEventBooking" method="POST">
                	@for ($i = 1; $i <= $displayData['tickets']; $i++)
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
                            <img src="{{asset($displayData['eventLogo'])}}" alt="Image Alternative" title="Trail Image" />
                        </a>
                        <h2 class="booking-item-payment-title"><a href="#">{{$displayData['eventName']}}</a></h2>
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Booking Details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">No of tickets</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['tickets']}}
                                    </p>
                                </li>

                                <li>
                                    <p class="booking-item-payment-price-title">Price per ticket</p>
                                    <p class="booking-item-payment-price-amount">&#8377 {{$displayData['selectedBookingPrice']}}
                                    </p>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h5>Billing details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Total price</p>
                                    <p class="booking-item-payment-price-amount">&#8377
                                        {{number_format((float)$displayData['total'], 2, '.', '')}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Service charges</p>
                                    <p class="booking-item-payment-price-amount">&#8377
                                        {{number_format((float)$displayData['serviceCharges'], 2, '.', '')}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">GST charges</p>
                                    <p class="booking-item-payment-price-amount">&#8377
                                    {{number_format((float)$displayData['gstCharges'], 2, '.', '')}}
                                    </p>
                                </li>

                            </ul>
                        </li>
                    </ul>
                    <p class="booking-item-payment-total">Grand Total : <span>&#8377 {{$displayData['totalPayable']}}</span>
                    </p>
                </div>
            </div>
        </div>
            <div class="gap"></div>
    </div>
    @endif
@endsection
