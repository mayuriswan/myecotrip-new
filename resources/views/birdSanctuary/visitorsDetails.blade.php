
@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="gap"></div>

    <div class="container">
        <div class="row">
            <form action="confirmBirdSanctuaryBooking" method="POST" id="visitorDetails" onclick="submitAddOnDetails();">
            <div class="col-md-8">
                <h3>Enter Visitior's Details:</h3>
                    <input type="hidden" name="boatType" value="{{$displayData['boatType']}}">

                    <!-- @if($displayData['boatType'] != 'Normal Boat')
                            <label>Foreigner &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="visitorType" value="1">&nbsp;&nbsp;(Please check if you are a Foreigner)</label><br>
                    @endif -->
                    @for ($i = 1; $i <= $displayData['requestedSeats']; $i++)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First & Last Name</label>
                                <input class="form-control" name="detail[{{$i}}][name]" type="text" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Age</label>
                                <input class="form-control" name="detail[{{$i}}][age]" type="number" min="1" required />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sex</label>
                                <select class="form-control" name="detail[{{$i}}][sex]" required >
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Foreigner</label><input type="checkbox" name="detail[{{$i}}][visitorType]" value="1">
                            </div>
                        </div>                        
                    </div>
                    @endfor
                <hr>
                <div class="col-md-12" style="margin-top: 45px;">
                    <h3>Add On's:</h3>
                        <div class="row">
                            <div class="col-xs-6"><strong>Parking Fee&nbsp;<span class="text-red dk-font-18"></span>&nbsp;</strong></div>
                                <div class="col-xs-6">
                                    <select class="form-control" name="parkingType" id="parkingType">
                                        <option value="">Parking Type</option>
                                        @foreach($displayData['parkingTypeDetails'] as $parkingType)
                                            <option value="{{$parkingType['id']}}">{{$parkingType['type']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <br>
                        <div class="row" id="vehicleTypes">
                            <div class="col-xs-5" >
                                <div class="form-group">
                                    <input type="number" min="1" style="display: none;" class="form-control" style="text-align: center;" name="noOfvehicles[]" id="noOfvehicles" placeholder="No. of Vehicles"> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12"><strong>Camera Fee&nbsp;<span class="text-red dk-font-18"></span>&nbsp;</strong></div>
                                <br><br>
                                @foreach($displayData['cameraTypeDetails'] as $cameraType)
                                <div class="col-xs-6">
                                    <input type="hidden" name="cameraType[]" value="CameraTypeID-{{$cameraType['cameratypeId']}}-{{$cameraType['cameraFee']}}-{{$cameraType['type']}}"/>
                                    <input type="checkbox" class="cameraType" id="cameraType" value="{{$cameraType['type']}}-({{$cameraType['cameraFee']}} Rs)">&nbsp;&nbsp;&nbsp;{{$cameraType['type']}}&nbsp;({{$cameraType['cameraFee']}} Rs)
                                </div>
                                <div class="col-xs-6">
                                    <input type="number" min="0" value="0" class="form-control" style="text-align: center;" name="noOfcameras[]" id="noOfcameras" placeholder="No. of Cameras"> 
                                </div>
                                <br><br><br>
                                @endforeach
                        </div>
                    
                        <script src="{{asset('assets/js/jquery.js') }} "></script>
                        <script>
                            function submitAddOnDetails() {
                                var vehicleNameArr = [];
                                var cameraNameArr = [];
                                $('.vehicleType').each(function() {
                                    if ($(this).is(':checked')) {
                                            var current = $(this).val();
                                    vehicleNameArr.push($(this).val());         
                                           }
                                });
                                $('.cameraType').each(function() {
                                    if ($(this).is(':checked')) {
                                            var current = $(this).val();
                                    cameraNameArr.push($(this).val());         
                                           }
                                });
                                $('#visitorDetails').append("<input type='hidden' name='vehicleName' value='"+vehicleNameArr+"' />");
                                $('#visitorDetails').append("<input type='hidden' name='cameraName' value='"+cameraNameArr+"' />");
                                return true;
                            }

                            $("#parkingType").change(function()
                            {
                                parkingTypeId = $("#parkingType").val();
                                birdSanctuaryId = {{$displayData['birdSanctuaryId']}};
                                var strURL="{{url('/')}}"+"/getParkingTypeDetails/"+birdSanctuaryId+"/"+parkingTypeId;
                                if(parkingTypeId > 0){
                                    $("#vehicleTypes").show();
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
                                $("#vehicleTypes").html(req.responseText);
                                }else{
                                    $("#vehicleTypes").hide();
                                }
                            });

                            $(document).on("change", "input.checkbox", function() {

                                var value = $(this).is(":checked") ? $(this).val() : null;

                                $(this).siblings("input[name='vehicleType[]']").val(value);    
                            });
                        </script>
                        <hr>
                </div>
                    <input id="checkEntry" type="hidden" value="0">
                     <hr>
                    <strong><span style="color: red;">Note :</span> 
                        <p>Please make sure you carry at least one Government Id proof.</p>
                        @if($displayData['boatType'] == 'Normal Boat')
                        <p>Normal Boating price per head</p>
                            <table style="width: 60% !important;" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Indian</th>
                                        <th>Foreign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Adult - {{$displayData['boatTypePrice'][0]['adult_price_india']}} Rs / Child - {{$displayData['boatTypePrice'][0]['child_price_india']}} Rs</td>
                                        <td>Adult - {{$displayData['boatTypePrice'][0]['adult_price_foreign']}} Rs / Child - {{$displayData['boatTypePrice'][0]['child_price_foreign']}} Rs</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        @if($displayData['boatType'] != 'Normal Boat')    
                        <p>Full Boat Type/ Photography Boat Type can contain max of 5 members</p>
                        <table style="width: 40% !important;" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Indian</th>
                                        <th>Foreign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$displayData['boatTypePrice'][0]['price_india']}} Rs per Boat</td>
                                        <td>{{$displayData['boatTypePrice'][0]['price_foreign']}} Rs per Boat</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </strong>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <input class="btn btn-primary" type="submit" value="Confirm Booking" />
                        </div>
                    </div>
               
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
                                    <p class="booking-item-payment-price-title">Boat Type</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['boatType']}}
                                    </p>
                                </li>
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
                                <li>
                                    <p class="booking-item-payment-price-title">Time Slot</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['timeslotValue']}}
                                    </p>
                                </li>
                                <li>
                                    <p class="booking-item-payment-price-title">No of Visitors</p>
                                    <p class="booking-item-payment-price-amount">{{$displayData['requestedSeats']}}
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            </form>
            </div>
    </div>
<div class="gap"></div>

@endsection