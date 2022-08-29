
@extends('layouts.app')

@section('title', 'Confirm booking')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="gap"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Visitor's Details:</h3>
             
                <form action="initiateSafariBooking" method="POST">
                    <input type="hidden" name="detail" value="{{json_encode($postData['detail'])}}">
                    <input type="hidden" name="feeDetails" value="{{json_encode($feeDetails)}}">
                    <table class="table">
                        <tr>
                            <th>SlNo</th>
                            <th>Vehicle</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Foreigner</th>
                        </tr>
                        <?php $slNo = 1; ?>
                        @foreach($postData['detail'] as $vehicleId => $visitorsDetails)
                            @foreach($visitorsDetails as $visitors)
                                <tr>
                                    <td>{{$slNo}}</td>
                                    <td>{{$postData['vehicleName'][$vehicleId]}}</td>
                                    <td>{{$visitors['name']}}</td>
                                    <td>{{$visitors['age']}}</td>
                                    <td>{{$visitors['sex']}}</td>
                                    <td>@if (isset($visitors['visitorType'])) Yes @else NO @endif</td>
                                </tr>
                                <?php $slNo++; ?>
                            @endforeach
                        @endforeach
                    </table>

	                <strong><span style="color: red;">Note :</span> 
                        <p>Please make sure you carry at least one Government Id proof.</p>
                    </strong>
	                <hr>
	                <div class="row">           
	                    <div class="col-md-6">
	                        <input class="btn btn-primary" type="submit" id="submit" value="Proceed Payment" />
	                    </div>
	                </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="booking-item-payment">
                    <header class="clearfix">
                        <a class="booking-item-payment-img" href="#">
                            <img src="{{asset($displayData['safariLogo'])}}" alt="Image Alternative" title="" />
                        </a>
                        <h2 class="booking-item-payment-title"><a href="#">{{$displayData['safariName']}}</a></h2>
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Plan Details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Safari Name</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['safariName']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Check in </p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['travelDate']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Time slot</p>
                                    <p class="booking-item-payment-price-amount"> {{$displayData['timeslotValue']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Number of ticket</p>
                                    <p class="booking-item-payment-price-amount"> {{$displayData['requestedSeats']}}
                                    </p>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h5>Billing details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Safare Fee</p>
                                    <p class="booking-item-payment-price-amount">&#8377 {{$feeDetails['safariFee']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Park Entry Fee</p>
                                    <p class="booking-item-payment-price-amount">&#8377 {{$feeDetails['entryFee']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Service charges</p>
                                    <p class="booking-item-payment-price-amount">&#8377 {{$feeDetails['serviceCharges']}}
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <p class="booking-item-payment-total">Total : <span> &#8377 {{$feeDetails['totalPayable']}}</span>
                    </p>
                </div>
            </div>
        </div>
            <div class="gap"></div>
    </div>
    <script>
        $('#submit').on('click',function () {
            if($('#checkEntry').val() == '0'){
                alert("Please enter details");
                return false;
            }
        });
    </script>
@endsection