@extends('layouts.app')

@section('title', '')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
        <!-- <ul class="breadcrumb">
            <li><a href="index.html">Home</a>
            </li>
            <li><a href="#">United States</a>
            </li>
            <li><a href="#">New York (NY)</a>
            </li>
            <li><a href="#">New York City</a>
            </li>
            <li><a href="#">New York City Hotels</a>
            </li>
            <li class="active">Duplex Greenwich</li>
        </ul> -->
        <div class="booking-item-details">
            <header class="booking-item-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="lh1em">Safaries</h2>
                        <!-- Error messages -->
                        @if(Session::has('safariErrMessage'))
                          <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('safariErrMessage') }}</p>
                        @endif

                        {{--<ul class="list list-inline text-small">
                            @if (count($trailDetail['incharger_details']) > 0) 
                                <li><i class="fa fa-user"></i>&nbsp;{{ $trailDetail['incharger_details'][0] }}
                            </li>
                            @endif
                            @if (count($trailDetail['incharger_details']) > 2)
                            <li><i class="fa fa-phone"></i>&nbsp; {{ $trailDetail['incharger_details'][2] }} </li>
                            @endif
                        </ul>--}}
                    </div>
                    {{--<div class="col-md-3">
                        <p class="booking-item-header-price"><span class="text-lg">&#8377 {{$trailDetail['pricePerPerson']}}</span>/trekker</p>
                    </div>--}}
                </div>
            </header>
            <div class="row">
                <div class="col-md-7">
                    <div class="tabbable booking-details-tabbable">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                            </li>
                            <li><a href="#google-map-tab" data-toggle="tab"><i class="fa fa-map-marker"></i>On the Map</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-1">
                                <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">

                                    @foreach($safariDetail['safariImages'] as $safariImage)
                                        <img src="{{asset($safariImage['name'])}}" alt="Image Alternative text" title="hotel PORTO BAY RIO INTERNACIONAL de luxe"/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="google-map-tab">
                                <div style="width:100%; height:500px;">
                                    {!! $safariDetail['map_url'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="booking-item-meta">
                        <h2 class="lh1em mt40">{{$safariDetail['name']}}</h2>
                        {{--<p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$safariDetail['range']}}, Karnataka</p>--}}
                        <h4>@if(Session::has('userId')) Hey {{ucwords(Session::get('userName'))}},

                            @else
                                Hey Guest,
                            @endif when are you planing ?</h4>

                    </div>
                    <div class="booking-item-dates-change">
                        We will be back soon !!
                    </div>
                    <div class="booking-item-dates-change" style="display: none;">

                        <form action="../../safariCheckAvailability/{{$safariId}}/{{$safariDetail['name']}}" method="POST">
                            {{--<input type="hidden" name="amount" value="{{$trailDetail['pricePerPerson']}}">--}}
                            <input type="hidden" name="amount" value="400">
                            <input type="hidden" name="safari_id" id="safari_id" value={{$safariId}}>
                            <input type="hidden" name="safari_name" id="safari_name" value={{$safariDetail['name']}}>
                            <div class="input-daterange" data-date-format="yyyy-mm-dd DD">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-icon-left showPointer"><i class="fa fa-calendar input-icon"></i>
                                            <label>Check in</label>
                                            <input class="form-control showPointer" name="startSafari" type="text" placeholder="Select date" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group- form-group-select-plus">
                                            <label>Adults</label>
                                            <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                                <label class="btn btn-primary active">
                                                    <input type="radio" name="noOfSeats" value="1" checked />1</label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="noOfSeats" value="2"/>2</label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="noOfSeats" value="3"/>3</label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="noOfSeats" value="4"/>4</label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="noOfSeats" value="4+"/>4+</label>
                                            </div>
                                            <select name="noOfSeats2" class="form-control hidden">
                                                @for ($i = 1; $i <= 20; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <select name="transportation" onchange="getTimeslots();" id="transportation" class="form-control" required>
                                            <option value="">Select Transportation</option>
                                            @foreach($safariTransportation as $transportationId => $value)
                                                <option value="{{$transportationId}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" >
                                        <div class="form-group" id="timeslots">
                                        <select name="timeslots" class="form-control">
                                                <option value="">Select TimeSlot</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(Session::has('valMessage'))
                                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('valMessage') }}</p>
                                    @endif
                                </div>
                            </div>



                    <div class="gap gap-small"></div>	<button id="checkAvailability" type="submit" class="btn btn-primary btn-lg">Check Availability</button>
                    </form>
                    </div>
                    <br>
                    <br>
                    {{--<div class="booking-item-meta">
                        <h4>Safari Info</h4>
                    </div>
                    <div class="booking-item-dates-change">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Starting point
                            </div>
                            <div class="col-md-6 col-sm-6">
                                --}}{{--{{$safariDetail['starting_point']}}--}}{{--
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Ends point
                            </div>
                            <div class="col-md-6 col-sm-6">
                                --}}{{--{{$safariDetail['ending_point']}}--}}{{--
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Treakking distance
                            </div>
                            <div class="col-md-6 col-sm-6">
                                --}}{{--{{$safariDetail['distance']}}--}}{{--
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Reporting time
                            </div>
                            <div class="col-md-6 col-sm-6">
                                06:00 AM to 09:30 AM
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Treakking duration
                            </div>
                            <div class="col-md-6 col-sm-6">
                                --}}{{--{{$safariDetail['hours']}} Hrs {{$trailDetail['minutes']}} Mins--}}{{--
                            </div>
                        </div>
                    </div>--}}

                </div>
            </div>
            <div class="gap"></div>
            <div class="row">

                <div>
                    <h3>About {{$safariDetail['name']}}</h3>
                    {!! $safariDetail['description'] !!}
                </div>
            </div>
            <div class="gap gap-small"></div>

        </div>
    </div>
    <div class="gap gap-small"></div>

   <script type="text/javascript">

        function getTimeslots()
        {
            transportationId = $("#transportation").val();
            safariId = $("#safari_id").val();
            if(transportationId > 0 && safariId > 0) {
                var strURL = "../../getSafariTimeSlots/"+safariId+"/"+transportationId;
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    req = new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    req = new ActiveXObject("Microsoft.XMLHTTP");
                }
                req.open("GET", strURL, false); //third parameter is set to false here
                req.send(null);
                $("#timeslots").html(req.responseText);
            }
        }
    </script>
@endsection




