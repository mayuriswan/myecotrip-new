
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

                <form action="initiateBooking" method="POST">
                    <?php $count = 0; ?>

                    @if ($displayData['requestedSeats'] > 0)
                        <h4>Enter adults details:</h4>

                    	@for ($i = 1; $i <= $displayData['requestedSeats']; $i++)
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First & Last Name</label>
                                    <input class="form-control" name="detail[{{$count}}][name]" type="text" required />
                                </div>
                            </div>
                            <input type="hidden" name="detail[{{$count}}][type]" value="adult">
    						<div class="col-md-2">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input class="form-control" name="detail[{{$count}}][age]" type="number" min="12" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sex</label>
                                    <select class="form-control" name="detail[{{$count}}][sex]" required >
                                    	<option value="M">Male</option>
                                    	<option value="F">Female</option>
                                    	<option value="O">Transgender</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php $count++ ?>
                        @endfor
                    @endif

                    @if ($displayData['requestedChildrenSeats'] > 0)
                    <h4>Enter children details</h4>
                        @for ($i = 1; $i <= $displayData['requestedChildrenSeats']; $i++)
                            <input type="hidden" name="detail[{{$count}}][type]" value="child">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First & Last Name</label>
                                        <input class="form-control" name="detail[{{$count}}][name]" type="text" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <select class="form-control" name="detail[{{$count}}][age]" required>
                                            @for($j = 1; $j < 12; $j++)
                                                    <option value="{{$j}}">{{$j}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control" name="detail[{{$count}}][sex]" required >
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                            <option value="O">Transgender</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php $count++ ?>
                        @endfor
                    @endif

                    @if ($displayData['requestedStudentSeats'] > 0)
                    <h4>Enter students details</h4>
                        @for ($i = 1; $i <= $displayData['requestedStudentSeats']; $i++)
                            <input type="hidden" name="detail[{{$count}}][type]" value="student">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First & Last Name</label>
                                        <input class="form-control" name="detail[{{$count}}][name]" type="text" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input class="form-control" name="detail[{{$count}}][age]" type="number" min="1" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control" name="detail[{{$count}}][sex]" required >
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                            <option value="O">Transgender</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Id No.</label>
                                        <input class="form-control" name="detail[{{$count}}][id_no]" type="text" required />
                                    </div>
                                </div>
                            </div>
                            <?php $count++ ?>
                        @endfor
                    @endif

	                <strong><span style="color: red;">Note :</span>
                        <p>Please make sure you carry at least one Government Id proof.</p>
                        @if ($displayData['requestedStudentSeats'] > 0)
                        <p>Please make sure you carry Student Identity Card.</p>
                        @endif
                        
                        <ol>
                            <li>Face mask and hand gloves are compulsory </li>
                            <li>The trekkers should maintain a minimum of 6 feet distance between each other</li>
                            <li>The trekkers are not supposed to spit or gargle on the course of trekking</li>
                            <li>The trekkers are strictly not allowed to share their water bottles or other such items with anyone</li>
                            <li>A batch will be allowed with limited trekkers to maintain social distancing</li>
                            <li>If the trekker feels ill (showing the relatable symptoms like cold, cough, fever etc) during the trek or before, we request the trekker to abort the trek for that particular day</li>
                            <li>If the trekker has a travel history from a red zone, then the trekker should compulsorily get the tests done and then proceed with the booking.</li>
                            <li>The trekkers must carry a hand sanitizer and use it every 30 minutes for their own hygiene and safety (provided if the trekker doesn't have gloves)</li>
                            <li>We suggest the trekkers to engage less with fellow trekkers or other people on the course.</li>
                        </ol>

                    </strong>
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
                            <img src="{{asset($displayData['trailLogo'])}}" alt="Image Alternative" title="Trail Image" />
                        </a>
                        <h2 class="booking-item-payment-title"><a href="#">{{$displayData['trailName']}}</a></h2>
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Booking Details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Check in </p>
                                    <p class="booking-item-payment-price-amount">{{date("D jS M, Y", strtotime($displayData['travelDate']))}}
                                    </p>
                                </li>

                                @if ($displayData['requestedSeats'] > 0)
                                <li>
                                    <p class="booking-item-payment-price-title">Adults</p>
                                    <p class="booking-item-payment-price-amount">&#8377; {{$displayData['perHead']}} * {{$displayData['requestedSeats']}}
                                    </p>
                                </li>
                                @endif

                                @if ($displayData['requestedChildrenSeats'] > 0)
                                    <li>
                                        <p class="booking-item-payment-price-title">Children</p>
                                        <p class="booking-item-payment-price-amount">&#8377; {{$displayData['perChild']}} * {{$displayData['requestedChildrenSeats']}}
                                        </p>
                                    </li>
                                @endif

                                @if ($displayData['requestedStudentSeats'] > 0)
                                    <li>
                                        <p class="booking-item-payment-price-title">Student</p>
                                        <p class="booking-item-payment-price-amount">&#8377; {{$displayData['perStudent']}} * {{$displayData['requestedStudentSeats']}}
                                        </p>
                                    </li>
                                @endif

                            </ul>
                        </li>
                        <li>
                            <h5>Billing details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Total price</p>
                                    <p class="booking-item-payment-price-amount">&#8377; {{$displayData['total']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Service charges</p>
                                    <p class="booking-item-payment-price-amount">&#8377; {{$displayData['serviceCharges']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">GST</p>
                                    <p class="booking-item-payment-price-amount">&#8377; {{$displayData['gstCharges']}}
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <p class="booking-item-payment-total">Total trip: <span>&#8377; {{$displayData['totalPayable']}}</span>
                    </p>
                </div>
            </div>
        </div>
            <div class="gap"></div>
    </div>

@endsection
