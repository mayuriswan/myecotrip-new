<header id="main-header">
            <div class="header-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <a class="logo" href="{{ url('/') }}">
                                <img src="{{asset('assets/img/myecotrip/karnatakaEcoTourism.png') }}" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </div>
                        <div class="col-md-3 col-md-offset-2">
                            <form class="main-header-search">
                                <div class="form-group form-group-icon-left">
                                    <!-- <i class="fa fa-search input-icon"></i>
                                    <input type="text" class="form-control"> -->
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="top-user-area clearfix">
                                <ul class="top-user-area-list list list-horizontal list-border">
                                  @if(Session::has('userId'))
                                    <li class="top-user-area-avatar">
                                        <a href="{{ url('/userProfile') }}">
                                            <i class="fa fa-user input-icon"></i> Hi,  {{ucwords(Session::get('userName'))}}</a>
                                    </li>
                                    <li><a href="{{url('/')}}/signOut">Sign Out</a>
                                    </li>
                                    @else
                                    <li><a data-toggle="modal" data-target="#myModal" >Sign In</a></li>

                                    @endif
                                    <li>
                                      <img class="kfdLogo" src="{{asset('assets/img/myecotrip/karnataka-forest-logo-compressor.png') }}" alt="Karnataka Forest Departement" title="Karnataka Forest Departement" />
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="nav">
                    <ul class="slimmenu" id="slimmenu">
                        <li class="active"><a href="{{url('/')}}">Home</a>

                        </li>

                        <li><a href="">About</a>
                            <ul>
                                <li><a href="{{url('karnataka-eco-tourism-development-board')}}">KEDB</a>
                                </li>
                                {{-- <li><a href="">Myecotrip</a>
                                </li> --}}

                            </ul>
                        </li>

                        <li><a href="{{url('/landscapes')}}">Ecotrails</a>
                            <ul>

                                @foreach($landscapes as $i => $landscape)
                                    <li>
                                        <a href="{{url('trails')}}/{{$landscape['id']}}/{{$landscape['seo_url']}}">{{ucwords($landscape['name'])}}</a>
                                        <ul>
                                            @foreach($trails as $j => $trail)
                                                @if($trail['landscape_id'] == $landscape['id'])
                                                    <li><a href="{{url('/')}}/trailDetail/{{$trail['id']}}/{{$trail['name']}}">{{ucwords($trail['name'])}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach



                            </ul>
                        </li>
                        <li><a href="{{url('/eventsList')}}">Festivals and Other Programmes</a>
                            <ul>

                                    <li>
                                        <a href="#">{{ucwords('Bird Festivals')}}</a>
                                        <ul>
                                            @foreach($birdFest as $i => $event)
                                                @if($event['event_id'] == 1)
                                                    <li><a href="{{url('eventDetails')}}/{{$event['id']}}/{{$event['event_id']}}/{{str_replace(' ','_',$event['name'])}}">{{ucwords($event['name'])}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">{{ucwords('Other Festivals')}}</a>
                                        <ul>
                                            @foreach($birdFest as $i => $event)
                                                @if($event['event_id'] == 2)
                                                    <li><a href="{{url('eventDetails')}}/{{$event['id']}}/{{$event['event_id']}}/{{str_replace(' ','_',$event['name'])}}">{{ucwords($event['name'])}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>


                            </ul>
                        </li>



                        {{-- <li><a href="">Jungle Stays</a>
                            <ul>
                                <li><a href="">Stay 1</a>
                                </li>
                                <li><a href="">Stay 2</a>
                                </li>

                            </ul>
                        </li>

                        <li><a href="">Safari</a>
                            <ul>
                                <li><a href="">Safari 1</a>
                                </li>
                                <li><a href="">Safari 2</a>
                                </li>

                            </ul>
                        </li> --}}
                        <li><a href="">Training and Awareness Programmes</a>
                          <ul>
                            <li><a href="{{url('/nature-guide')}}">Nature Guide</a></li>
                            <li><a href="{{url('/naturalists')}}">Naturalists</a></li>
                            <li><a href="{{url('/volunteer')}}">Volunteer</a></li>
                            <li><a href="{{url('/capacity-building-training')}}">Capacity Building Training</a></li>
                            <li><a href="{{url('/nature-conservation-education-programme')}}">NCEP</a></li>
                            <li><a href="{{url('/csr')}}">Corporate Social Responsibility</a></li>

                          </ul>
                        </li>
                        <li><a href="{{url('/contactUs')}}">Contact Us</a></li>

                        {{-- <li><a href="{{url('/training-and-news')}}">Training</a></li> --}}
                        {{-- <li><a href="{{url('/training-and-news')}}">News & Events</a></li> --}}
                        <li><a href="">Downloads</a></li>
                        <li><a href="{{url('/gallery')}}">Gallery</a></li>

                    </ul>
                </div>
            </div>
        </header>

<div>
  @if(Session::has('headerMess'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('headerMess') }}</p>
  @endif
</div>
<!-- Get user phone number social login modal -->
<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Please complete the sign up.</h4>
            </div>
            <div class="modal-body">
                <form action="{{url('/')}}/socialSignUp" method="POST">
                  @if(Session::has('socialData'))
                    <input type="hidden" name="userData" value="{{ Session::get('socialData') }}">
                  @endif
                    <div class="form-group form-group-icon-left signinForm"><i class="fa fa-phone input-icon"></i>
                      <label>Phone Number</label>
                      <input class="form-control" name="contact_no" placeholder="+91 1234567890" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" type="tel" required/>
                   </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- End Get user phone number social login modal  -->

<!-- Login modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            ×</button>
            <h4 class="modal-title" id="myModalLabel">
               Sign In / Sign Up
            </h4>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-8" style="border-right: 1px dotted #C2C2C2;padding-right: 30px;">
                  @if(Session::has('message'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('message') }}</p>
                  @endif
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs">
                     <li class="active"><a href="#Login" data-toggle="tab">Sign In</a></li>
                     <li><a href="#Registration" data-toggle="tab">Sign Up</a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content" style="margin-top: 16px;">
                     <div class="tab-pane active" id="Login">
                        <form action="{{ url('/')}}/userSignIn" method="POST" role="form" class="form-horizontal">
                           <input type="hidden" name="loginType" value="myecotrip">
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-user input-icon"></i>
                              <label>Email</label>
                              <input class="form-control" name="userName" placeholder="user@gmail.com" type="text" required />
                           </div>


                            <div class="form-group form-group-icon-left signinForm"><i class="fa fa-key input-icon"></i>
                              <label>Password</label>
                              <input class="form-control" name="password" placeholder="Doe" type="password" required/>
                           </div>

                           <div class="form-group signinForm">
                              <label><a href="#forgotPassword" data-toggle="tab">Forgot password</a></label>
                           </div>

                           <button type="submit" class="btn btn-primary btn-sm">Login</button>

                           <hr>

                           <div class="form-group form-group-icon-left signinForm">
                              <label>Social Login</label>
                              <a href="{{url('/')}}/redirect/google"><img src="{{asset('assets/img/social/google-plus-icon.png') }}" style="height: 41px;width: 54px;"></a>
                              <a href="{{url('/')}}/redirect/facebook"><img src="{{asset('assets/img/social/facebook.png') }}" style="height: 56px;width: 71px;"></a>
                           </div>


                        </form>
                     </div>
                     <div class="tab-pane" id="Registration">
                        <form action="{{ url('/')}}/userSignUp" method="POST" role="form" class="form-horizontal">
                           <input type="hidden" name="sign_in_with" value="myecotrip">
                           <h4>Personal Infomation</h4>
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-user input-icon"></i>
                              <label>First Name</label>
                              <input class="form-control" name="first_name" placeholder="John" type="text" required />
                           </div>
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-user input-icon"></i>
                              <label>Last Name</label>
                              <input class="form-control" name="last_name" placeholder="Doe" type="text" required/>
                           </div>
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-envelope input-icon"></i>
                              <label>E-mail</label>
                              <input class="form-control" name="email" placeholder="johndoe@gmail.com" type="email" required />
                           </div>
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-phone input-icon"></i>
                              <label>Phone Number</label>
                              <input class="form-control" name="contact_no" placeholder="+91 1234567890" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" type="tel" required/>
                           </div>
                           <div class="form-group form-group-icon-left signinForm">
                              <i class="fa fa-globe input-icon" aria-hidden="true"></i>
                              <label>Country</label>
                              <select name="country" class="form-control" required>
                                 <option value="India">India</option>
                                 <option value="Other">Other</option>
                              </select>
                           </div>
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-key input-icon"></i>
                              <label>Password</label>
                              <input class="form-control" id="password" name="password" placeholder="******" type="password" required/>
                           </div>
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-key input-icon"></i>
                              <label>Confirm password</label>
                              <input class="form-control" id="confirm_password" name="confPassword" placeholder="******" type="password" required/>
                           </div>

                           <div class="col-md-12">
                              <div class="form-group">
                                 <div class="g-recaptcha" name="captcha" data-sitekey="6Lcz24IUAAAAAESSofZ03DoKdlOsffLC8w7NlNz_"></div>
                              </div>
                            </div>

                           <div class="gap gap-small"></div>
                           <hr>
                           <button type="submit" class="btn btn-primary btn-sm">Sign up</button>
                           <button data-dismiss="modal" type="button" class="btn btn-danger btn-sm">
                           Cancel</button>
                        </form>
                     </div>

                     <div class="tab-pane" id="forgotPassword">
                        <form action="{{ url('/')}}/requestForgotPassword" method="POST" role="form" class="form-horizontal">
                           <input type="hidden" name="loginType" value="myecotrip">
                           <div class="form-group form-group-icon-left signinForm"><i class="fa fa-user input-icon"></i>
                              <label>Email</label>
                              <input class="form-control" name="email" placeholder="Enter your registered Email" type="text" required />
                           </div>

                           <hr>

                           <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </form>
                     </div>

                  </div>
               </div>
               <div class="col-md-4">
                  <div class="row text-center sign-with">
                     <img style="margin-top: 36%;" src="{{asset('assets/img/myecotrip/logo.png')}}">
                     <!-- <div class="col-md-12">
                        <h3>
                            Sign in with</h3>
                        </div>
                        <div class="col-md-12">
                        <div class="btn-group btn-group-justified">
                            <a href="#" class="btn btn-primary">Facebook</a> <a href="#" class="btn btn-danger">
                                Google</a>
                        </div>
                        </div> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@if (count($_GET) > 0 && isset($_GET['reset']) && $_GET['reset'] == 'true')
<!-- Reset Modal -->
   <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-md">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
               ×</button>
               <h4 class="modal-title" id="myModalLabel">
                  Password reset
               </h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-8" style="border-right: 1px dotted #C2C2C2;padding-right: 30px;">
                     @if(Session::has('resetMessage'))
                     <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('resetMessage') }}</p>
                     @endif

                     <!-- Tab panes -->
                     <div class="tab-content" style="margin-top: 16px;">
                        <div class="tab-pane active" id="Login">
                           <form action="{{ url('/')}}/resetPassword" method="POST" role="form" class="form-horizontal">
                              <input type="hidden" name="id" value="{{$_GET['id']}}">
                              <input type="hidden" name="ticket" value="{{$_GET['ticket']}}">
                              <div class="form-group form-group-icon-left signinForm"><i class="fa fa-key input-icon"></i>
                                 <label>Password</label>
                                 <input class="form-control" id="resetPassword" name="resetPassword" placeholder="******" type="password" required/>
                              </div>
                              <div class="form-group form-group-icon-left signinForm"><i class="fa fa-key input-icon"></i>
                                 <label>Confirm password</label>
                                 <input class="form-control" id="resetPassword2" name="resetPassword2" placeholder="******" type="password" required/>
                              </div>

                              <hr>

                              <button type="submit" class="btn btn-primary btn-sm">Change password</button>
                           </form>
                        </div>

                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="row text-center sign-with">
                        <img style="margin-top: 36%;" src="{{asset('assets/img/myecotrip/logo.png')}}">
                        <!-- <div class="col-md-12">
                           <h3>
                               Sign in with</h3>
                           </div>
                           <div class="col-md-12">
                           <div class="btn-group btn-group-justified">
                               <a href="#" class="btn btn-primary">Facebook</a> <a href="#" class="btn btn-danger">
                                   Google</a>
                           </div>
                           </div> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

@endif

<style type="text/css">
  .navbar {
    /*position: relative;*/
}
.navbar-brand {
    /*position: absolute;*/
    /*left: 50%;*/
    /*margin-left: -50px !important;  /* 50% of your logo width */*/
    /*display: block;*/
}
</style>
