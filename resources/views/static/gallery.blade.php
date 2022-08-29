@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
            <h1 class="page-title">Gallery</h1>
        </div>

        <div class="container">
            <div id="popup-gallery">
                <div class="row row-col-gap">
                    <div class="col-md-4">
                        <a class="hover-img popup-gallery-image" href="{{asset('assets/img/gallery/gallery1.jpg')}}" data-effect="mfp-zoom-out">
                            <img src="{{asset('assets/img/gallery/gallery1.jpg')}}" class="galleryImage" alt="" title="" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="hover-img popup-gallery-image" href="{{asset('assets/img/gallery/gallery2.jpg')}}" data-effect="mfp-zoom-out">
                            <img src="{{asset('assets/img/gallery/gallery2.jpg')}}" class="galleryImage" alt="" title="" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a class="hover-img popup-gallery-image" href="{{asset('assets/img/gallery/gallery3.jpg')}}" data-effect="mfp-zoom-out">
                            <img src="{{asset('assets/img/gallery/gallery3.jpg')}}" class="galleryImage" alt="" title="" /><i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


@endsection
