
@extends('layouts.app')

@section('title', 'Capacity building training')

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
            <li><a href="{{url('/landscapes')}}">Capacity building training</a>
            </li>
        </ul>
	    <h1 class="page-title pagetTitle"></h1>

        <p class="pageDescription">Capacity building (or capacity development) is the process by which individuals and organizations obtain, improve, and retain the skills, knowledge, tools, equipment, and other resources needed to do their jobs competently. It allows individuals and organizations to perform at a greater capacity (larger scale, larger audience, larger impact, etc). "Capacity building" and "Capacity development" are often used interchangeably. This term indexes a series of initiatives from the 1950s in which the active participation of local communities’ members in social and economic development was encouraged via national and subnational plans.</p>

	</div>

	 <div class="container">
        <div class="row">

            <div class="col-md-12">
                <h3 class="mb20">Recent Capacity building training</h3>
                <hr>

                <div class="row row-wrap">
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img class="training-details-img" src="{{ asset('assets/img/training/capacity-building-training/1.jpg') }}" alt="Image Alternative text" title="CB Pura" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Ranganathittu</h5>
                                        <!-- <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p> -->
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/training/1.jpg') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Chikmagalur Muthodi Prakruthi Shibira</h5>
                                        <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/training/1.jpg') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Chikmagalur Muthodi Prakruthi Shibira</h5>
                                        <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/training/1.jpg') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Chikmagalur Muthodi Prakruthi Shibira</h5>
                                        <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/training/1.jpg') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Chikmagalur Muthodi Prakruthi Shibira</h5>
                                        <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/training/1.jpg') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Chikmagalur Muthodi Prakruthi Shibira</h5>
                                        <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> -->

                </div>
                <div class="gap"></div>
            </div>
        </div>
    </div>
@endsection
