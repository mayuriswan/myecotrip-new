
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
            <li class="active">Jungle Stays
            </li>
        </ul>
	    <h1 class="page-title pagetTitle">About Jungle Stays</h1>

        <p class="pageDescription">Go out of your way, beyond what you know, finding your path, travelling that extra mile, discovering the untouched treasures of the nature. Novice or expert you shall always enjoy the challenge that a trek presents to you. Wander into the nature, live the places you have only dreamed of visiting after watching a documentary or reading a book. No inhibition, no deceit, discover yourself amidst an unknown trail.</p>
	</div>



	 <div class="container">
        <div class="row">
            <div class="col-md-3">
                <aside class="sidebar-left">
                    <form>
                        <div class="form-group form-group-icon-left">
                            <h4 class="sidebarHeading">Why Jungle Stays</h4>
                            <p class="sideBarDescription">Trekking is a fine group activity where adrenaline is articulate, where a lovely nature loving community thrives, where you make real friends and where miles are memories.</p>
                        </div>
                        <div class="form-group form-group-icon-left">
                            <!-- <h4 class="sidebarHeading">Jungle Stays</h4>
                            <p class="sideBarDescription">A beginner? A hardened trailblazer or somewhere in between? Pick your trail.</p>
                            <img class="trailsTypes" src="{{asset('assets/img/ecotrails/abt_h_m_s.png')}}"> -->
                        </div>
                    </form>
                </aside>
            </div>
            <div class="col-md-9">
                <h3 class="mb20">Popular Jungle Stays</h3>
                <hr>
                <div class="row row-wrap">
                    @foreach($data as $landscape)
                    <div class="col-md-4">
                        <div class="thumb">
                            <a class="hover-img" href="{{url('jungle-stays')}}/{{$landscape['id']}}/{{$landscape['seo_url']}}">
                                <img src="{{ asset($landscape['logo']) }}" alt="Image Alternative text" title="{{$landscape['name']}}" class="landscapeLogo" />
                                <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                    <div class="text-small">
                                        <h5>{{$landscape['name']}}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="gap"></div>
            </div>
        </div>
    </div>
@endsection
