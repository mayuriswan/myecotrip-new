<footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="index.html">
                            <!-- <img class="navbarLogo" src="{{asset('assets/img/myecotrip/logo.png') }} " alt="Myecotrip" title="Myecotrip" /> -->
                        </a>
                        <p class="mb20">Want to discover the unknown trails? Want to know more about birds, flora, fungi, mammals and butterflies of the Karnataka's hills, forests and grasslands?
Fulfill your Nature Quest Through MyecoTrip.</p>
                        <ul class="list list-horizontal list-space">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="https://www.facebook.com/myecotrip"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="https://twitter.com/myecotrip"></a>
                            </li>
                            <!-- <li>
                                <a class="fa fa-google-plus box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li> -->
                            <li>
                                <a class="fa fa-instagram box-icon-normal round animate-icon-bottom-to-top" href="https://www.instagram.com/myecotrip/"></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest box-icon-normal round animate-icon-bottom-to-top" href="https://www.pinterest.com/myecotrip/"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-3">
                        <h4>Subscribe us</h4>
                        @if(Session::has('subscribeMessage'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('subscribeMessage') }}</p>
                        @endif
                        <form action="subscribe" method="POST">
                            <label>Enter your E-mail Address</label>
                            <input type="email" name="email" class="form-control" required>
                            <p class="mt5"><small>*We Never Send Spam</small>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Subscribe">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <ul class="list list-footer">
                            <li><a href="{{url('/')}}/contactUs">Contact us</a>
                            </li>
                           <!--  <li><a href="#">Press Centre</a>
                            </li>
                            <li><a href="#">Best Price Guarantee</a>
                            </li>
                            <li><a href="#">Travel News</a>
                            </li>
                            <li><a href="#">Jobs</a>
                            </li> -->
                            <li><a href="{{url('/')}}/PrivacyPolicy">Privacy Policy</a>
                            </li>
                            <li><a href="{{url('/')}}/TermsofUse">Terms of Use</a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4> <a href="{{url('/')}}/frequently-asked-questions" class="text-color"> Frequently Asked Questions</a></h4>
                        <h4>Still have Questions? Reach us at :</h4>
                        <h4 class="text-color">+91 72045-64125 <br/> +91 81974-50947 <br>080 23448826 </h4>
                        <p>10:00 AM to 05:30 PM Dedicated Customer Support</p>

                        <h4 class="text-color">support@myecotrip.com</h4>
                        <h4>
                            Visitors Count :
                            <span>{{$clients or '404022'}}</span>

                        </h4>
                    </div>

                </div>
            </div>
        </footer>
