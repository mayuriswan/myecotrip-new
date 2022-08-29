
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
            <li><a href="{{url('/landscapes')}}">Nature Conservation Education Programme</a>
            </li>
        </ul>
	    <h1 class="page-title pagetTitle">About Nature Conservation Education Programme</h1>

        <p class="pageDescription">
            Western Ghats is one of the worlds’ “biodiversity hotspots”. It constitutes two per cent  of the Indian land mass but supports 20-25 per cent of biodiversity of entire country. About 60 per cent of the Western Ghats area falls in Karnataka.
        </p>
        <p class="pageDescription">
            The landmark order from Supreme Court in 2003 on making environmental education compulsory at all levels from primary to higher education level triggered the intensification of environmental education in India. Today, environmental education has become an integral part of the school curriculum. The school text books has more of environmental concepts related to natural resources, forests, wildlife, ecosystems, conservation and so on. The flagship programme of the country “Sarva Shikha Abhiyan” SSA also emphasizes on the need for increasing teachers’ competency and develops child centric teaching learning material to improve quality education in schools with a focus on clean green school.

        </p>
        <p class="pageDescription">
            Further, we all know the importance of nature that we live in and the consequences of its degradation. There is an urgent need to effectively spread the message of importance of nature and its need for conservation to halt the environmental catastrophe. Sensitizing school children, youths and the local community on these issues is essential. The nature education programmes are one of the tools whereby teachers and students can be sensitized on these concepts by being in the forest areas through hands on activities. Such programmes help them to improve their understanding about nature, natural resources, forest, wildlife etc.

        </p>
        <p class="pageDescription">
            Though environmental education is integrated into to the school curriculum, students learn these concepts within the four walls without exploring in the field. Teachers and Students often never get an opportunity to learn the environmental concepts visiting to forest areas. The elite schools do make an attempt to take their students to protected areas to understand nature through wilderness exploration which rural students are devoid of it.

        </p>

        <h4>Nature Conservation Education Programme for rural schools and Colleges– A Need</h4>
        <p class="pageDescription">
            Rural school teachers and students are devoid of such nature related educational programs and more particularly who reside on the fringe areas of the forest though they being very close to forest and wildlife. Nature educational programs are required for these students and teachers for the following reasons:
            <ol>
                <li class="pageDescription">They are integral part of the nearby forest ecosystems and are associated with its issues and concern such as forest fire, man animal conflicts etc.</li>
                <li class="pageDescription">Unlike the urban school students they cannot afford to pay and visit the forest areas to camp and learn more about the nature, forest, wildlife and recreation</li>
                <li class="pageDescription">Forest, wildlife, conservation and nature related topics are taught as part of their curriculum but never get an opportunity explore the nearby forest wildlife areas</li>
                <li class="pageDescription">Nature education programmes would not only help rural students to learn and know more about nature, forest and wildlife but they start owning it and strive for its protection.</li>
                <li class="pageDescription">Kendirya Vidyalaya (KV) Sangathan, New Delhi provides an opportunity for their KV students to explore nature through their nature adventure activities across the country at free of cost. Our rural schools are deprived of such an opportunity to come close to the nature.</li>
                <li class="pageDescription">The protected areas and other areas are envisaged to create awareness among school students on forest and wildlife conservation. These areas can provide such nature educational opportunity for rural students.</li>
            </ol>
        </p>

        <h4>The key objectives of this programme include:</h4>
        <ol>
            <li class="pageDescription">Improve the understandings among school students and teachers on the importance and conservation of environment, forest, wildlife and natural resources.</li>
            <li class="pageDescription">Introduce students and teachers to the rich biodiversity of protected areas with a focus on the key stone species found in the area.</li>
            <li class="pageDescription">Enhance skill based learning among students and teachers on nature and wildlife conservation</li>
            <li class="pageDescription">Demonstrate hands on activities on nature and wildlife conservation to teachers and students linking to their curriculum.</li>
            <li class="pageDescription">Make students experience the wilderness and motivate them to protect nature.</li>
            <li class="pageDescription">Motivate teachers on implementing nature conservation related activities in schools involving students.</li>
        </ol>

        <h4>Expected outcomes </h4>
        <p class="pageDescription">The expected outcomes from the nature education programme are</p>
        <ol>
            <li class="pageDescription">Teachers and students are sensitized about forest, wildlife, nature and the need for conservation.</li>
            <li class="pageDescription">Minimum of 5 nature related activities are executed in schools and 5 research cum action projects related to nature, forest and wildlife are executed.</li>
            <li class="pageDescription">Atleast additional 10 native plants species are planted and nurtured in schools by the students and teachers.</li>
            <li class="pageDescription">Knowledge among teachers and students on forest and wildlife is enhanced and are able to identify at least 20 trees, 20 birds, 20 insects and 10 reptiles.</li>
            <li class="pageDescription">Teachers and students are aware of the role and importance of forest and wildlife in the ecosystem and are inspired to help the Forest Department in protecting them.</li>
        </ol>

	 <div class="container">
        <div class="row training-details">

            <div class="col-md-12">
                <h3 class="mb20">Recent Nature Education</h3>
                <hr>
                <div class="row row-wrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Year</th>
                                <th>Training Place</th>
                                <th>Nos of Students</th>
                                <th>Nos of Teachers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2013-14</td>
                                <td>Kaveri Wildlife Sanctuary</td>
                                <td>420</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <td rowspan="2">2</td>
                                <td rowspan="2">2014-15</td>
                                <td>Bannerghatta National Park</td>
                                <td>120</td>
                                <td>40</td>
                            </tr>
                            <tr>
                                <td>Kaveri Wildlife Sanctuary</td>
                                <td>650</td>
                                <td>34</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>2015-16</td>
                                <td>Honnavar</td>
                                <td>693</td>
                                <td>28</td>
                            </tr>

                            <tr>
                                <td rowspan="2">5</td>
                                <td rowspan="2">2017-18</td>
                                <td>Bandipur National Park</td>
                                <td>200</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td>BR Hills</td>
                                <td>200</td>
                                <td>20</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>2018-19</td>
                                <td>Honnavar</td>
                                <td>1000</td>
                                <td>80</td>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="3">Total</th>
                                <th>3,283</th>
                                <th>302</th>
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
                                <img class="training-details-img" src="{{ asset('assets/img/training/NCEP/1.jpg') }}" alt="Image Alternative text" title="Bannerghatta" />
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
                                <img class="training-details-img" src="{{ asset('assets/img/training/NCEP/2.jpg') }}" alt="Image Alternative text" title="Bannerghatta" />
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
                                <img class="training-details-img" src="{{ asset('assets/img/training/NCEP/3.jpg') }}" alt="Image Alternative text" title="Bannerghatta" />
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
