
@extends('layouts.app')

@section('title', 'Volunteer')

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
            <li><a href="{{url('/landscapes')}}">Volunteer training</a>
            </li>
        </ul>
	    <h1 class="page-title pagetTitle">About Volunteer training</h1>

        <p class="pageDescription">Karnataka with one of the 32 biodiversity hot-spots in the world, the Western Ghats, five
Tiger Reserves and many more PA’s is uniquely endowed with rich bio-diversity which
includes the highest single population of Asiatic Elephants and one of the best populations
of Tigers in India. It was felt that the existing staff of the wildlife wing of KFD is not
equipped both in numbers and also in input to undertake a number of tasks beyond their
core focus of protection and administration. Therefore a ‘volunteer force’ was mooted
comprising of wildlife enthusiasts who are basically citizens of civil society but dedicated to
devote their time and energy to help the State of Karnataka to manage it’s rich biodiversity
in a better way.
</p>
<p class="pageDescription">
These Volunteers can be used for the following activities by the Park Managements: 1.
Monitoring bio-diversity including population surveys of Birds, Elephants and Tigers.
2.Enforcement including patrolling and intelligence gathering. 3. CSR initiatives including
fund-raising. 4. Crowd management at pilgrim centers and annual fairs. 5. Awareness
programmes with special focus on fire awareness. 6. Handholding in Conflict and crisis
management. 7. Training of field staff and other personnel.
</p>
<p class="pageDescription">
Thus the ‘Volunteer Force’ can ably assist various Park Managements in carrying out their
critical functions without compromising on their core focus of conservation and protection
of the biodiversity. These volunteers would be trained and certified by KEDB. It is
proposed that the selected volunteers (after due screening process) will go through a Two
phase training of 4 days each. The gap between the two phases of training should be at
least one month and a maximum of two months, which will itself play a role in ensuring
that only the serious ones would remain in contention.
</p>
	</div>

	 <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb20">Recent Volunteer training</h3>
                <hr>
                <div class="row row-wrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Sl. No</th>
                            <th>Training Place</th>
                            <th>Nos of Participation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="2">2013-14</td>
                            <td>1</td>
                            <td>Bandipur National Park 01.07.2013 to 25.07.2013 (4 groups)</td>
                            <td>152</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Anashi - Dandeli Tiger Protected Area and Bhimagada Wildlife Sanctuary 23.02.2014 to 08.03.2014 (2 groups)</td>
                            <td>66</td>
                        </tr>
                        <tr>
                            <td rowspan="2">2014-15</td>
                            <td>3</td>
                            <td>Bhagavathi of Kudremukh National Park 18.05.2014 to 25.05.2014</td>
                            <td>66</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Nagarhole National Park 03.12.2014 to 18.12.2014</td>
                            <td>88</td>
                        </tr>
                        <tr>
                            <td>2015-16</td>
                            <td>5</td>
                            <td>Bhadra Wildlife 14.11.2015 to 03.12.2015 (3 groups)</td>
                            <td>87</td>
                        </tr>
                        <tr>
                            <th class="text-right" colspan="3">Total</th>
                            <th>454</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="col-md-12">
                <h3 class="mb20">Gallery</h3>
                <hr>

                <div class="row row-wrap">
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img class="training-details-img" src="{{ asset('assets/img/training/volunteer/volunteer-1.jpeg') }}" alt="Image Alternative text" title="CB Pura" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>CB Pura</h5>
                                        <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p>
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
