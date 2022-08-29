@section('title')
| Karnataka Forest Department
@endsection

@extends('layouts.app')

@section('title', '')

@section('meta')
   <meta name="google-site-verification" content="5ZwQ7woNfz2oe7UHjdX1elOPWTBREzZHJaV179toc1g" />
@endsection

@section('sidebar')

@endsection

@section('content')
    <!-- FACEBOOK WIDGET -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "../../../../connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- /FACEBOOK WIDGET -->
    <div class="global-wrap">

        <!-- Header -->
        @include('layouts.header')

        <!-- TOP AREA -->
        <div class="top-area show-onload">
            <div class="owl-carousel owl-slider owl-carousel-area" id="owl-carousel-slider">
                @foreach ($banners as $key => $sliderImage)
                <div class="bg-holder full text-center text-white">
                    <div class="bg-mask"></div>
                    <div class="bg-img" style="background-image:url({{asset($sliderImage['path'])}});"></div>
                    <div class="bg-front full-center">
                        <div class="owl-cap">
                            <!-- <div class="owl-cap-weather"><span>+26</span><i class="im im-rain"></i></div> -->
                            <h1 class="owl-cap-title fittext">{!!$sliderImage['title']!!}</h1>
                            <div class="owl-cap-price"><small>{{$sliderImage['short_description']}}</small>
                                <!-- <h5>$1300</h5> -->
                            </div><a class="btn btn-white btn-ghost" href="{{$sliderImage['href']}}"><i class="fa fa-angle-right"></i> {{$sliderImage['button_name']}}</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <!-- END TOP AREA  -->

        <div class="bg-darken">
            <div class="container">
                <div class="gap"></div>
                <h2>Discover New Journey</h2>
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img class="newJou"  src="https://myecotrip.com/assets/img/landscape/1512373332.JPG" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                </a>
                            </header>
                            <div class="img-left">
                                <!-- <img src="img/flags/32/us.png" alt="Image Alternative text" title="Image Title" /> -->
                            </div>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><a class="text-darken" href="#">Skandagiri</a></h4>
                                <div class="thumb-caption">
                                    <p class="thumb-desc">Ecotrail</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img class="newJou"  src="https://myecotrip-live.s3.ap-south-1.amazonaws.com/trailImages/8/1559818411_logo.jpg" alt="Image Alternative text" title="people on the beach" />
                                </a>
                            </header>
                            <div class="img-left">
                                <!-- <img src="img/flags/32/gr.png" alt="Image Alternative text" title="Image Title" /> -->
                            </div>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><a class="text-darken" href="#">Ettinabhuja</a></h4>
                                <div class="thumb-caption">
                                    <p class="thumb-desc">Ecotrail</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img class="newJou"  src="https://myecotrip-live.s3.ap-south-1.amazonaws.com/trailImages/11/1563384947_logo.jpg" alt="Image Alternative text" title="196_365" />
                                </a>
                            </header>
                            <div class="img-left">
                                <!-- <img src="img/flags/32/fr.png" alt="Image Alternative text" title="Image Title" /> -->
                            </div>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><a class="text-darken" href="#">Bandage falls</a></h4>
                                <div class="thumb-caption">
                                    <p class="thumb-desc">Ecotrail</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img  class="newJou" src="https://myecotrip-live.s3.ap-south-1.amazonaws.com/trailImages/4/1549284565_logo.jpg" alt="Image Alternative text" title="El inevitable paso del tiempo" />
                                </a>
                            </header>
                            <div class="img-left">
                                <!-- <img src="img/flags/32/hu.png" alt="Image Alternative text" title="Image Title" /> -->
                            </div>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><a class="text-darken" href="#">Bidarakatte</a></h4>
                                <div class="thumb-caption">
                                    <p class="thumb-desc">Ecotrail</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gap gap-small"></div>

                <div class="row row-wrap">

                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img class="newJou"  src="https://myecotrip-live.s3.ap-south-1.amazonaws.com/eventImages/13/1577686586_logo.jpg" alt="Image Alternative text" title="people on the beach" />
                                </a>
                            </header>
                            <div class="img-left">
                                <!-- <img src="img/flags/32/gr.png" alt="Image Alternative text" title="Image Title" /> -->
                            </div>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><a class="text-darken" href="#">Bird Festival 2020</a></h4>
                                <div class="thumb-caption">
                                    <p class="thumb-desc">Bird Fest</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img class="newJou"  src="https://myecotrip-dev.s3.ap-south-1.amazonaws.com/jsImages/10/1569007089_logo.JPG" alt="Image Alternative text" title="people on the beach" />
                                </a>
                            </header>
                            <div class="img-left">
                                <!-- <img src="img/flags/32/gr.png" alt="Image Alternative text" title="Image Title" /> -->
                            </div>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><a class="text-darken" href="#">Gopinatham Mistray</a></h4>
                                <div class="thumb-caption">
                                    <p class="thumb-desc">Jungle Stay</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <div class="bg-holder">
            <div class="bg-mask"></div>
            <div class="bg-img" style="background-image:url({{asset('assets/img/slider/banner.jpg') }});"></div>
            <div class="bg-content">
                <div class="container">
                    <div class="gap gap-big text-center text-white">
                        <h2 class="text-uc mb20"> “Once in a while go somewhere you have never been before.”</h2>
                        <!-- <ul class="icon-list list-inline-block mb0 last-minute-rating">
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                        </ul>
                        <h5 class="last-minute-title">The Peninsula - New York</h5>
                        <p class="last-minute-date">Fri 14 Mar - Sun 16 Mar</p>
                        <p class="mb20"><b>$120</b> / person</p><a class="btn btn-lg btn-white btn-ghost" href="#">Book Now <i class="fa fa-angle-right"></i></a> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="gap gap-small"></div>

        <div class="container">
            <h2 class="text-center">Top Categories</h2>
            <div class="gap">

            <div class="row row-wrap">
                <div class="col-md-4">
                    <div class="thumb text-center">
                        <header class="thumb-header">
                            <a class="hover-img curved" href="{{ url('landscapes') }}">
                                <img src="{{asset('assets/img/categories/ecotrails.jpg') }} " alt="Ecotrails" title="Popular Trekkings" />
                                <h5 class="hover-title-top-left hover-hold categoriesName">Ecotrails</h5>
                            </a>
                        </header>
                        <div class="thumb-caption text-center">
                            <p class="thumb-desc"></p><a class="btn btn-default btn-ghost mt10" href="{{ url('landscapes') }}">Explore Trekkings<i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb text-center">
                        <header class="thumb-header">
                            <a class="hover-img curved" href="{{ url('eventsList') }}">
                                <img class="categoriesImages" src="{{asset('assets/img/categories/birdsFest.jpg') }}" alt="Bird Festival & Other Events" title="Bird Festival & Other Events" />
                                <h5 class="hover-title-top-left hover-hold categoriesName" style="margin:0px !important;">Bird Festival & Other Events</h5>
                            </a>
                        </header>
                        <div class="thumb-caption text-center">
                            <p class="thumb-desc"></p><a class="btn btn-default btn-ghost mt10" href="{{ url('eventsList') }}">Bird Festival & Other Events<i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-md-4">
                    <div class="thumb text-center">
                        <header class="thumb-header">
                            <a class="hover-img curved" href="{{ url('jungle-stays') }}">
                                <img src="{{asset('assets/img/categories/jungleStay.jpg') }}" alt="Jungle Stays" title="Popular Jungle Stays" />
                                <h5 class="hover-title-top-left hover-hold categoriesName" style="margin:0px !important;">Jungle Stays</h5>
                            </a>
                        </header>
                        <div class="thumb-caption text-center">
                            <p class="thumb-desc"></p><a class="btn btn-default btn-ghost mt10" href="{{ url('jungle-stays') }}">Find More Jungle Stays<i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb text-center">
                        <header class="thumb-header">
                            <a class="hover-img curved" href="{{ url('comingSoon') }}">
                                <img src="{{asset('assets/img/categories/safari.jpg') }}" alt="Wildlife Safari" title="Wildlife Safari" />
                                <h5 class="hover-title-top-left hover-hold categoriesName">Wildlife Safari</h5>
                            </a>
                        </header>
                        <div class="thumb-caption text-center">
                            <p class="thumb-desc"></p><a class="btn btn-default btn-ghost mt10" href="{{ url('comingSoon') }}">Exciting Wildlife Safari<i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="container">
                <div class="row row-wrap">
                    <!-- <div class="col-md-4">
                        <div class="thumb text-center">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="{{ url('comingSoon') }}">
                                    <img src="{{asset('assets/img/categories/birdSanctuary.jpg') }}" alt="Bird Sanctuary" title="Bird Sanctuary" />
                                    <h5 class="hover-title-top-left hover-hold categoriesName">Bird Sanctuaries</h5>
                                </a>
                            </header>
                            <div class="thumb-caption text-center">
                                <p class="thumb-desc"></p><a class="btn btn-default btn-ghost mt10" href="{{ url('comingSoon') }}">Explore Bird Sanctuaries<i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div> -->

                </div>
            <div class="gap gap-small"></div>

        </div>
    </div>
@endsection
