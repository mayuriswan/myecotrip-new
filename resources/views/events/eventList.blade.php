
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
        <h1 class="page-title pagetTitle">About Myecotrip Events</h1>

        <p class="pageDescription">KFD in association in with various Government and other NGO’s organize and celebrate different festivals/events .This platform enables one to register as a delegate and be a part of the cultural extravaganza. Follow this tab to know more about the upcoming fests/events and also to learn and relive the events that were organized priorly.</p>
    </div>

    <div class="container">
        @if(count($eventList))
        <div class="row">

            <div class="col-md-9">
                <h3 class="mb20">Active Events</h3>
                <div class="row row-wrap">
                    @foreach($eventList as $event)
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{url('eventDetails')}}/{{$event['id']}}/{{$event['event_id']}}/{{str_replace(' ','_',$event['name'])}}">
                                    <img src="{{ asset($event['logo']) }}" alt="Event logo" title="{{$event['name']}}" class="landscapeLogo"/>
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>{{$event['name']}}</h5>
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
        @endif
        @if(count($previousList))
        <div class="row">

            <div class="col-md-9">
                <h3 class="mb20">Previous Events</h3>
                <div class="row row-wrap">
                    @foreach($previousList as $event)
                        <div class="col-md-4">
                            <div class="thumb">
                                <a class="hover-img" href="{{url('eventDetails')}}/{{$event['id']}}/{{$event['event_id']}}/{{str_replace(' ','_',$event['name'])}}">
                                    <img src="{{ asset($event['logo']) }}" alt="Event logo" title="{{$event['name']}}" class="landscapeLogo"/>
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>{{$event['name']}}</h5>
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
        @endif
    </div>
@endsection
