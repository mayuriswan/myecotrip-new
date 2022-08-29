
@extends('layouts.app')

@section('title', 'Visitor details')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="gap"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>Enter Visitor's Details:</h3>
                @if(Session::has('safariErrMessage'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('safariErrMessage') }}</p>
                @endif
                <form action="confirmSafariBooking" method="POST">
                    <?php $slNo= 1; ?>
                    <div class="row" style="color: #e24d2d;">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>SL No</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Vehicle Name </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Available Seats </label>
                            </div>
                        </div>
                    </div>
                    @foreach($displayData['showVehicles'] as $vehiclesList)
                        <input type="hidden" name="vehicleId[]" id="vehicleId{{$vehiclesList['id']}}" value="{{$vehiclesList['id']}}">
                        <input type="hidden" name="vehicleName[{{$vehiclesList['id']}}]" id="vehicleId{{$vehiclesList['id']}}" value="{{$vehiclesList['displayName']}}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>{{$slNo}}</label>
                                <?php $slNo++ ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b>{{$vehiclesList['displayName']}}</b></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                
                                <select name="transportationSeats[]"  id="transportationSeats{{$vehiclesList['id']}}" class="form-control" >
                                    @for ($i = 0; $i <= $vehiclesList['availableSeats']; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
                        <script>
                            $("#transportationSeats{{$vehiclesList['id']}}").change(function()
                            {
                                $('#checkEntry').val(1);
                                transportationSeats = $("#transportationSeats{{$vehiclesList['id']}}").val();
                                vehicleId = $("#vehicleId{{$vehiclesList['id']}}").val();
                                if(transportationSeats > 0) {
                                    $("#userDetails{{$vehiclesList['id']}}").show();
                                    var strURL = "getUserDetailsList/" + transportationSeats +"/"+vehicleId;
                                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                                        req = new XMLHttpRequest();
                                    }
                                    else {// code for IE6, IE5
                                        req = new ActiveXObject("Microsoft.XMLHTTP");
                                    }
                                    req.open("GET", strURL, false); //third parameter is set to false here
                                    req.send(null);
                                    $("#userDetails{{$vehiclesList['id']}}").html(req.responseText);
                                }
                                if(transportationSeats == 0){
                                    $("#userDetails{{$vehiclesList['id']}}").hide();
                                }
                            });
                        </script>

                    <div id="userDetails{{$vehiclesList['id']}}"></div>
                    <input id="checkEntry" type="hidden" value="0">
                    <hr>
                    @endforeach

	                <strong><span style="color: red;">Note :</span> 
                        <p>Please enter only {{$displayData['requestedSeats']}} passanger details</p>
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