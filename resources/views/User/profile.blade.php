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
                            <li><a href="userBookingHistory"><i class="fa fa-history"></i>Booking History</a>
                            </li>
                            <!-- <li><a href="user-profile-cards.html"><i class="fa fa-credit-card"></i>Credit/Debit Cards</a>
                            </li>
                            <li><a href="user-profile-wishlist.html"><i class="fa fa-heart-o"></i>Wishlist</a>
                            </li> -->
                        </ul>
                    </aside>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                        	@if(Session::has('profileUpdateMessage'))
							    <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('profileUpdateMessage') }}</p>
							@endif

                            <form action="updateProfile" method="POST">
                            	<input type="hidden" name="id" value="{{$userInfo['id']}}">
                                <h4>Personal Infomation</h4>
                                <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                    <label>First Name</label>
                                    <input class="form-control" name="first_name" value="{{$userInfo['first_name']}}" type="text" required />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
                                    <label>Last Name</label>
                                    <input class="form-control" name="last_name" value="{{$userInfo['last_name']}}" type="text" required/>
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
                                    <label>E-mail</label>
                                    <input class="form-control" value="{{$userInfo['email']}}" type="text" readonly required/>
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-phone input-icon"></i>
                                    <label>Phone Number</label>
                                    <input class="form-control" pattern="^(((\+?\(91\))|0|((00|\+)?91))-?)?[7-9]\d{9}$" name="contact_no" value="{{$userInfo['contact_no']}}" title="Match the format +918861422700 or 8861422700" type="phone" required/>
                                </div>
                                <div class="gap gap-small"></div>
                                <!-- <h4>Location</h4>
                                <div class="form-group form-group-icon-left"><i class="fa fa-plane input-icon"></i>
                                    <label>Home Airport</label>
                                    <input class="form-control" value="London Heathrow Airport (LHR)" type="text" />
                                </div>
                                <div class="form-group">
                                    <label>Street Address</label>
                                    <input class="form-control" value="46 Gray's Inn Rd, London, WC1X 8LP" type="text" />
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control" value="London" type="text" />
                                </div>
                                <div class="form-group">
                                    <label>State/Province/Region</label>
                                    <input class="form-control" value="London" type="text" />
                                </div>
                                <div class="form-group">
                                    <label>ZIP code/Postal code</label>
                                    <input class="form-control" value="4115523" type="text" />
                                </div> -->
                                <div class="form-group">
                                    <label>Country</label>
                                    <select name="country" class="form-control" required>
			                             <option @if ($userInfo['country'] == "India") selected @endif value="India">India</option>
			                             <option @if ($userInfo['country'] == "Other") selected @endif value="Other">Other</option>
		                          	</select>
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-primary" value="Save Changes">
                            </form>
                        </div>
                        <div class="col-md-5 col-md-offset-1">
                            <h4>Change Password</h4>
                            @if(Session::has('passwordUpdateMessage'))
							    <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('passwordUpdateMessage') }}</p>
							@endif

                            <form action="passwordUpdate" method="POST">
                            	<input type="hidden" name="id" value="{{$userInfo['id']}}">
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label>Current Password</label>
                                    <input class="form-control" type="password" required name="currentPass" />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label>New Password</label>
                                    <input class="form-control" type="password" id="newPassword" name="newPassword" required />
                                </div>
                                <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                    <label>New Password Again</label>
                                    <input class="form-control" type="password" id="newPassword2" name="newPassword2" required />
                                </div>
                                <hr />
                                <input class="btn btn-primary" type="submit" value="Change Password" />
                            </form>

                            <br>
                            <h4>Verifications</h4>
                            <hr />
                            @if(Session::has('verificationMess'))
                              <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('verificationMess') }}</p>
                            @endif

                            @if ($userInfo['email_verified'] == 1)
                                <label>Email <i class="fa fa-thumbs-o-up check"  title="Email verified" aria-hidden="true"> Verified</i></label>
                            @else
                                <label>Email <a href="emailVerify/{{$userInfo['id']}}"><i title="Email not verified" class="fa fa-thumbs-o-down Uncheck" aria-hidden="true"> Verify now</i></a></label>
                            @endif

                            @if ($userInfo['phone_verified'] ==  1)
                                <label>Mobile <i title="Phone Verified" class="fa fa-thumbs-o-up check" aria-hidden="true"> Verified</i></label>
                            @else
                                <label>Mobile <a href="mobileVerify/{{$userInfo['id']}}"><i title="Phone number not verified" class="fa fa-thumbs-o-down Uncheck" aria-hidden="true" > Verify now</i></a></label>
                            @endif

                            <div class="modal fade" id="myModal2" role="dialog">
                                <div class="modal-dialog modal-md">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Veriry your mobile</h4>
                                    </div>
                                    <div class="modal-body">
                                        @if(Session::has('sentOtp'))
                                          <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('sentOtp') }}</p>
                                        @endif
                                        <form action="verifyOTP" method="POST">
                                            <input type="hidden" name="userId" value="{{Session::get('userId')}}">
                                            <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
                                                <label>Enter the OTP</label>
                                                <input class="form-control" type="number" name="otp" required />
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Verify</button>
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

   <div class="gap"></div>

<!-- <script>
    function activateModal(userId) {
        $("#myModal2 #pName").text( userId );
    }
</script> -->
@endsection
