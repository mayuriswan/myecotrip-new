
@extends('layouts.app')

@section('title', '')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <form action="filteredTrails" id="filterForm" method="POST">
        <input type="hidden" name="fromNumber" id="fromNumber">
        <input type="hidden" name="toNumber" id="toNumber">
        <input type="hidden" name="landscapeName" id="landscapeName" value="{{$landscapelist['name']}}">
        <input type="hidden" name="landscapeId" id="landscapeId" value="{{$landscapelist['id']}}">


    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a>
            <li><a href="{{url('/landscapes')}}">Landscapes</a>
            </li>

            <li class="active">{{$landscapelist['name']}}</li>
        </ul>

        <h3 class="booking-title">{{count($trailslist)}} trails for {{$landscapelist['name']}}</h3>
        <div class="row">
            <div class="col-md-3">
                <aside class="booking-filters booking-filters-white">
                    <h3>Filter By: <span class="clearFilter"><a href="../../trails/{{$landscapelist['id']}}/{{$landscapelist['seo_url']}}">clear filters</a></span></h3>

                    <ul class="list booking-filters-list">
                        <li>
                            <h5 class="booking-filters-title">Price</h5>
                            <input type="hidden" id="price-slider">
                        </li>
                        <li>
                            <h5 class="booking-filters-title">Trek distance</h5>
                            <div class="checkbox">
                                <label>
                                    @if (isset($filters['trekDistance']))
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="0-2" onclick="handleClick(this)" @if ($filters['trekDistance'] == "0-2") checked @endif/>0 - 2 Kms and Below
                                    @else
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="0-2" onclick="handleClick(this)" />0 - 2 Kms and Below
                                    @endif
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    @if (isset($filters['trekDistance']))
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="2-3" onclick="handleClick(this)" @if ($filters['trekDistance'] == "2-3") checked @endif/>2 - 3 Kms and Below
                                    @else
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="2-3" onclick="handleClick(this)" />2 - 3 Kms and Below
                                    @endif
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    @if (isset($filters['trekDistance']))
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="0-4" onclick="handleClick(this)" @if ($filters['trekDistance'] == "0-4") checked @endif/>4 Kms and Below
                                    @else
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="0-4" onclick="handleClick(this)" />3 - 4 Kms and Below
                                    @endif
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    @if (isset($filters['trekDistance']))
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="any" onclick="handleClick(this)" @if ($filters['trekDistance'] == 'any') checked @endif/>4 Kms and Above
                                    @else
                                        <input name="trekDistance" type="radio" class="filterCheckbox" value="any" onclick="handleClick(this)" />4 Kms and Above
                                    @endif
                                </label>
                            </div>
                        </li>
                        <li>
                            <h5 class="booking-filters-title">Trekking time</h5>
                            <div class="checkbox">
                                <label>
                                    @if (isset($filters['trekTime']))
                                        <input name="trekTime" type="radio" class="filterCheckbox" value="2" onclick="handleClick(this)" @if ($filters['trekTime'] == '2') checked @endif/>2 Hrs and Below
                                    @else
                                        <input name="trekTime" value="2" type="radio" class="filterCheckbox" onclick="handleClick(this)" />2 Hrs and Below
                                    @endif
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    @if (isset($filters['trekTime']))
                                        <input name="trekTime" type="radio" class="filterCheckbox" value="3" onclick="handleClick(this)" @if ($filters['trekTime'] == '3') checked @endif/>3 Hrs and Below
                                    @else
                                        <input name="trekTime" value="3" type="radio" class="filterCheckbox" onclick="handleClick(this)" />3 Hrs and Below
                                    @endif
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    @if (isset($filters['trekTime']))
                                        <input name="trekTime" type="radio" class="filterCheckbox" value="any" onclick="handleClick(this)" @if ($filters['trekTime'] == 'any') checked @endif/>3 Hrs and Above
                                    @else
                                        <input name="trekTime" value="any" type="radio" class="filterCheckbox" onclick="handleClick(this)" />3 Hrs and Above
                                    @endif

                                </label>
                            </div>
                        </li>
                    </ul>
                </aside>
            </div>

        </form>
            <div class="col-md-9">
                <!-- <div class="nav-drop booking-sort">
                    <h5 class="booking-sort-title"><a href="#">Sort: Aviability<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                    <ul class="nav-drop-menu">
                        <li><a href="#">Price (low to high)</a>
                        </li>
                        <li><a href="#">Price (hight to low)</a>
                        </li>
                        <li><a href="#">Ranking</a>
                        </li>
                        <li><a href="#">Distance</a>
                        </li>
                        <li><a href="#">Number of Reviews</a>
                        </li>
                    </ul>
                </div> -->
                <ul class="booking-list">
                    @if(count($trailslist))
                	@foreach ($trailslist as $index => $trail)
                		<li>
	                        <a class="booking-item" href="{{url('/')}}/trailDetail/{{$trail['id']}}/{{$trail['seo_url']}}">
	                            <div class="row">
	                                <div class="col-md-3">
	                                    <div class="booking-item-img-wrap">
	                                        <img src="{{asset($trail['logo'])}}" alt="Image Alternative text" title="Savanadurga Trail" />
	                                        <!-- <div class="booking-item-img-num"><i class="fa fa-picture-o"></i>12</div> -->
	                                    </div>
	                                </div>
	                                <div class="col-md-6">

	                                     <h5 class="booking-item-title trekName"><img class="trekkingIcon" src="{{asset('assets/img/ecotrails/trekking-icon.png')}}">&nbsp; {{$trail['name']}}</h5>
	                                    <p class="booking-item-address"><i class="fa fa-users"></i> {{$trail['max_trekkers']}} / trek &nbsp;<i class="fa fa-road"></i> {{$trail['distance']}} Kms&nbsp;&nbsp;<i class="fa fa-clock-o"></i> {{$trail['hours']}} Hrs {{$trail['minutes']}} Mins&nbsp;&nbsp; <img class="hardIcon" src="{{asset('assets/img/ecotrails')}}/{{$trail['type']}}.png"></p>

                                        <section>

                                            {!! substr(strip_tags($trail['description']),0,340); !!} ....

                                        </section>

	                                </div>
	                                <div class="col-md-3">
                                        <span class="booking-item-price-from">from</span><span class="booking-item-price">&#8377; {{$trail['display_price']}}</span><span>/trekker</span>
                                        <span class="btn btn-primary">Book now</span>
	                                </div>
	                            </div>
	                        </a>
	                    </li>
                	@endforeach
                    @else
                        <h4 class="alert-danger" style="text-align: center;">Sorry !! We could not find any trails</h4>
                    @endif


                <!-- <div class="row">
                    <div class="col-md-6">
                        <p><small>521 hotels found in New York. &nbsp;&nbsp;Showing 1 – 15</small>
                        </p>
                        <ul class="pagination">
                            <li class="active"><a href="#">1</a>
                            </li>
                            <li><a href="#">2</a>
                            </li>
                            <li><a href="#">3</a>
                            </li>
                            <li><a href="#">4</a>
                            </li>
                            <li><a href="#">5</a>
                            </li>
                            <li><a href="#">6</a>
                            </li>
                            <li><a href="#">7</a>
                            </li>
                            <li class="dots">...</li>
                            <li><a href="#">43</a>
                            </li>
                            <li class="next"><a href="#">Next Page</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-right">
                        <p>Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                        </p>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="gap"></div>
    </div>

<script type="text/javascript">

function handleClick(cb) {
  $("#filterForm").submit();
}

function trailDetail(trailId, trailName) {
    window.location = "../../trailDetail/"+trailId+'/'+trailName;
}
</script>
@endsection
