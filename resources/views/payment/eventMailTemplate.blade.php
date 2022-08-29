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
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                <table>
                        <tr>
                            <td class="title">
                                <img src="{{asset('/assets/img/myecotrip/logo.png')}}" style="width:100%; max-width:300px;">
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
                <td>Event name</td>
                <td>{{ucwords($bookingData['event_name'])}}</td>
            </tr>

            <tr class="details">
                <td>Booking Id</td>
                <td>{{$bookingData['display_id']}}</td>
            </tr>
            <tr class="details">
                <td>No of Tickets</td>
                <td>{{$bookingData['number_of_tickets']}}</td>
            </tr>
            <tr class="details">
                <td>Booking date</td>
                <td>{{substr($bookingData['date_of_booking'],0,10)}}</td>
            </tr>
            
            <tr class="details total">
                <td>Total</td>
                <td>&#8377; {{number_format((float)$bookingData['amount'], 2, '.', '')}}</td>
            </tr>

             <tr class="details">
                <td>Service charges</td>
                <td>&#8377; {{number_format((float)$bookingData['amountWithTax'] - $bookingData['amount'], 2, '.', '')}}</td>
            </tr>

            <tr class="details">
                <td>GST charges</td>
                <td>&#8377; {{number_format((float)$bookingData['gst_amount'], 2, '.', '')}} </td>
            </tr>

            <tr class="details total">
                <td>Grand total</td>
                <td>&#8377; {{$bookingData['amountWithTax']}} </td>
            </tr>
            
            </table>

        <br><hr>
            <table class="passengerDetails" cellpadding="0" cellspacing="0">
                <tr class="heading">
                    <td>Person Details</td>
                    
                    <td>                
                    </td>
                    <td></td><td></td>
                </tr>
                <tr>
                    <th>SlNo</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                </tr>
                @foreach (json_decode($bookingData['users_details'],true) as $slNo => $trekkers)
                    <tr>
                        <td style="width: 19%">{{$slNo + 1}}</td>
                        <td style="float: left">{{ucwords($trekkers['name'])}}</td>
                        <td>{{$trekkers['age']}}</td>
                        <td>{{$trekkers['sex']}}</td>
                    </tr>
                @endforeach
            </table>

        <hr>
        <div class="row">
            <div class="col-sm-8">
                <b>Instructions:</b>
                <ul>
                    <li>Kindly carry a valid ID card with you. All rights of admission are reserved by Karnataka Forest Department.</li>
                    <li>Be prepared for emergencies and changes in weather</li>
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
            <div class="col-sm-12"><a href="https://myecotrip.com" target="blank">Back to Myecotrip</a></div>
        </div>
        
    </div>
</body>
</html>