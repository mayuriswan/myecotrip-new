
@extends('layouts.app')

@section('title', '')

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
            <li><a href="{{url('/landscapes')}}">Landscapes</a>
            </li>
        </ul>
	    <h1 class="page-title pagetTitle">About Ecotrails</h1>

        <p class="pageDescription">Go out of your way, beyond what you know, finding your path, travelling that extra mile, discovering the untouched treasures of the nature. Novice or expert you shall always enjoy the challenge that a trek presents to you. Wander into the nature, live the places you have only dreamed of visiting after watching a documentary or reading a book. No inhibition, no deceit, discover yourself amidst an unknown trail.</p>
	</div>

	 <div class="container">
        <div class="row">
            <div class="col-md-3">
                <aside class="sidebar-left">
                    <form>
                        <div class="form-group form-group-icon-left">
                            <h4 class="sidebarHeading">Why trek</h4>
                            <p class="sideBarDescription">Trekking is a fine group activity where adrenaline is articulate, where a lovely nature loving community thrives, where you make real friends and where miles are memories.</p>
                        </div>
                        <div class="form-group form-group-icon-left">
                            <h4 class="sidebarHeading">Trails</h4>
                            <p class="sideBarDescription">A beginner? A hardened trailblazer or somewhere in between? Pick your trail.</p>
                            <img class="trailsTypes" src="{{asset('assets/img/ecotrails/abt_h_m_s.png')}}">
                        </div>
                    </form>
                </aside>
            </div>
            <div class="col-md-9">
                <h3 class="mb20">Popular Ecotrails</h3>
                <hr>
                <div class="row row-wrap">
                    @foreach($landscapeList as $landscape)
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="{{url('trails')}}/{{$landscape['id']}}/{{$landscape['seo_url']}}">
                                <img src="{{ asset($landscape['logo']) }}" alt="Image Alternative text" title="{{$landscape['name']}}" class="landscapeLogo" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>{{$landscape['name']}}</h5>
                                        @if ($landscape['trailCount'] > 0) <p class="mb0">{{$landscape['trailCount']}} trails</p> @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if (count($trailList) > 0)
                <!-- Upcoming -->
                <h3 class="mb20">Upcoming Ecotrails</h3>
                <hr>
                <div class="row row-wrap">
                    @foreach ($trailList as $upcomings)
                        <div class="trailUpcoming">
                            <h4>{{$upcomings['name']}}</h4>
                            <p>{{$upcomings['shortDesc']}}</p>
                        </div>
                    @endforeach 
                </div>
                @endif
                <!-- <h3 class="mb20">Upcoming Ecotrails</h3>
                <div class="row row-wrap">
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/upper_lake_in_new_york_central_park_800x600.jpg') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Atlantic City Hotels</h5>
                                        <p>72698 reviews</p>
                                        <p class="mb0">692 offers from $84</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/new_york_at_an_angle_800x600.jpg') }}" alt="Image Alternative text" title="new york at an angle" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Boston</h5>
                                        <p>60464 reviews</p>
                                        <p class="mb0">512 offers from $91</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/sydney_harbour_800x600.jpg') }}" alt="Image Alternative text" title="Sydney Harbour" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Sydney Hotels</h5>
                                        <p>64140 reviews</p>
                                        <p class="mb0">796 offers from $63</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/lack_of_blue_depresses_me_800x600.jpg') }}" alt="Image Alternative text" title="lack of blue depresses me" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Miami Hotels</h5>
                                        <p>54941 reviews</p>
                                        <p class="mb0">424 offers from $78</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/the_best_mode_of_transport_here_in_maldives_800x600.jpg') }}" alt="Image Alternative text" title="the best mode of transport here in maldives" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Virginia Beach Hotels</h5>
                                        <p>65086 reviews</p>
                                        <p class="mb0">509 offers from $83</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/waipio_valley_800x600.jpg') }}" alt="Image Alternative text" title="waipio valley" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Sydney Hotels</h5>
                                        <p>56566 reviews</p>
                                        <p class="mb0">524 offers from $56</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/el_inevitable_paso_del_tiempo_800x600.jpg') }}" alt="Image Alternative text" title="El inevitable paso del tiempo" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Budapest</h5>
                                        <p>56595 reviews</p>
                                        <p class="mb0">897 offers from $55</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="#">
                                <img src="{{ asset('assets/img/viva_las_vegas_800x600.jpg') }}" alt="Image Alternative text" title="Viva Las Vegas" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>Las Vegas</h5>
                                        <p>69630 reviews</p>
                                        <p class="mb0">966 offers from $74</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div> -->
                <div class="gap"></div>
            </div>
        </div>
    </div>
@endsection
