
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
            <li><a href="{{url('/landscapes')}}">Nature guide training</a>
            </li>
        </ul>
	    <h1 class="page-title pagetTitle">About Nature guide training</h1>

        <p class="pageDescription">Nature guide training will be conducted by Karnataka Ecotourism Development Board. The objective of Nature guide training program is to
impart basic training to the local youths in the subjects of nature, wildlife and skills required got guiding tourists and to certify the trainees after completion of training so that they can be employed in Eco trails run by Karnataka Forest Department in regulated and controlled manner.
</p>
<p class="pageDescription">The Karnataka Ecotourism Development Board has so far conducted such training
program for more than 253 Certified Nature Guides. Generally, this Nature Guide training
Programme lasts for 5 Days for which the participants/trainees are selected by the
respective field officers. Participants come from various backgrounds that may include
forest watchers, those who are already working as trekking guides and those who are
manning interpretation centers. They participate both in the classroom sessions and in all
field activities as scheduled in the training program. The resource personnel guide the
trainees on various aspects such as Hazard evaluation, Risk management, Emergency
procedures, natural history through geology, basic information of birds, amphibians,
mammals, important tree species, climbers etc.</p>
	</div>

	 <div class="container">
        <div class="row training-details">

            <div class="col-md-12">
                <h3 class="mb20">Recent Nature guide training</h3>
                <hr>
                <div class="row row-wrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Year</th>
                                <th>Training Place</th>
                                <th>Nos of Participation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2014-15</td>
                                <td>Gopinatham Nature Camp</td>
                                <td>29</td>
                            </tr>
                            <tr>
                                <td rowspan="2">2</td>
                                <td rowspan="2">2016-17</td>
                                <td>Dubare Elephant Camp</td>
                                <td>26</td>
                            </tr>
                            <tr>
                                <td>LTM Eco Camp, Gerusoppa</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td rowspan="4">3</td>
                                <td rowspan="4">2017-18</td>
                                <td>Dubare Elephant Camp</td>
                                <td>24</td>
                            </tr>
                            <tr>
                                <td>Bannerghatta Nature Camp</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>July-2017</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>November</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>2018-19</td>
                                <td>M/s Discovery Village, Nandi Hills, Chikkaballapur</td>
                                <td>24</td>
                            </tr>
                            <tr>
                                <td rowspan="2">5</td>
                                <td rowspan="2">2019-20</td>
                                <td>Muthodi Nature Camp</td>
                                <td>21</td>
                            </tr>
                            <tr>
                                <td>Bannerghatta Nature Camp</td>
                                <td>36</td>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="3">Total</th>
                                <th>253</th>
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
                                <img class="training-details-img" src="{{ asset('assets/img/training/nature-guide/bannerghatta-training.jpeg') }}" alt="Image Alternative text" title="Bannerghatta" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Bannerghatta</h5>
                                        <p>2017-18</p>
                                        <p class="mb0">24 participants</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img class="training-details-img" src="{{ asset('assets/img/training/nature-guide/3.jpg') }}" alt="Image Alternative text" title="Bannerghatta" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Bannerghatta</h5>
                                        <p>2019-20</p>
                                        <p class="mb0">36 participants</p>
                                    </div>
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
