
@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="gap"></div>

    <div class="container">
        

        <!-- <form action="{{url('/')}}/confirmBirdSanctuaryBooking" method="POST" id="visitorDetails" onclick="submitAddOnDetails();"> -->
        <!-- <button id="btn1">Append text</button>
        <input type="hidden" name="entranceCount" value="1">

        <div id="entranceDiv">
            <div id="entranceType_id_1">
                <div class="col-md-8 form-group">
                   <div class="col-sm-5">
                      <select class="form-control" name="entranceType_1">
                        @foreach($entryPricing as $entranceType)
                            <option value="{{$entranceType['id']}}">{{$entranceType['name']}}  : &#8377;{{$entranceType['price']}}/ Person</option>
                        @endforeach
                        <option></option>
                      </select>
                   </div>
                </div>

                <div class="row col-md-3" >
                    <div class="form-group col-md-8">
                        <input class="form-control numberTextbox" name="entranceType_value_1" type="number" min="0" value="0" required />
                    </div>
                </div>

                <div class="col-md-1">
                    <a onclick="closeDiv('entranceType_id_1')">Close</a>
                </div>
            </div>
        </div>

        <div id="divToAdd">
            <p>Vinay</p>
        </div> -->

        <form method="POST" action="{{url('/')}}/confirmBirdSanctuaryBooking" id="myForm">

        <div class="row">
            <div class="col-md-8">
                <ul class="booking-list" style="cursor: unset;">
                    <li class="booking-item">
                        <h3>Entry ticket:</h3>
                        <hr>
                        <div class="row" id="entryAlert" style="display: none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="color:red" id="alertMessage">Please enter atleast one Entry ticket.</label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="numberOfEntranceType" value="{{count($entryPricing)}}">
                        @foreach($entryPricing as $index => $entranceType)
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="priceMasterLabel">{{$entranceType['name']}}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group col-md-8">
                                        <input class="form-control numberTextbox" id="entry_{{$index}}" name="entry[{{$entranceType['id']}}]" type="number" min="0" value="0" required />
                                        &#8377; {{$entranceType['price']}} / Person
                                    </div>
                                </div>
                                                       
                            </div>
                        @endforeach

                        
                    </li>
                </ul>    
            </div>

            

            <div class="col-md-4">
                <div class="booking-item-payment">
                    <header class="clearfix">
                        <a class="booking-item-payment-img" href="#">
                            <img src="{{asset($displayData['birdSanctuaryLogo'])}}" alt="Image Alternative" title="BirdSanctuary Image" />
                        </a>
                        <h2 class="booking-item-payment-title"><a href="#">{{$displayData['birdSanctuaryName']}}</a></h2>
                    </header>
                    <ul class="booking-item-payment-details">
                        <li>
                            <h5>Plan Details</h5>
                            <ul class="booking-item-payment-price">
                                
                                <li>
                                    <p class="booking-item-payment-price-title">Bird Sanctuary</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['birdSanctuaryName']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">Check in </p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['travelDate']}}
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <header class="clearfix">
                        <input style="float: right" type="button" class="btn btn-primary" onclick="validateRequest()" value="Continue Booking" />
                    </header>

                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12" style="text-align: center;">
                <hr>

                    <h3>Add On's:</h3>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    @if($hasBoating)
                        <h4 style="text-align: center;">Boating ticket:</h4>

                        <ul class="booking-list" style="cursor: unset;">
                        @foreach($boatings as $type => $boating)
                            <li class="booking-item">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><h5>Category : {{$type}}</h5></label>
                                        </div>
                                    </div>
                                </div>

                                @foreach($boating as $index => $botingType)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{$botingType['name']}}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group col-md-8">
                                                <input class="form-control numberTextbox" id="entry7" name="entry[teacherPrice]" type="number" min="0" value="0" required />
                                                &#8377; {{$botingType['price']}} {{$botingType['shortDesc']}}
                                            </div>
                                        </div>
                                        
                                    </div>

                                @endforeach

                            </li>

                            <hr>
                        @endforeach
                    @endif
                    
                </div>

                @if($hasCameraTypes)
                    <div class="col-md-6">
                        <h4 style="text-align: center;">Camera ticket:</h4>
                            <ul class="booking-list" style="cursor: unset;">
                                @foreach($camers as $camera)
                                    <li class="booking-item">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Camera type :</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>{{$camera['type']}}</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <h5>&#8377; {{$camera['price']}} / Camera</h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Number Of camera</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="form-control numberTextbox" name="camera[{{$camera['id']}}]" type="number" min="0" value="0" required />
                                                </div>
                                            </div>                       
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                    </div>
                @endif

            </div>
            
            
        </form>
            </div>
    </div>
<div class="gap"></div>

<script type="text/javascript">

    function closeDiv(divId) {
        $('#entranceDiv').remove();
    }

    function validateRequest() {

        // Validate user has selected at least one ticket
        var hasEntry = false;
        for(var i = 0; i < 7; i++)
        {
            if (document.getElementById('entry_' + i).value > 0) {
                hasEntry = true;
                break;
            }
        } 

        if (!hasEntry) {
            document.getElementById("entryAlert").style.display = "block";
            document.getElementById("alertMessage").innerHTML  = "Please enter atleast one Entry ticket.";
            return;
        }else{
            document.getElementById("entryAlert").style.display = "none";
        }



        //Validate teacher s seleted without selecting students 
        var validated = true;
        if (document.getElementById('entry7').value > 0 && (document.getElementById('entry5').value < 1 && document.getElementById('entry6').value < 1)) {
            validated = false;
        }

        if (!validated) {
            document.getElementById("entryAlert").style.display = "block";
            document.getElementById("alertMessage").innerHTML  = "You can not book 'Teachers / Lecturers' ticket without selecting 'Primary school / High school / College' ticket. ";
        }else{
            document.getElementById("entryAlert").style.display = "none";
        }

        //If all Okay. Submit
        if (hasEntry && validated) {
            document.getElementById("myForm").submit();
        }
    }
</script>

@endsection