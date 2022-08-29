@extends('layouts.app')

@section('title', '')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
        <div class="booking-item-details">
            <header class="booking-item-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="lh1em">Bird Sanctuary</h2>
                        <!-- Error messages -->
                         @if(Session::has('safariErrMessage'))
                          <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('safariErrMessage') }}</p>
                        @endif
                    </div>
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
                                    @foreach($birdSanctuaryDetail['birdSanctuaryImages'] as $birdSanctuaryImage)
                                        <img src="{{asset($birdSanctuaryImage['name'])}}" alt="Image Alternative text"/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="google-map-tab">
                                <div style="width:100%; height:500px;">
                                    {!! $birdSanctuaryDetail['map_url'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="booking-item-meta">
                        <h2 class="lh1em mt40">{{$birdSanctuaryDetail['name']}}</h2>
                        {{--<p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$birdSanctuaryDetail['range']}}, Karnataka</p>--}}
                        <h4>@if(Session::has('userId')) Hey {{ucwords(Session::get('userName'))}},

                            @else
                                Hey Guest,
                            @endif when are you planing ?</h4>

                    </div>

                    @if(Session::has('userId'))
                        <div class="booking-item-dates-change">

                            <form action="{{url('/')}}/entryDetails/{{$birdSanctuaryId}}/{{$birdSanctuaryDetail['name']}}" method="POST">
                                <input type="hidden" name="birdSanctuary_id" id="birdSanctuary_id" value={{$birdSanctuaryId}}>
                                <input type="hidden" name="birdSanctuary_name" id="birdSanctuary_name" value={{$birdSanctuaryDetail['name']}}>
                                <div class="input-daterange" data-date-format="yyyy-mm-dd DD">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-icon-left showPointer"><i class="fa fa-calendar input-icon"></i>
                                                <label>Check in</label>
                                                <input class="form-control showPointer" id="date" name="start" type="text" placeholder="Select date" required autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-top: 16px;">
                                                  <p align="center"><button id="checkAvailability" type="submit" class="btn btn-primary btn-lg">Check Availability</button> </p>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        @if(Session::has('valMessage'))
                                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('valMessage') }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    @else
                        <div class="col-md-12 btn booking-item-dates-change" id="openLoginModal" onclick="openLoginModal()">
                            <b style="color: #e44f28">Please login to book {{$birdSanctuaryDetail['name']}} Bird Sanctuary</b>
                        </div>
                    @endif
                </div>
            </div>
            <div class="gap"></div>
            <div class="row">
                <div>
                    <h3>About {{$birdSanctuaryDetail['name']}}</h3>
                    {!! $birdSanctuaryDetail['description'] !!}
                </div>
            </div>
            <div class="gap gap-small"></div>
        </div>
    </div>
    <div class="gap gap-small"></div>
    <script>
        $("#boatType_id").change(function()
        {
            boatTypeId = $("#boatType_id").val();
            birdSanctuaryId = $("#birdSanctuary_id").val();
            var strURL= "{{url('/')}}"+"/getTimeSlots/"+boatTypeId+"/"+birdSanctuaryId;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                req=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                req=new ActiveXObject("Microsoft.XMLHTTP");
            }

            req.open("GET", strURL, false); //third parameter is set to false here
            req.send(null);
            $("#timeslots").html(req.responseText);
        });
    </script>
@endsection




