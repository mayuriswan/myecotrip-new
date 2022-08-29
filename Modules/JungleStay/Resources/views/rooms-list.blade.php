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
            <li><a href="{{url('/jungle-stays')}}/{{$data['stayDetails']['id']}}/{{$data['stayDetails']['name']}}"> {{$data['stayDetails']['name']}}</a>
            </li>
            <li class="active">Available Rooms</li>
        </ul>
        <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog modal-xl" id="search-dialog">
            <h3>Search for Rooms</h3>
            {{ Form::open(array('url' => url('/').'/jungle-stays/room-list/'.$data['stayDetails']['id'], 'method' => 'POST', 'class' => 'booking-item-dates-change mb30')) }}
            <div class="row input-daterange">
                <div class="col-md-3">
                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i> <label>Check In</label> <input class="form-control showPointer" name="checkIn" placeholder="YYYY-MM-DD" type="text" autocomplete="off" required/> </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i> <label>Check Out</label> <input class="form-control showPointer checkOut" id="checkOut" disabled name="checkOut" placeholder="YYYY-MM-DD" type="text" autocomplete="off" required/> </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group form-group-icon-left">
                        <label>Nationality</label>
                        <select class="form-control" name="nationality">
                            <option selected value="1">Indian</option>
                            <option value="2">Foreigner</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group form-group-icon-left">
                        <label>No. Of Adults</label>
                        <select name="noOfAdults" class="form-control" required>
                            @for ($i = 1; $i < 41; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-select-plus"> <input class="btn btn-primary mt10" type="submit" value="Search for Stays" style="width:100%" /> </div>
                    </div>
                </div>

            </div>
            {{Form::close()}}
        </div>
        <h3 class="booking-title">{{count($rooms)}} Jungle Stays Available for {{$data['stayDetails']['name']}}<small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></small></h3>
        <div class="row">
            {{ Form::open(array('url' => url('/').'/jungle-stays/guest-details/'.$data['stayDetails']['id'], 'method' => 'POST', 'id' => 'jsRoomsForm')) }}

            <div class="col-md-8">
                <!-- <div class="nav-drop booking-sort">
                    <h5 class="booking-sort-title"><a href="#">Sort: Price (low to high)<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                    <ul class="nav-drop-menu">
                        <li><a href="#">Price (high to low)</a>
                        </li>
                        <li><a href="#">Car Name (A-Z)</a>
                        </li>
                        <li><a href="#">Car Name (Z-A)</a>
                        </li>
                        <li><a href="#">Car Type</a>
                        </li>
                    </ul>
                </div> -->

                <ul class="booking-list">
                    @foreach($rooms as $key => $room)
                        <li>
                            <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-img-wrap">
                                            <img src="{{$room['logo']}}" alt="{{$room['name']}}" title="{{$room['name']}}" />
                                            <!-- <div class="booking-item-img-num"><i class="fa fa-picture-o"></i>10</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <h5 class="booking-item-title">{{ucwords($room['name'])}}</h5>
                                        <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                                            <li rel="tooltip" data-placement="top" title="No. of {{ucwords($room['name'])}} Available"><i class="fa fa-home"></i><span class="booking-item-feature-sign">x {{$room['availabeRooms']}}</span>
                                            </li>

                                            <li rel="tooltip" data-placement="top" title="Max No. of Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$room['max_capacity']}}</span>
                                            </li>
                                            <?php $roomAmenities = json_decode($room['amenities']); ?>
                                            @if(count($roomAmenities))
                                                @foreach($roomAmenities as $index => $amt)
                                                    <li rel="tooltip" data-placement="top" title="{{$amenities[$amt]['name']}}"><i class="{{$amenities[$amt]['css_class']}}"></i>
                                                    </li>
                                                @endforeach

                                            @endif

                                        </ul>
                                        <!-- <p class="booking-item-address"><i class="fa fa-map-marker"></i> New York, NY (Downtown - Wall Street)</p><small class="booking-item-last-booked">Latest booking: 57 minutes ago</small> -->
                                    </div>
                                    <div class="col-md-4"><span class="booking-item-price-from">from</span><span class="booking-item-price">&#8377;{{$roomPricing[$room['id']]['price']}}</span><span>{{$room['shortDesc']}}</span>

                                    <div class="input-group">
                                      <input type="button" value="-" class="button-minus btn-danger" data-field="noOfRooms[{{$room['id']}}]" title="Remove room">
                                      <input type="number" step="1" max="{{$room['availabeRooms']}}" value="0" name="noOfRooms[{{$room['id']}}]" class="quantity-field">
                                      <input type="button" value="+" class="button-plus" data-field="noOfRooms[{{$room['id']}}]" title="Add room">
                                    </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
            </div>
            <div class="col-md-4">
                <input type="hidden" id="no_of_rooms" value="0">

                <div class="booking-item-payment">
                    <header class="clearfix">
                        <a class="booking-item-payment-img" href="#">
                            <img src="{{$data['stayDetails']['logo']}}" alt="Stay Image" title="Stay Image" />
                        </a>
                        <h2 class="booking-item-payment-title"><a href="#">{{ucwords($data['stayDetails']['name'])}}</a></h2>
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Booking Details</h5>
                            <ul class="booking-item-payment-price">
                                <li>
                                    <p class="booking-item-payment-price-title">Check In :</p>
                                    <p class="booking-item-payment-price-amount">{{date("l jS M, Y", strtotime($post['checkIn']))}}</p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Check Out :</p>
                                    <p class="booking-item-payment-price-amount">{{date("l jS M, Y", strtotime($post['checkOut']))}}</p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">No. Of Adults :</p>
                                    <p class="booking-item-payment-price-amount">{{$post['noOfAdults']}}</p>
                                </li>

                            </ul>
                        </li>
                    </ul>
                    @if(Session::has('userId') && !$accountVerification)
                        <a href="{{url('/')}}/userProfile">
                            <div class="col-md-12 btn booking-item-dates-change">
                                <b style="color: #e44f28">Please verify your account before you proceed</b>
                            </div>
                        </a>
                    @elseif(Session::has('userId') && $accountVerification)
                        <p class="booking-item-payment-total"><input class="btn btn-primary" type="submit" id="submit" style="width: 100%;" value="Proceed For Guest Details"></span>
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




</script>

<style media="screen">
    input,
    textarea {
        border: 1px solid #eeeeee;
        box-sizing: border-box;
        margin: 0;
        outline: none;
        padding: 10px;
    }

    input[type="button"] {
        -webkit-appearance: button;
        cursor: pointer;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    .input-group {
        clear: both;
        margin: 15px 0;
        position: relative;
    }

    .input-group input[type='button'] {
        /* background-color: #eeeeee; */
        min-width: 38px;
        width: auto;
        transition: all 300ms ease;
    }

    .input-group .button-plus{
        color: #fff;
        background-color: #b3cc36;
        border-color: #b3cc36;
    }

    .input-group .button-minus,{
        color: #fff;
        background-color: #e24820;
        border-color: #e24820;
    }

    .input-group .button-minus,
    .input-group .button-plus {
        font-weight: bold;
        height: 38px;
        padding: 0;
        width: 38px;
        position: relative;
    }

    .input-group .quantity-field {
        position: relative;
        height: 38px;
        left: -6px;
        text-align: center;
        width: 62px;
        display: inline-block;
        font-size: 13px;
        margin: 0 0 5px;
        resize: vertical;
    }

    .button-plus {
        left: -13px;
    }

    input[type="number"] {
        -moz-appearance: textfield;
        -webkit-appearance: none;
    }

</style>
@endsection
