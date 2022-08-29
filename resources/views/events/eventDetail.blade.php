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
                        <h2 class="lh1em">@if($eventDetail['event_id'] == 3) Coffee Table Book @else Events @endif</h2>
                        <!-- Error messages -->
                        @if(Session::has('safariErrMessage'))
                          <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('safariErrMessage') }}</p>
                        @endif

                    </div>
                    {{--<div class="col-md-3">
                        <p class="booking-item-header-price"><span class="text-lg">&#8377 {{$trailDetail['pricePerPerson']}}</span>/trekker</p>
                    </div>--}}
                </div>
            </header>
            <div class="row">
                <div class="col-md-7 @if($eventDetail['isActive'] == 2) col-md-offset-2 @endif">
                    <div class="tabbable booking-details-tabbable">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                            </li>
                            @if($eventDetail['event_id'] != 3)
                                <li><a href="#google-map-tab" data-toggle="tab"><i class="fa fa-map-marker"></i>On the Map</a>
                            @endif
                            </li>
                            @if(isset($eventDetail['images']['speakerImage']) && count($eventDetail['images']['speakerImage']))
                            <li><a href="#speakers-tab" data-toggle="tab"><i class="fa fa-user"></i>Speakers</a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-1">
                                <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">

                                    @foreach($eventDetail['images']['eventImage'] as $safariImage)
                                        <img src="{{asset($safariImage['name'])}}" alt="Event images"/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="google-map-tab">
                                <div style="width:100%; height:500px;">
                                    {!! $eventDetail['map_url'] !!}
                                </div>
                            </div>

                            @if(isset($eventDetail['images']['speakerImage']) && count($eventDetail['images']['speakerImage']))
                                <div class="tab-pane fade" id="speakers-tab">
                                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">

                                        @foreach($eventDetail['images']['speakerImage'] as $safariImage)
                                            <img src="{{asset($safariImage['name'])}}" alt="Speakers images"/>
                                        @endforeach
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
                @if($eventDetail['isActive'] == 1)
                <div class="col-md-5">
                    <div class="booking-item-meta">
                        <h2 class="lh1em mt40">{{$eventDetail['name']}}</h2>
                        {{--<p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$eventDetail['range']}}, Karnataka</p>--}}
                        <h4></h4>

                    </div>


                    <div class="booking-item-dates-change">

                        <form action="../../eventCheckAvailability/{{str_replace(' ','-',$eventDetail['name'])}}" method="POST">
                            <input type="hidden" name="event_id" value={{$eventDetail['id']}}>
                            <input type="hidden" name="event_name" value={{str_replace(' ','-',$eventDetail['name'])}}>

                                <div class="row">
                                    <!-- <div class="col-md-8">
                                        We will be back soon !!
                                    </div> -->
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Select booking type</label>
                                            <select name="bookingType" onchange="getTimeslots();" id="bookingType" class="form-control" required>
                                                <option value="">Select booking type</option>
                                                @foreach($bookingTypes as $bookingType)
                                                    @if($bookingType['remaining_slots'] - $bookingType['waitingTicket'])
                                                        <option value="{{$bookingType['id']}}_{{$bookingType['remaining_slots'] - $bookingType['waitingTicket']}}_{{$bookingType['per_head_price']}}">{{$bookingType['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-8" >
                                        <label>@if($eventDetail['event_id'] == 3) Select Quantity @else Select number of tickets @endif</label>
                                        <div class="form-group" id="selectAdult">
                                            <select name="tickets" class="form-control" required>
                                                <option value="">Select Value</option>
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


                </div>
                @endif
            </div>
            <div class="gap"></div>
            <div class="row">

                <div>
                    <h3>About {{$eventDetail['name']}}</h3>
                    {!! $eventDetail['description'] !!}
                </div>
            </div>
            <div class="gap gap-small"></div>

        </div>
    </div>
    <div class="gap gap-small"></div>

   <script type="text/javascript">

        function getTimeslots()
        {
            remaningSlot = $("#bookingType").val();
            if (remaningSlot == ''){
                remaningSlot = '0_0_0';
            }

            var strURL = "../../getRemaningSlotDropdown/"+remaningSlot;
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                req = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
                req = new ActiveXObject("Microsoft.XMLHTTP");
            }
            req.open("GET", strURL, false); //third parameter is set to false here
            req.send(null);
            $("#selectAdult").html(req.responseText);
        }
    </script>
@endsection
