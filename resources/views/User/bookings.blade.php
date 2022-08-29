@extends('layouts.app')

@section('title', '')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
        <h1 class="page-title" style="font-size: 36px !important;">Account Setting</h1>
    </div>

    <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="user-profile-sidebar">
                        <div class="user-profile-avatar text-center">
                            <img src="{{ asset('assets/img/placeholder.jpg') }} " alt="Image Alternative text" title="AMaze" />
                            <h5>{{ucwords($userInfo['first_name'])}} {{ucwords($userInfo['last_name'])}}</h5>
                            <!-- <p>Member Since May 2012</p> -->
                        </div>
                        <ul class="list user-profile-nav">
                            <li><a href="userProfile"><i class="fa fa-user"></i>Profile</a>
                            </li>
                            <!-- <li><a href="user-profile-settings.html"><i class="fa fa-cog"></i>Settings</a>
                            </li>
                            <li><a href="user-profile-photos.html"><i class="fa fa-camera"></i>My Travel Photos</a>
                            </li> -->
                            <li><a href="userBookingHistory"><i class="fa fa-clock-o"></i>Booking History</a>
                            </li>
                            <!-- <li><a href="user-profile-cards.html"><i class="fa fa-credit-card"></i>Credit/Debit Cards</a>
                            </li>
                            <li><a href="user-profile-wishlist.html"><i class="fa fa-heart-o"></i>Wishlist</a>
                            </li> -->
                        </ul>
                    </aside>
                </div>
                <div class="col-md-9">
                    @if (count($bookings) == 0)
                    <div class="checkbox">
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">No success transaction to display</p>
                    </div>
                    @endif

                    @if(Session::has('bookingMess'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('bookingMess') }}</p>
                    @endif

                    @if (count($bookings) > 0)
                        <h4>Trails Booking : </h4>
                        <table class="table table-bordered table-striped table-booking-history">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>Booking Id</th>
                                    <th>Trail Name</th>
                                    <th>Date of booking</th>
                                    <th>Check In</th>
                                    <th>Number of ticket</th>
                                    <th>Cost</th>
                                    <th>Send Ticket via Mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$booking['display_id']}}</td>
                                    <td>{{$booking['trailName']}}</td>
                                    <td>{{substr($booking['date_of_booking'],0,10)}}</td>
                                    <td>{{substr($booking['checkIn'],0,10)}}</td>
                                    <td>{{$booking['total_trekkers']}}</td>
                                    <td>{{$booking['amountWithTax']}}</td>
                                    @if($booking['checkIn'] >= date("Y-m-d"))
                                        <td><a href="{{url('/')}}/resendTrailTicket/{{$booking['id']}}/2">Resend Ticket</a></td>
                                    @else
                                        <td>NA</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if (count($jsBookings) > 0)
                        <h4>Jungle Stay Booking : </h4>
                        <table class="table table-bordered table-striped table-booking-history">
                            <thead>
                                <tr>
                                    <th>SlNo</th>
                                    <th>Booking Id</th>
                                    <th>JS Name</th>
                                    <th>Date of booking</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Number of Guest</th>
                                    <th>Cost</th>
                                    <th>Send Ticket via Mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jsBookings as $index => $booking)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$booking['display_id']}}</td>
                                    <td>{{$booking['name']}}</td>
                                    <td>{{substr($booking['date_of_booking'],0,10)}}</td>
                                    <td>{{$booking['check_in']}}</td>
                                    <td>{{$booking['check_out']}}</td>
                                    <td>{{$booking['total_guests']}}</td>
                                    <td>{{$booking['total_amount']}}</td>
                                    @if($booking['check_in'] >= date("Y-m-d"))
                                        <td><a href="{{url('/')}}/jungle-stays/resend-mail/{{$booking['id']}}/2">Resend Ticket</a></td>
                                    @else
                                        <td>NA</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>

   <div class="gap"></div>

@endsection
