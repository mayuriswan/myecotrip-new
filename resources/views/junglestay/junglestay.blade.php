
@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')
    <div class="container">
        <div class="row">
            <h3 class="booking-title">{{count($staylist)}} trails for {{$landscapeName}}</h3>
            <br>
            {{--<div class="col-md-3"></div>--}}
            <div class="col-md-12">
                <ul class="booking-list">
                	@foreach ($staylist as $index => $stay)
                		<li>
	                        <a class="booking-item" href="{{url('/')}}/junglestayDetail/{{$stay['id']}}/{{$stay['name']}}">
	                            <div class="row">
	                                <div class="col-md-3">
	                                    <div class="booking-item-img-wrap">
	                                        <img src="{{asset($stay['logo'])}}" alt="Image Alternative text" title="{{$stay['name']}}" />
	                                    </div>
	                                </div>
                                    <div class="col-md-6">
                                        <h5 class="booking-item-title trekName"><img style="width: 40px;height: 40px;!important;" class="trekkingIcon" src="{{asset('assets/img/jungleStay/stay-icon.png')}}">&nbsp; <strong>{{$stay['name']}}</strong></h5>
                                        <div class="booking-item-last-booked">{!! substr($stay['description'],0 , 340) !!} ....</div>
                                    </div>
	                                <div class="col-md-3">
                                        <div class="booking-item-last-booked">{!! substr($stay['meta_desc'],0 , 340) !!}</div>
                                        <div class="booking-item-last-booked">{!! substr($stay['keywords'],0 , 340) !!}</div>
                                        <br>
                                        <span onclick="junglestayDetail({{$stay['id']}},'{{$stay['name']}}')" class="btn btn-primary">Book now</span>
	                                </div>
	                            </div>
	                        </a>
	                    </li>
                	@endforeach
            </div>
        </div>
        <div class="gap"></div>
    </div>

<script type="text/javascript">
    
function handleClick(cb) {
  $("#filterForm").submit();
}

function junglestayDetail(stayId, stayName) {
    window.location = "../../junglestayDetail/"+stayId+'/'+stayName;
}
</script>
@endsection
