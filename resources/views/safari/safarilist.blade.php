
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
        <h1 class="page-title pagetTitle">About Safari</h1>

        <p class="pageDescription">Safari in the natural forest is expedition to observe the free range wild animals in their natural habitat. The visitors in the secured safari vehicle are allowed inside the safari, will have the thrill of wilderness by seeing them in the midst of the forest through a keen and closed observation. The Bannerghatta Biological Park is one of the pioneers in providing this facility to the visiting public.</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <aside class="sidebar-left">
                    <form>
                        <div class="form-group form-group-icon-left">
                            <h4 class="sidebarHeading">Why Safari</h4>
                            <p class="sideBarDescription">Safari is an adventure ride that gives an the opportunity to explore the unexplored trails and un-ruined natural horizons of desert, country side, and not to forget, the forests. </p>
                        </div>
                    </form>
                </aside>
            </div>
            <div class="col-md-9">
                <h3 class="mb20">Popular Safari</h3>
                <div class="row row-wrap">
                    @foreach($safariList as $safari)
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{url('safariDetails')}}/{{$safari['id']}}/{{$safari['name']}}">
                                    <img src="{{ asset($safari['logo']) }}" alt="Image Alternative text" title="{{$safari['name']}}" class="landscapeLogo"/>
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>{{$safari['name']}}</h5>
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
