@extends('layouts.app')

@section('title', 'Trail Details')
@section('sidebar')
@endsection
@section('content')
    <!-- Header -->
    @include('layouts.header')

    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a>
            </li>
            <li><a href="{{url('/jungle-stays')}}">Jungle Stays</a>
            </li>
            <li><a href="{{url('/jungle-stays')}}/{{Session::get('js-booking-info')['stayDetails']['id']}}/{{Session::get('js-booking-info')['stayDetails']['name']}}"> {{Session::get('js-booking-info')['stayDetails']['name']}} Jungle Stay</a>
            </li>
            <li class="active">Guest Details</li>
        </ul>
        <div class="row">
            {{ Form::open(array('url' => url('/').'/jungle-stays/initiateBooking/'.Session::get('js-booking-info')['stayDetails']['id'], 'method' => 'POST', 'id' => 'jsFormGuests')) }}

            <div class="col-md-8">
                <h3 class="booking-title">Guest details for {{Session::get('js-booking-info')['stayDetails']['name']}}</h3>

                @if (count($rooms) > 0)
                    @foreach($rooms as $key => $room)
                        <?php
                            $maxGuest =  Session::get('js-booking-info')['roomCounts'][$room['id']] * $room['max_capacity'];
                        ?>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <h4 style="color:#e4461f">{{ucwords($room['name'])}}</h4>
                            </div>
                            <div class="col-md-8 text-right">
                                <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                                    <li rel="tooltip" data-placement="top" title="No. of {{ucwords($room['name'])}} selected"><i class="fa fa-home"></i><span class="booking-item-feature-sign">x {{Session::get('js-booking-info')['roomCounts'][$room['id']]}}</span>
                                    </li>
                                    <li rel="tooltip" data-placement="top" title="Max No. of Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$maxGuest}}</span>
                                    </li>
                                    <?php $roomAmenities = json_decode($room['amenities']); ?>
                                    @if(count($roomAmenities))
                                        @foreach($roomAmenities as $index => $amt)
                                            <li rel="tooltip" data-placement="top" title="{{$amenities[$amt]['name']}}"><i class="{{$amenities[$amt]['css_class']}}"></i>
                                            </li>
                                        @endforeach

                                    @endif

                                    <span class="booking-item-price">&#8377; {{$roomPricing[$room['id']]['price']}}</span><span>{{$room['shortDesc']}}</span>
                                </ul>
                            </div>
                        </div>

                        <input type="hidden" id="maxRoomCount{{$room['id']}}" value="{{$maxGuest}}">
                        <input type="hidden" id="index{{$room['id']}}" value="1">
                        <input type="hidden" id="currentGuestCount{{$room['id']}}" value="1">

                        <input type="hidden" id="maxAdults" value="{{Session::get('js-booking-info')['post']['noOfAdults']}}">
                        <input type="hidden" id="AdultsShown" value="{{count($rooms)}}">

                        <div id="guestList{{$room['id']}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First & Last Name</label>
                                        <input class="form-control" name="detail[{{$room['id']}}][1][name]" type="text" required />
                                    </div>
                                </div>
                                <input type="hidden" name="detail[{{$room['id']}}][1][type]" value="adult">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input class="form-control" name="detail[{{$room['id']}}][1][age]" type="number" min="1" step="1" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control" name="detail[{{$room['id']}}][1][sex]" required >
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                            <option value="O">Transgender</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Add Guests</label>

                                    <button type="button" class="btn btn-success" onclick="addGuest({{$room['id']}})">Add Guest</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($parkingList)
                        <h3 class="booking-title">Parking Details</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Vehicle</b></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><b>Price / Night</b></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><b>Count</b></label>
                                </div>
                            </div>
                        </div>
                        @foreach($parkingList  as $key => $vehicle)
                            <input type="hidden" name="parking[{{$key}}][pricing_id]" value="{{$vehicle['id']}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{$vehicle['type']}}</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="hidden" id="prakPrice{{$key}}" value="{{$vehicle['price']}}">
                                        <label>{{$vehicle['price']}} / Vehicle</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control" name="parking[{{$key}}][count]" id="parking{{$key}}" type="number" min="0" step="1" max="100" onkeyup="calAmount()"/>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endif

            </div>
            <div class="col-md-4">
                <input type="hidden" id="no_of_rooms" value="0">

                <div class="booking-item-payment">
                    <header class="clearfix">
                        <a class="booking-item-payment-img" href="#">
                            <img src="{{Session::get('js-booking-info')['stayDetails']['logo']}}" alt="Stay Image" title="Stay Image" />
                        </a>
                        <h2 class="booking-item-payment-title"><a href="#">{{ucwords(Session::get('js-booking-info')['stayDetails']['name'])}}</a></h2>
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Booking Details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Check In :</p>
                                    <p class="booking-item-payment-price-amount">{{date("D jS M, Y", strtotime(Session::get('js-booking-info')['post']['checkIn']))}}</p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Check Out :</p>
                                    <p class="booking-item-payment-price-amount">{{date("D jS M, Y", strtotime(Session::get('js-booking-info')['post']['checkOut']))}}</p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">No. Of Adults :</p>
                                    <p class="booking-item-payment-price-amount">{{Session::get('js-booking-info')['post']['noOfAdults']}}</p>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h5>Room Details</h5>
                            <ul class="booking-item-payment-price">
                                @foreach($rooms as $key => $room)
                                    <li>
                                        <p class="booking-item-payment-price-title">{{$room['name']}} : </p>
                                        <p class="booking-item-payment-price-amount" id="noOfRooms">{{Session::get('js-booking-info')['roomCounts'][$room['id']]}}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li>
                            <h5>Billing Details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Park Entry Fee : </p>
                                    <p class="booking-item-payment-price-amount" id="parkEntryFee">{{Session::get('js-booking-info')['post']['noOfAdults']}} * {{$data['entryFee']['price']}} = &#8377; {{count($rooms) * $data['entryFee']['price']}}</p>
                                </li>

                                <li>
                                    <p class="booking-item-payment-price-title">Jungle Stay Fee + GST: </p>
                                    <p class="booking-item-payment-price-amount">&#8377; {{$data['stayAmout'] + $data['stayAmoutGst']}}</p>
                                </li>

                                <li>
                                    <p class="booking-item-payment-price-title">Parking Fee + GST : </p>
                                    <p class="booking-item-payment-price-amount">&#8377; <span id="parkingFeeGst">0</span></p>
                                </li>

                                <li>
                                    <p class="booking-item-payment-price-title">Service Charges + GST : </p>
                                    <p class="booking-item-payment-price-amount">&#8377; <span id="serviceCharge">{{$data['serviceCharge']}}</span></p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <input type="hidden" id="totalGuests" name="totalGuests" value="{{count($rooms)}}">

                    <input type="hidden" name="totalStayFee" id="totalStayFee"  value="{{$data['totalStayFee']}}">
                    <input type="hidden" name="totalDays" id="totalDays"  value="{{$noOfDays}}">
                    <input type="hidden" name="totalEntryFee" id="totalEntryFee"  value="{{$data['totalEntryFee']}}">
                    <input type="hidden" name="totalParkingFee" id="totalParkingFee"  value="0">
                    <input type="hidden" name="totalServiceFee" id="totalServiceFee"  value="{{$data['serviceCharge']}}">
                    <input type="hidden" name="totalPayable" id="totalPayable"  value="{{$data['totalStayFee'] + $data['totalEntryFee'] + $data['serviceCharge']}}">

                    @if(Session::has('userId'))

                        <p class="booking-item-payment-total"><input class="btn btn-primary" type="submit" id="submit" style="width: 100%;" value="Pay  Rs.{{$data['totalStayFee'] + $data['totalEntryFee'] + $data['serviceCharge']}}"></span>
                    @else
                        <div class="col-md-12 btn booking-item-dates-change" id="openLoginModal" onclick="openLoginModal()">
                            <b style="color: #e44f28">Please Login Before You Proceed</b>
                        </div>
                    @endif
                </div>
            </div>

            {{ Form::close() }}
        </div>
        <div class="gap"></div>
    </div>

