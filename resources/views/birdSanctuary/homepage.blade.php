
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
        <h1 class="page-title pagetTitle">About Bird Sanctuary</h1>

        <p class="pageDescription">Ranganathittu is a bird sanctuary that can be visited throughout the year by bird lovers. Easily accessible from Bangalore, enroute to Mysore, visiting this place is a great option for both children and adults. Visit early in the morning and hire a boat. November heralds in the winter migrants who stay put until March, adding to the already numerous varieties of birds you can see here.</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <aside class="sidebar-left">
                    <form>
                        <div class="form-group form-group-icon-left">
                            <h4 class="sidebarHeading">Why Bird Sanctuary</h4>
                            <p class="sideBarDescription">Ranger-guided boat tours of the isles are available throughout the day, and are a good way to watch birds, crocodiles, otters and bats. there are so many crocodiles resting on rocks and island parts, and lookes just like rock. There is no lodging at the tiny sanctuary, so visitors typically have to stay over at Mysore or Srirangapatna. The seasons for visiting the park are: June–November (during the nesting season of the water birds). The best time to watch migratory birds is usually December but it can vary year to year.</p>
                        </div>
                    </form>
                </aside>
            </div>
            <div class="col-md-9">
                <h3 class="mb20">Popular Bird Sanctuary</h3>
                <div class="row row-wrap">
                    @foreach($birdSanctuaryList as $birdSanctuary)
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{url('birdSanctuaryDetails')}}/{{$birdSanctuary['id']}}/{{$birdSanctuary['name']}}">
                                    <img src="{{ asset($birdSanctuary['logo']) }}" alt="Image Alternative text" title="{{$birdSanctuary['name']}}" class="landscapeLogo"/>
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>{{$birdSanctuary['name']}}</h5>
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
