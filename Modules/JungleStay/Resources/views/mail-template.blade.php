<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Myecotrip Ticket</title>

    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;

        font-family:"Gotham-Medium";
        letter-spacing: 0.5px;
        color: #444141;
        line-height: 1.63;
    }

    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }

    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }

    #bookingDetails tr td:nth-child(2){
        text-align:right;
    }

    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }

    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }

    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }

    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }

    .invoice-box table tr.details td{
        /*padding-bottom:10px;*/
    }

    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }

    .invoice-box table tr.item.last td{
        border-bottom:none;
    }

    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }

    .qrCodeImage {
        margin-top: -30px;
        width: 107px;
    }

    .karDepLogo{
        width: 105px;
        height: 99px;
        float: right;
    }

    .karEcotr{
        width: 185px;
        height: 79px;
    }

    table.passengerDetails th{
        padding-top: 10px;
    }
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }

        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0" id="bookingDetails">
            <tr class="top">
                <td colspan="2">
                <table>
                        <tr>
                            <td class="title">
                                <img src="{{asset('/assets/img/myecotrip/logo.png')}}" style="width:100%; max-width:300px;">
                            </td>

                            <!-- <td>
                                <img class="qrCodeImage" src="{{url('/')}}/assets/img/qrcodes/"><br>
                            </td> -->
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Next Step Webs, Inc.<br>
                                12345 Sunny Road<br>
                                Sunnyville, TX 12345
                            </td>

                            <td>
                                Acme Corp.<br>
                                John Doe<br>
                                john@example.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr> -->

            <tr class="heading">
                <td>
                    Booking Details
                </td>
                <td></td>
            </tr>

            <tr class="details">
                <td>Booking Id</td>
                <td>{{$bookingData['display_id']}}</td>
            </tr>
            <tr class="details">
                <td>No of Guests</td>
                <td>{{$bookingData['total_guests']}}</td>
            </tr>
            <tr class="details">
                <td>Date of Booking</td>
                <td>{{date("d-m-Y", strtotime(substr($bookingData['date_of_booking'],0,10)))}}</td>
            </tr>

            <tr class="details">
                <td>Check In</td>
                <td>{{date("d-m-Y", strtotime(substr($bookingData['check_in'],0,10)))}}</td>
            </tr>

            <tr class="details">
                <td>Check Out</td>
                <td>{{date("d-m-Y", strtotime(substr($bookingData['check_out'],0,10)))}}</td>
            </tr>

            <tr class="details total">
                <td>Total</td>
                <td>&#8377; {{$bookingData['total_amount']}}</td>
            </tr>

            </table>

            <br><hr>
            <table cellpadding="0" cellspacing="0" id="bookingDetails">
            <tr class="heading">
                <td>
                    Jungle Stay Details
                </td>

                <td>

                </td>
            </tr>
            <tr class="details">
                <td>Name</td>
                <td>{{ucwords($stayData['name'])}}</td>
            </tr>

                <tr class="details">
                    <td>Contant No</td>
                    <td>{{$stayData['incharger_details']}}</td>
                </tr>

                <tr class="details">
                    <td>For more details</td>
                    <td><a href="{{url('/')}}/frequently-asked-questions" target="blank">Click Here</a></td>
                </tr>

        </table>

        <br><hr>
            <table class="passengerDetails" cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td>Room Details</td>

                    <td>
                    </td>
                    <td></td><td></td><td></td>
                </tr>
            </table>

                @foreach ($rooms as $sNo => $room)
                <?php $slNo = 1; ?>
                    <table>
                        <tr>
                            <th>Jungle Stay type : {{$room['name']}}</th>
                            <th>No. Of Stay : {{$room['no_of_rooms']}}</th>
                        </tr>
                    </table>
                    <table class="passengerDetails table" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>SlNo</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Sex</th>
                        </tr>

                        <?php $guestList = json_decode($room['guest_details'], true); ?>
                        @foreach($guestList as $key => $guest)
                            <tr>
                                <td>{{$slNo++}}</td>
                                <td style="text-aligh:center;">{{$guest['name']}}</td>
                                <td>{{$guest['age']}}</td>
                                <td>{{$guest['sex']}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <hr>
                @endforeach


        @if($bookingData['vehicle_details'])
        <br><hr>
            <table class="passengerDetails" cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td>Vehicle Details</td>

                    <td>
                    </td>
                    <td></td><td></td><td></td>
                </tr>
                <tr>
                    <th>SlNo</th>
                    <th>Vehicle Type</th>
                    <th>Numbers</th>
                </tr>

                <?php $slNo = 1; ?>
                <?php $vehicles = json_decode($bookingData['vehicle_details'], true); ?>
                @foreach($vehicles as $key => $guest)
                    <tr>
                        <td>{{$slNo++}}</td>
                        <td>{{$vehiclePricing[$guest['pricing_id']]['type']}}</td>
                        <td>{{$guest['count']}}</td>
                    </tr>
                @endforeach
            </table>

        <hr>
        @endif

        <div class="row">
            <div class="col-sm-8">
                <b>Instructions:</b>
                <ul>
                    {!!$stayData['general_instructions'] !!}
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
              <img id="logo" class="karEcotr" src="{{asset('/assets/img/myecotrip/karnatakaEcoTourism.png')}}" alt="Karnataka Ecotourism">
              <img id="logo" class="karDepLogo" src="{{asset('/assets/img/myecotrip/Karnataka_Forest_Department_Logo_2016.png')}}" alt="Karnataka Forest Department">
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-sm-12"><a href="url('/')" target="blank">Back to Myecotrip</a></div>
        </div>

    </div>
</body>
</html>
