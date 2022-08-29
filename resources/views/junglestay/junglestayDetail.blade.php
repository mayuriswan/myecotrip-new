
@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

     <div class="container">
         <br>
        <div class="">
            <header class="booking-item-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="lh1em">JungleStay</h2>
                        
                        <ul class="list list-inline text-small">
                            @if (count($stayDetail['contactinfo']) > 0)
                                <li><i class="fa fa-user"></i>&nbsp;{{ $stayDetail['contactinfo'] }}
                            </li>
                            @endif
                        </ul>
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
                                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" style="width:100%; height:500px;">
                                        @foreach($stayDetail['stayImages'] as $trekImage)
                                            <img src="{{asset($trekImage['name'])}}" alt="Image Alternative text"/>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="google-map-tab">
                                    <div style="width:100%; height:500px;">
                                    {!! $stayDetail['map_url'] !!}
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="booking-item-meta">
                        <h2 class="lh1em mt40">{{$stayDetail['name']}}</h2>
                    <div @if ($stayDetail['isActive'] != 0)>
                        <p class="lh1em text-small"><i class="fa fa-map-marker"></i> {{$landscapeDetails['name']}}, Karnataka</p>
                        <h4>@if(Session::has('userId')) Hey {{ucwords(Session::get('userName'))}},
                        @else
                            Hey Guest,
                            @endif when do you plan to Hike?</h4>
                    </div>
                        <div class="booking-item-dates-change">
                            <form action="/junglestaycheckAvailability/{{$stayId}}/{{$stayDetail['name']}}" method="POST">
                                <div class="input-daterange" data-date-format="yyyy-mm-dd DD">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-icon-left showPointer"><i class="fa fa-calendar input-icon"></i>
                                                <label>Check in</label>
                                                <input class="form-control showPointer" name="start" type="text" placeholder="Select Date" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Stay Type</label>
                                            <div class="form-group form-group- form-group-select-plus">
                                                <select name="type" class="form-control" required>
                                                    <option value="">Select Type</option>
                                                    @foreach($stayTypes as $types)
                                                        <option value="{{$types['id']}}">{{$types['type']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>
                                                <strong style="color: orangered">"Please check the details for the stay types below."</strong>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="number" min="1" name="no_of_stays" placeholder="Enter no. of stays" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                    	@if(Session::has('valMessage'))
    										<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('valMessage') }}</p>
    									@endif
                                    </div>
                                </div>
                                <p align="center">
                                    <button type="submit" class="btn btn-primary btn-lg">Check Availability</button>
                                </p>
                    	</form>
                    </div>
                    @endif
                        <br>
                    <div class="booking-item-meta">
                        <h4>Stay Info</h4>
                    </div>
                    <div class="booking-item-dates-change">
                        <div class="row">                      
                            <div class="col-md-7 col-sm-7">
                                Tent :: 3 members per tent
                            </div>
                            <div class="col-md-5 col-sm-5">
                                Cost :: 1000 per/tent
                            </div>
                        </div>

                        <div class="row">                      
                            <div class="col-md-7 col-sm-7">
                                Dormitry(Beds)
                            </div>
                            <div class="col-md-5 col-sm-5">
                                Cost :: 300 per/bed
                            </div>
                        </div>

                        <div class="row">                      
                            <div class="col-md-7 col-sm-7">
                                Cottage :: 4 members per cottage
                            </div>
                            <div class="col-md-5 col-sm-5">
                                Cost :: 1500 per/cottage
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            <div class="row">
                <div>
                    <h3>About {{$stayDetail['name']}}</h3>
                    {!! $stayDetail['description'] !!}
                </div>
            </div>
            <div class="gap gap-small"></div>
        </div>
        <div class="gap gap-small"></div>
    </div>
@endsection