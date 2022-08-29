@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
        <h1 class="page-title">Trainings</h1>
    </div>

    <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        <!-- <div class="sidebar-widget">
                            <div class="Form">
                                <input class="form-control" placeholder="Search..." type="text" />
                            </div>
                        </div> -->
                        <div class="sidebar-widget">
                            <h4>News</h4>
                            <ul class="icon-list list-category">
                                <li><a href="#"><i class="fa fa-angle-right"></i>Next Training of nature guide</a>
                                </li>

                                <li><a href="#"><i class="fa fa-angle-right"></i>A temporary stop for Bookings of Skandagiri trail</a>
                                </li>

                                

                                <!-- <li><a href="#"><i class="fa fa-angle-right"></i>Vacation <small >(85)</small></a>
                                </li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Flights <small >(93)</small></a>
                                </li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Travel Advices <small >(80)</small></a>
                                </li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Trending Now <small >(62)</small></a>
                                </li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Hotels <small >(73)</small></a>
                                </li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Places to Go <small >(78)</small></a>
                                </li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Travel Stories <small >(64)</small></a>
                                </li> -->
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="col-md-9">
                    <!-- START BLOG POST -->

                    <div class="article post">
                        <header class="post-header">
                            <a class="hover-img" href="#">
                                <img src="{{asset('assets/img/training/1.jpg') }}" alt="Image Alternative text" title="196_365" /><i class="fa fa-link box-icon-# hover-icon round"></i>
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Training 2019 - 20</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 22-05-2019 to 26-05-2019</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Chikmagalur muthodi prakruthi shibira with total count of 21 trainee</p>

                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 12-11-2019 to 16-11-2019</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Bannerghatta national park with total count of 36 trainee</p>

                            
                        </div>
                    </div>

                    <div class="article post">
                        <header class="post-header">
                            <a class="hover-img" href="#">
                                <img src="{{asset('assets/img/training/2.jpg') }}" alt="Image Alternative text" title="196_365" /><i class="fa fa-link box-icon-# hover-icon round"></i>
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Training 2018 - 19</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 23-07-2018 to 27-07-2018</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Discovery village Chikkaballapur with total count of 24 trainee</p>
                            
                        </div>
                    </div>

                    <div class="article post">
                        <header class="post-header">
                            <a class="hover-img" href="#">
                                <img src="{{asset('assets/img/training/3.jpg') }}" alt="Image Alternative text" title="196_365" /><i class="fa fa-link box-icon-# hover-icon round"></i>
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Training 2017 - 18</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 23-04-2017 to 27-04-2017</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Dhubri elephant camp with total count of 24 trainee</p>

                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 25-07-2017 to 28-07-2017</a>
                                </li>
                            </ul>
                            <p class="post-desciption">The training was conducted at Bannerghatta with total count of 31 trainee</p>

                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 07-11-2017 to 11-11-2017</a>
                                </li>
                            </ul>
                            <p class="post-desciption">The training was conducted at Bannerghatta with total count of 30 trainee</p>

                        </div>
                    </div>

                    <div class="article post">
                        <header class="post-header">
                            <a class="hover-img" href="#">
                                <img src="{{asset('assets/img/training/4.jpg') }}" alt="Image Alternative text" title="196_365" /><i class="fa fa-link box-icon-# hover-icon round"></i>
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Training 2016 - 17</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 23-10-2016 to 27-10-2016</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Dhubri elephant camp with total count of 26 trainee</p>

                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 24-10-2016 to 28-10-2016</a>
                                </li>
                            </ul>
                            <p class="post-desciption">The training was conducted at Gerusoppa ltm eco camp with total count of 32 trainee</p>
                        </div>
                    </div>

                    <div class="article post">
                        <header class="post-header">
                            <a class="hover-img" href="#">
                                {{-- <img src="{{asset('assets/img/training-news/IMG_20191116_143505.jpg') }}" alt="Image Alternative text" title="196_365" /><i class="fa fa-link box-icon-# hover-icon round"></i> --}}
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Training 2015 - 16</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 14-11-2015 to 03-12-2015</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Bhadra vanyajeevi Muthodi with total count of 87 trainee</p>

                            
                        </div>
                    </div>


                    <div class="article post">
                        <header class="post-header">
                            <a class="hover-img" href="#">
                                {{-- <img src="{{asset('assets/img/training-news/IMG_20191116_143505.jpg') }}" alt="Image Alternative text" title="196_365" /><i class="fa fa-link box-icon-# hover-icon round"></i> --}}
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Training 2014 - 15</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 18-05-2014 to 25-05-2014</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Kudremukh national park with total count of 83 trainee</p>

                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 03-12-2014 to 18-12-2014</a>
                                </li>
                            </ul>
                            <p class="post-desciption">The training was conducted at Nagarhole national park with total count of 83 trainee</p>
                        </div>
                    </div>

                    <div class="article post">
                        <header class="post-header">
                            <a class="hover-img" href="#">
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Training 2013 - 14</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 01-07-2013 to 25-07-2013</a>
                                </li>
                                
                            </ul>
                            <p class="post-desciption">The training was conducted at Bandipur National Park with total count of 152 trainee</p>

                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> 23-02-2014 to 08-03-2014</a>
                                </li>
                            </ul>
                            <p class="post-desciption">The training was conducted at Anshi dandeli tiger reserve with total count of 66 trainee</p>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>

        <div class="gap"></div>
@endsection
