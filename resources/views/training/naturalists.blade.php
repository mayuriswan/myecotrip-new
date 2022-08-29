
@extends('layouts.app')

@section('title', 'Naturalists')

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
            <li><a href="{{url('/landscapes')}}">Naturalists</a>
            </li>
        </ul>
	    <h1 class="page-title pagetTitle">About Naturalists training</h1>

        <p class="pageDescription">
            Naturalists play a critical in ecotourism by interpreting nature and wildlife and act as a
bridge between the wildlife/biodiversity and the people who come to enjoy their time
amidst nature. Only if the Naturalists are properly trained, they can play an effective role in
delivering a delightful experience to such guests and therefore converting them into
ambassadors of conservation, which is the ultimate aim of ecotourism. These Naturalists
play the following important functions in ecotourism: 1.Act as Guides interpreting the
behaviour of wild animals and birds. 2.Provide an understanding of the importance of
wildlife and ecosystems. 3. They hold the key to the ’treasure chest’ of Nature. 4. Act as
eyes and ears of the forest department. 5. Convert the guests as ambassadors of
conservation. 7. Build public opinion in favour of conservation.
</p>
<p class="pageDescription">
It is important that such Naturalists are trained properly by professionals in the field and
this is where Karnataka Ecotourism Development Board can play an effective role. This
training programme is proposed to be in two phases, the first one being ten days and the
second one being a refresher of 3 days with an evaluation, within a gap of two months.
The 3 day second phase training can also be used to train and accredit existing Naturalists
in the industry.

        </p>
	</div>

	 <div class="container">
        <div class="row">

            <div class="col-md-12">
                <h3 class="mb20">Recent Naturalists training</h3>
                <hr>

                <div class="row row-wrap">
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
                                <img src="{{ asset('assets/img/training/5.jpg') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <!-- <div class="text-small">
                                        <h5>Chikmagalur Muthodi Prakruthi Shibira</h5>
                                        <p> 22-05-2019 to 26-05-2019</p>
                                        <p class="mb0">21 participants</p>
                                    </div> -->
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
