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
                                <img src="{{asset('assets/img/training-news/IMG_20191116_143505.jpg') }}" alt="Image Alternative text" title="196_365" /><i class="fa fa-link box-icon-# hover-icon round"></i>
                            </a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#"> Bird Fest 2020</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#"> January 21, 2020</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#"> Admin</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Travel</a>, <a href="#">Bird Fest</a>, <a href="#">Bird Watch</a>
                                </li>
                                <!-- <li><i class="fa fa-comments"></i><a href="#">10 Comments</a>
                                </li> -->
                            </ul>
                            <p class="post-desciption">The Karnataka Bird festival 2020 was organised by the Karnataka Forest Department, Karnataka Eco Tourism Development Board and the Jungle Lodges and Resorts. The program was inaugurated by dignitaries, which was followed by presentations and sight seeing tours around the Nandi hills</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <!-- START BLOG POST -->
                    <div class="article post">
                        <header class="post-header">
                            <!-- <blockquote>Lacinia molestie quis torquent nisl taciti magnis urna sed mollis magna suscipit tellus metus fusce imperdiet cubilia eu conubia quam</blockquote> -->
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Quoute Post Type</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#">09 October, 2014</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#">Joe Smith</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Digital</a>, <a href="#">Typography</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="#">18 Comments</a>
                                </li>
                            </ul>
                            <p class="post-desciption">Lorem sapien libero parturient dis metus interdum fermentum curae laoreet nibh lorem posuere ac class feugiat placerat dis massa nisi lacus luctus ultricies mattis sapien sit varius risus consectetur porta parturient nullam elementum at parturient quisque mattis interdum aliquam ipsum ridiculus phasellus imperdiet facilisis hendrerit hac sed odio cubilia interdum</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <!-- START BLOG POST -->
                    <div class="article post">
                        <header class="post-header">
                            <div class="fotorama" data-allowfullscreen="true">
                                <img src="img/196_365_1200x500.jpg" alt="Image Alternative text" title="196_365" />
                                <img src="img/196_365_1200x500.jpg" alt="Image Alternative text" title="196_365" />
                                <img src="img/196_365_1200x500.jpg" alt="Image Alternative text" title="196_365" />
                            </div>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Slider Post Type</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#">23 September, 2014</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#">Joseph Watson</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Design</a>, <a href="#">Web</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="#">14 Comments</a>
                                </li>
                            </ul>
                            <p class="post-desciption">Parturient nascetur sem vulputate ullamcorper leo rhoncus aptent etiam dictumst dictumst cum sociis vulputate tristique elementum diam nisl est sapien inceptos eget consequat sagittis class neque sem placerat hac tincidunt diam libero sagittis suspendisse nascetur nascetur lorem pretium semper viverra ac dis etiam dictumst maecenas magnis sapien cras magnis fusce</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <!-- START BLOG POST -->
                    <div class="article post">
                        <header class="post-header"><a class="post-link" href="#">Google.com</a>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Link Post Type</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#">27 August, 2014</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#">Ava McDonald</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Web</a>, <a href="#">Digital</a>, <a href="#">Typography</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="#">8 Comments</a>
                                </li>
                            </ul>
                            <p class="post-desciption">Metus placerat eros mollis vestibulum in fames hac quam mattis ipsum odio potenti vulputate dictumst augue dis feugiat potenti ullamcorper amet lobortis netus suscipit nisi tincidunt turpis consequat posuere mus est lacus potenti varius quis ac ligula accumsan vestibulum nam euismod eleifend a fermentum amet neque leo a auctor metus</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <!-- START BLOG POST -->
                    <div class="article post">
                        <header class="post-header">
                            <iframe src="http://www.youtube.com/embed/6iHwPfirtUg" frameborder="0" allowfullscreen></iframe>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Youtube Post Type</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#">30 June, 2014</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#">Sarah Slater</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Web</a>, <a href="#">Travel</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="#">3 Comments</a>
                                </li>
                            </ul>
                            <p class="post-desciption">Libero nisi rhoncus libero pharetra ac justo blandit sociosqu elementum consequat lorem mollis adipiscing duis augue tellus nascetur mus tellus lacus nibh luctus faucibus fames fermentum sociis iaculis class lobortis vel molestie tincidunt enim platea quis etiam inceptos imperdiet malesuada hendrerit consectetur tincidunt quam pulvinar convallis molestie venenatis magna pellentesque</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <!-- START BLOG POST -->
                    <div class="article post">
                        <header class="post-header">
                            <iframe src="http://player.vimeo.com/video/103721959" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Vimeo Post Type</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#">10 March, 2014</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#">Alison Mackenzie</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Digital</a>, <a href="#">Travel</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="#">7 Comments</a>
                                </li>
                            </ul>
                            <p class="post-desciption">Curae egestas imperdiet consequat diam tincidunt congue semper consequat pharetra elementum laoreet fusce ante tempor dictumst penatibus viverra non scelerisque ligula vel montes magna morbi ultrices eros vitae euismod habitant suspendisse lobortis mauris duis urna porta neque volutpat natoque tempus feugiat nunc iaculis primis blandit nulla lacus lobortis praesent ullamcorper</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <!-- START BLOG POST -->
                    <div class="article post">
                        <header class="post-header">
                            <iframe width="100%" height="150" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/150793348&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=false"></iframe>
                        </header>
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Audio Post Type</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#">07 August, 2013</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#">John Doe</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Typography</a>, <a href="#">Lifestyle</a>, <a href="#">Travel</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="#">1 Comments</a>
                                </li>
                            </ul>
                            <p class="post-desciption">Leo porttitor aenean tristique duis hac potenti netus etiam felis montes elementum pretium risus himenaeos senectus cras luctus mi semper nullam nullam suspendisse diam ridiculus vehicula praesent id pharetra parturient varius inceptos ultricies lobortis tellus platea nulla non habitasse eleifend habitasse scelerisque proin magnis duis elit suscipit lectus sed phasellus</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <!-- START BLOG POST -->
                    <div class="article post">
                        <div class="post-inner">
                            <h4 class="post-title"><a class="text-darken" href="#">Default Post Type</a></h4>
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i><a href="#">19 May, 2012</a>
                                </li>
                                <li><i class="fa fa-user"></i><a href="#">Dylan Taylor</a>
                                </li>
                                <li><i class="fa fa-tags"></i><a href="#">Digital</a>, <a href="#">Web</a>, <a href="#">Travel</a>
                                </li>
                                <li><i class="fa fa-comments"></i><a href="#">1 Comments</a>
                                </li>
                            </ul>
                            <p class="post-desciption">Vestibulum cubilia diam tempor tortor egestas per penatibus sollicitudin ornare ipsum fusce penatibus id accumsan nullam platea torquent morbi proin rhoncus curabitur nullam imperdiet elementum nunc fringilla sed velit facilisis est posuere erat nostra mauris faucibus vivamus mus phasellus fringilla luctus netus sodales vulputate netus placerat nostra accumsan penatibus fames</p><a class="btn btn-small btn-primary" href="#">Read More</a>
                        </div>
                    </div>
                    <!-- END BLOG POST -->
                    <ul class="pagination">
                        <li class="active"><a href="#">1</a>
                        </li>
                        <li><a href="#">2</a>
                        </li>
                        <li><a href="#">3</a>
                        </li>
                        <li><a href="#">4</a>
                        </li>
                        <li><a href="#">5</a>
                        </li>
                        <li><a href="#">6</a>
                        </li>
                        <li><a href="#">7</a>
                        </li>
                        <li class="dots">...</li>
                        <li><a href="#">43</a>
                        </li>
                        <li class="next"><a href="#">Next Page</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="gap"></div>
@endsection