<script type="text/javascript">
    function addGuest(roomId) {
        var currentGuestCount = $('#currentGuestCount' + roomId).val();
        var divIndex = $('#index' + roomId).val();
        var maxCount = $('#maxRoomCount' + roomId).val();

        // console.log(currentGuestCount +' '+ maxCount)
        if (parseInt(currentGuestCount) >= parseInt(maxCount)) {
            alert('Sorry, Maximum Adult Occupancy for this room is '+ maxCount);
            return false;
        }

        var maxAdults = $('#maxAdults').val();
        var AdultsShown = $('#AdultsShown').val();

        if (parseInt(AdultsShown) + 1 > parseInt(maxAdults)) {
            alert("Sorry, Couldn't not add. Your search was for "+ maxAdults + ' Adults');
            return false;
        }

        updatedIndex = parseInt(divIndex)+1;
        $('#index' + roomId).val(updatedIndex);

        updatedGuestCount = parseInt(currentGuestCount)+1;
        $('#currentGuestCount' + roomId).val(updatedGuestCount);

        $('#totalGuests').val(parseInt($('#totalGuests').val())+1);
        $('#AdultsShown').val(parseInt($('#AdultsShown').val())+1);

        //Entry Fee
        var totalGuests = $('#totalGuests').val();
        var entryPerPerson = {{$data['entryFee']['price']}}
        var totalEntryFee =  totalGuests * entryPerPerson;
        $('#totalEntryFee').val(totalEntryFee);
        $('#parkEntryFee').html(totalGuests +' * '+ entryPerPerson +' = &#8377; '+ totalEntryFee)

        serviceChargeCal();

        // var response;
        $.ajax({ type: "GET",
             url: "{{URL::to('jungle-stays/add-guest/')}}/1/" + updatedIndex +'/'+roomId,
             async: false,
             success : function(text)
             {
                 response= text;
             }
        });
        $("#guestList"+ roomId).append('<div>'+response+'</div>');

    }

    function serviceChargeCal() {
        //Total totalPayable
        var totalPayable = parseInt($('#totalStayFee').val()) + parseInt($('#totalEntryFee').val()) + parseInt($('#totalParkingFee').val())

        //Cal Service Charge
        var  internetHandlingCharge = {{config('junglestay.internetHandlingCharge')}};
        var  paymentGatewayCharge = {{config('junglestay.paymentGatewayCharge')}};
        var  gstCharge = {{config('junglestay.gstCharge')}};


        var IHC = (internetHandlingCharge / 100 ) * totalPayable;
        var GST = (gstCharge / 100 ) * IHC;
        var PG = (paymentGatewayCharge / 100 ) * (totalPayable + IHC + GST);
        var totalServiceCharge  = Math.round((IHC + GST + PG) * 100) / 100;

        var grandTotal = Math.round((totalPayable + totalServiceCharge)* 100) / 100;

        $('#totalServiceFee').val(totalServiceCharge);
        $('#serviceCharge').html(totalServiceCharge);

        $('#submit').val('Pay Rs.' + grandTotal)
        $('#totalPayable').val(grandTotal);

        return true;
    }

    function deleteDiv(divId, roomId) {
        var divIndex = $('#currentGuestCount' + roomId).val();

        updatedIndex = parseInt(divIndex)-1;
        $('#currentGuestCount' + roomId).val(updatedIndex);

        $('#totalGuests').val(parseInt($('#totalGuests').val())-1);
        $('#AdultsShown').val(parseInt($('#AdultsShown').val())-1);


        //Entry Fee
        var totalGuests = $('#totalGuests').val();
        var entryPerPerson = {{$data['entryFee']['price']}}
        var totalEntryFee =  totalGuests * entryPerPerson;
        $('#totalEntryFee').val(totalEntryFee);
        $('#parkEntryFee').html(totalGuests +' * '+ entryPerPerson +' = &#8377; '+ totalEntryFee)

        //Total totalPayable
        serviceChargeCal();

    	$('#'+divId).remove();
    }

    function calAmount() {
        var parkingTypes = {{count($parkingList)}};
        var parkingGstPer = {{config('junglestay.js-gst-parking')}}
        var parkingAmount = 0;
        var totalDays = $('#totalDays').val();

        for (var i = 0; i < parkingTypes; i++) {
            if(parseInt($('#parking'+ i).val())){
                parkingAmount += parseInt($('#parking'+ i).val()) * parseInt($('#prakPrice'+ i).val()) * totalDays;
            }
        }

        parkingAmount = parkingAmount + (parkingGstPer / 100) * parkingAmount;

        $('#totalParkingFee').val(parkingAmount);
        $('#parkingFeeGst').html(parkingAmount);

        //Total totalPayable
        serviceChargeCal();

    }


</script>
@endsection
