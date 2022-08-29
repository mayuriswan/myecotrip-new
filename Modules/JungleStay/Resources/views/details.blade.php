@extends('layouts.app')
@section('title', 'Jungle Stay Details')
@section('sidebar')
@endsection @section('content')

<!-- Header -->
@include('layouts.header')
<div class="container">
    <ul class="breadcrumb">
        <li><a href="{{url('/')}}">Home</a>
        </li>
        <li><a href="{{url('/jungle-stays')}}">Jungle Stays</a>
        </li>
        <li class="active">{{ucwords($data['name'])}} Jungle Stay
        </li>
    </ul>

    <div class="booking-item-details">
        <header class="booking-item-header">
            <div class="row">
                <div class="col-md-9">
                    <h2 class="lh1em">{{ucwords($data['name'])}} Jungle Stay</h2>
                    <!-- <p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$data['address']}}</p> -->
                    <ul class="list list-inline text-small">
                        <li><i class="fa fa-map-marker"></i>&nbsp;{{ $data['address'] }} </li>
                        @if (count($data['incharger_details']) > 0)
                        <li><i class="fa fa-user"></i>&nbsp;{{ $data['incharger_details'][0] }} </li>
                        @endif @if (count($data['incharger_details']) > 2)
                        <li><i class="fa fa-phone"></i>&nbsp; {{ $data['incharger_details'][2] }} </li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-3">
                    <p class="booking-item-header-price"><small>price from</small> <span class="text-lg">&#8377; {{$data['price_starting_from']}}</span></p>
                </div>
            </div>
        </header>
        {{ Form::open(array('url' => url('/').'/jungle-stays/room-list/'.$data['id'], 'method' => 'POST', 'class' => 'booking-item-dates-change mb30')) }}
        <div class="row input-daterange">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('valMessage'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('valMessage') }}</p>
                    @endif
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i> <label>Check In</label>
                    <input class="form-control showPointer" @if(!Session::has('userId')) disabled @endif name="checkIn" placeholder="YYYY-MM-DD" type="text" autocomplete="off" required/> 
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i> <label>Check Out</label> <input class="form-control showPointer checkOut" id="checkOut" disabled name="checkOut" placeholder="YYYY-MM-DD" type="text" autocomplete="off" required/> </div>
            </div>
            @if(!Session::has('userId'))
                <div class="col-md-2">
            @else
                <div class="col-md-3">
            @endif

                <div class="form-group form-group-icon-left">
                    <label>Nationality</label>
                    <select class="form-control" name="nationality">
                        <option selected value="1">Indian</option>
                        <option value="2">Foreigner</option>
                    </select>
                    <!-- <div class="radio radio-stroke col-md-6"> <label> <input class="i-radio" type="radio" value="1" checked name="nationality" />Indian</label> </div>
                    <div class="radio radio-stroke col-md-6"> <label> <input class="i-radio" type="radio" value="2" name="nationality" />Foreigner</label> </div> -->
                </div>
            </div>
            <div class="col-md-3">
                <label>Number of Adults</label>
                <div class="form-group form-group- form-group-select-plus">
                    <div class="btn-group btn-group-select-num" data-toggle="buttons">

                        <label class="btn btn-primary active">
                            <input type="radio" name="noOfAdults" checked value="1"/>1</label>
                        <label class="btn btn-primary">
                            <input type="radio" name="noOfAdults" value="2"/>2</label>
                        <label class="btn btn-primary">
                            <input type="radio" name="noOfAdults" value="3"/>3</label>
                        <label class="btn btn-primary">
                            <input type="radio" name="noOfAdults" value="4"/>4</label>
                        <label class="btn btn-primary">
                            <input type="radio" name="noOfAdults" value="5"/>5</label>
                        <label class="btn btn-primary">
                            <input type="radio" name="noOfAdults" value="6"/>6</label>

                        <label class="btn btn-primary">
                            <input type="radio" name="noOfAdults" value="6+"/>6+</label>
                    </div>
                    <select name="noOfAdults2" class="form-control hidden">
                        @for ($i = 1; $i < 41; $i++)
                            <option @if($i == 7) selected @endif value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>

            @if(!Session::has('userId'))
                <div class="col-md-3">
                    <label></label>
                        <input class="btn btn-primary mt10" type="button" onclick="openLoginModal()" value="Login Before You Proceed " />
                </div>
            @else
                <div class="col-md-2">
                    <label></label>
                    <div class="form-group form-group-select-plus">
                        <input class="btn btn-primary mt10" type="submit" value="Search for our Stays" />
                    </div>
                </div>
            @endif



        </div>
        {{Form::close()}}
        <div class="row">
            <div class="col-md-6">
                <div class="tabbable booking-details-tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a> </li>
                        <li><a href="#google-map-tab" data-toggle="tab"><i class="fa fa-map-marker"></i>On the Map</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-1">
                            <!-- START LIGHTBOX GALLERY -->
                            <div class="row row-no-gutter" id="popup-gallery">
                                <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs"> @foreach($images as $index => $image) <img src="{{$image['name']}}" alt="Image Alternative text" title="hotel PORTO BAY RIO INTERNACIONAL de luxe" /> @endforeach </div>
                            </div>
                            <!-- END LIGHTBOX GALLERY -->
                        </div>
                        <div class="tab-pane fade" id="google-map-tab">
                            <div style="width:100%; height:500px;"> {!! $data['map_url'] !!} </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="booking-item-meta">
                    <h2 class="lh1em mt40">About Us !</h2>
                    <!-- <h3>97% <small >of guests recommend</small></h3> -->
                    <div class="booking-item-rating"> {!! $data['description'] !!} </div>
                </div>
            </div>
        </div>
        <div class="gap gap-small"></div>
        <h3>Property List</h3>
        <hr>
        <div class="row">
            <div class="col-md-8">
                <ul class="booking-list">
                    <div class="row row-wrap">
                        @foreach($rooms as $key => $room)
                        <div class="col-md-6 booking-item">
                            <div class="thumb">
                                <header class="thumb-header"><img src="{{$room['logo']}}" class="roomListImg" alt="{{ucwords($room['name'])}}" title="{{ucwords($room['name'])}}" /></header>
                                <div class="thumb-caption">
                                    <h5 class="thumb-title row">
                                        <div class="col-md-8" style="padding-left:0px">
                                            <h4>{{ucwords($room['name'])}}</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-darken mb0 text-color text-right">&#8377; {{$room['display_price']}}<small> {{$room['shortDesc']}}</small> </label>
                                        </div>
                                    </h5>
                                    <!-- <small>Premium</small> -->
                                    <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                                        <li rel="tooltip" data-placement="top" title="No. of {{ucwords($room['name'])}}"><i class="fa fa-home"></i><span class="booking-item-feature-sign">x {{$room['no_of_rooms']}}</span>
                                        </li>
                                        <li rel="tooltip" data-placement="top" title="Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x {{$room['max_capacity']}}</span>
                                        </li>

                                        <?php $roomAmenities = json_decode($room['amenities']); ?>
                                        @if(count($roomAmenities))
                                            @foreach($roomAmenities as $index => $amt)
                                                <li rel="tooltip" data-placement="top" title="{{$amenities[$amt]['name']}}"><i class="{{$amenities[$amt]['css_class']}}"></i>
                                                </li>
                                            @endforeach

                                        @endif
                                    </ul>


                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-6"> </div>
                        <div class="col-md-6" id="pagination"> {{$rooms->links()}} </div>
                    </div>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="booking-item-dates-change">
                    <h3>General Instructions</h3>
                    <!-- General Instructions --> {!! $data['general_instructions'] !!}
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<style media="screen"> #pagination ul{ float: right; } </style>
@endsection
