
@extends('layouts.app')

@section('title', 'Nature Guide')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    @if(Session::has('TranErrMessage'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }} homeAlert">{{ Session::get('TranErrMessage') }}</p>
    @endif

	<div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a>
            </li>
            <li><a href="{{url('/landscapes')}}">Corporate Social Responsibility</a>
            </li>
        </ul>
	    <h1 class="page-title pagetTitle">About Corporate Social Responsibility</h1>

        <p class="pageDescription">
            The State of Karnataka is endowed with rich bio-diversity. Forests cover about 40,000 sq. km., which amounts to 20% of the land area of the State. We have 5 Tiger Reserves, 5 National Parks, 30 Wildlife Sanctuaries and 12 Conservation Reserves. The Western Ghats region is one of our richest forest areas, the source of over 10 major rivers, and also one of the 32 bio-diversity hotspots of the world. Forests render a variety of eco-system services like sources of fresh water, oxygen, carbon sequestration, sources of medicinal plants, and shelter for birds and wild animals
        </p>

        <p class="pageDescription">
            Karnataka is home to more than 400 Tigers, the highest in India, which is about 20% of the total population in the country, and 10% of the global population. We also have about 6,000 Asian Elephants, which is about 25% of the total population. This is because of the successful conservation management and strategy followed by the Karnataka Forest Department.

        </p>

        <p class="pageDescription">
            Despite our successful conservation efforts, the Karnataka Forest Department (KFD) faces severe challenges when it comes to protection and conservation of these precious natural resources. Ironically, our conservation success has been marred by increased wildlife-human conflicts in recent times.

        </p>

        <p class="pageDescription">
            We are fortunate to have many big corporates based in the State. The law now mandates that a portion of the revenues of these corporates be spent on Corporate Social Responsibility (CSR). Support to our natural eco-systems would easily fit into any corporate CSR strategy, because all businesses are only sustained by ensuring good climate, air and water. We would like to appeal to such corporate, including you, to lend their support in protecting our precious forests and wildlife resources under CSR. This would give you the right connect to the environment and also a sense of ownership of our natural resources. This will also contribute to the mitigation of climate change, which the world is facing in recent years.

        </p>

        <p class="pageDescription">
            The Karnataka Forest Department, in association with the Karnataka Ecotourism Development Board, is place to organizing a Workshop on Corporate Social Responsibility shortly, to present before you the details of the conservation issues facing the State, and the areas where you can step in to support under CSR.

        </p>

        <p class="pageDescription">
            We take this opportunity to invite your top management to this workshop, so that we may spend some quality time with you, and together plan a way forward. We request you to kindly give a time to meet and explain the Karnataka Ecotourism Development Board activities.

        </p>


	 <div class="container">
        <div class="row training-details">

            <div class="col-md-12">
                <h3 class="mb20">Recent Workshop on Corporate Social Responsibility</h3>
                <hr>
                <div class="row row-wrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Place</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2014-15</td>
                                <td>June 06</td>
                                <td>Bengaluru, M/s lLlit Ashok Hotel</td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>2014-15</td>
                                <td>May 01 to 03</td>
                                <td>Bandipur Tiger Reserve</td>
                            </tr>


                            <tr>
                                <td>3</td>
                                <td>2017-18</td>
                                <td>April 04</td>
                                <td>Bengaluru, M/s Radission Blu Atria</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col-md-12">
                <h3 class="mb20">Gallery</h3>
                <hr>

                <div class="row row-wrap">
                    <!-- <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img class="training-details-img" src="{{ asset('assets/img/training/nature-guide/ranganathittu-training.jpeg') }}" alt="Image Alternative text" title="Ranganathittu" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Ranganathittu</h5>
                                        <p>2019-20</p>
                                        <p class="mb0">36 participants</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> -->

                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img class="training-details-img" src="{{ asset('assets/img/training/CSR/1.jpg') }}" alt="Image Alternative text" title="Bannerghatta" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <!-- <div class="text-small">
                                        <h5>Bannerghatta</h5>
                                        <p>2017-18</p>
                                        <p class="mb0">24 participants</p>
                                    </div> -->
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img class="training-details-img" src="{{ asset('assets/img/training/CSR/2.jpg') }}" alt="Image Alternative text" title="Bannerghatta" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <!-- <div class="text-small">
                                        <h5>Bannerghatta</h5>
                                        <p>2017-18</p>
                                        <p class="mb0">24 participants</p>
                                    </div> -->
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img class="training-details-img" src="{{ asset('assets/img/training/CSR/3.jpg') }}" alt="Image Alternative text" title="Bannerghatta" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <!-- <div class="text-small">
                                        <h5>Bannerghatta</h5>
                                        <p>2017-18</p>
                                        <p class="mb0">24 participants</p>
                                    </div> -->
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="gap"></div>
            </div>
        </div>
    </div>
@endsection
