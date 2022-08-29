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
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
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
    
    .invoice-box table tr td:nth-child(2){
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
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{asset('/assets/img/myecotrip/logo.png')}}" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                                Invoice #: {{$bookingData['display_id']}}<br>
                                Booking date : {{$bookingData['date_of_booking']}}<br>
                            </td>
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
                <td>No of Tickets</td>
                <td>{{$bookingData['no_of_seats']}}</td>
            </tr>
            <tr>
                <td>BirdSanctuary Entry Fee</td>
                <td>&#8377; {{$bookingData['birdsanctuaryFee']}}</td>
            </tr>
            <tr>
                <td>Boating Fee</td>
                <td>&#8377; {{$bookingData['park_entry_amount']}}</td>
            </tr>
            <tr>
                <td>Parking Fee</td>
                <td>&#8377; {{$bookingData['parkingFee']}}</td>
            </tr>
            <tr>
                <td>Camera Charges</td>
                <td>&#8377; {{$bookingData['cameraCharges']}}</td>
            </tr>
            
            <tr class="details">
                <td>Service charges</td>
                <td>&#8377; <?php echo $bookingData['service_charge'];?></td>
            </tr>
            <tr class="details total">
                <td>Grand total</td>
                <td>&#8377; {{$bookingData['amount_with_tax']}} </td>
            </tr>
            
            </table>

            <br><hr>
            <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    BirdSanctuary Details
                </td>
                
                <td>
                    
                </td>
            </tr>
            <tr class="details">
                <td>Name</td>
                <td>{{$birdSanctuaryData['name']}}</td>
            </tr>
            <tr>
                <td>Boating type</td>
                <td>{{$birdSanctuaryDetail['type']}}</td>
            </tr>
            <tr>
                <td>Check In</td>
                <td>{{$bookingData['checkIn']}}</td>
            </tr>
            <tr>
                <td>Timeslot</td>
                <td>{{$birdSanctuaryDetail['timeSlotName']}}</td>
            </tr>

        </table>

        <br><hr>
        <table class="table" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td colspan="6">
                    Visitors Details
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <th>SlNo</th>
                <th>Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Foreigner</th>
            </tr>
            <?php $slNo = 1; ?>
            @foreach($birdSanctuaryDetail['visitorsDetails'] as $visitors)
                <tr>
                    <td>{{$slNo}}</td>
                    <td style="float: left">{{$visitors['name']}}</td>
                    <td>{{$visitors['age']}}</td>
                    <td>{{$visitors['sex']}}</td>
                    <td>@if (isset($visitors['visitorType'])) Yes @else NO @endif</td>
                </tr>
                <?php $slNo++; ?>
            @endforeach

        </table>
        <hr>
        <br>
        <div class="row">
            <div class="col-sm-8">
                <b>Instructions:</b>
                <ul>
                    <li>Kindly carry a valid ID card with you. All rights of admission are reserved by Karnataka Forest Department.</li>
                    <li>At the start of the trek ensure your physical condition is good to do the trek, avoid if you are not feeling confident.</li>
                    <li>Ask all necessary information at basecamp before you start on the trek.</li>
                    <li>Be prepared for emergencies and changes in weather</li>
                    <li>Bring extra food, water and clothing. Surface water may be unsafe.</li>
                    <li>Tell somebody where you are going, when you will be back and who to call in case of emergency.</li>
                    <li>Protect yourself from tick and leech bites.</li>
                    <li>Always ask if you feel you are lost.</li>
                    <li>Do not get into waterfalls carelessly as you might slip and wet places harbor venomous snakes.</li>
                    <li>Carry basic first aid kit.</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
              <img id="logo" src="{{asset('/assets/img/myecotrip/karnatakaEcoTourism.png')}}" alt="Karnataka Ecotourism" style="width:180px;height:100px; float:center">
              <img id="logo" src="{{asset('/assets/img/myecotrip/Karnataka_Forest_Department_Logo_2016.png')}}" alt="Karnataka Forest Department" style="width:180px;height:100px; float:right">
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-sm-12"><a href="https://myecotrip.com">Back to site</a></div>
        </div>
        
    </div>
</body>
</html>