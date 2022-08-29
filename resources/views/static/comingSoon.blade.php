@extends('layouts.app')

@section('title', '')

@section('sidebar')
   
@endsection

@section('content')

<!-- Header -->
@include('layouts.header')

<style type="text/css">
	h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: 'Merriweather';
  font-weight: 700;
}


video {
  position: fixed;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  transform: translateX(-50%) translateY(-50%);
  z-index: -1;
}

@media (pointer: coarse) and (hover: none) {
  body {
    background: url("../img/bg-mobile-fallback.jpg") #002E66 no-repeat center center scroll;
    background-position: cover;
  }
  body video {
    display: none;
  }
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: #cd9557;
  opacity: 0.7;
  z-index: 1;
}

.masthead {
  position: relative;
  overflow: hidden;
  padding-bottom: 3rem;
  z-index: 2;
}

.masthead .masthead-bg {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  width: 100%;
  min-height: 35rem;
  height: 100%;
  background-color: rgba(0, 46, 102, 0.8);
  transform: skewY(4deg);
  transform-origin: bottom right;
}

.masthead .masthead-content h1 {
  font-size: 2.5rem;
}

.masthead .masthead-content p {
  font-size: 1.2rem;
}

.masthead .masthead-content p strong {
  font-weight: 700;
}

.masthead .masthead-content .input-group-newsletter input {
  font-size: 1rem;
  padding: 1rem;
}

.masthead .masthead-content .input-group-newsletter button {
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 1rem;
}

@media (min-width: 768px) {
  .masthead {
    height: 100%;
    min-height: 0;
    width: 40.5rem;
    padding-bottom: 0;
  }
  .masthead .masthead-bg {
    min-height: 0;
    transform: skewX(-8deg);
    transform-origin: top right;
  }
  .masthead .masthead-content {
    padding-left: 3rem;
    padding-right: 10rem;
  }
  .masthead .masthead-content h1 {
    font-size: 3.5rem;
  }
  .masthead .masthead-content p {
    font-size: 1.3rem;
  }
}

.social-icons {
  position: absolute;
  margin-bottom: 2rem;
  width: 100%;
  z-index: 2;
}

.social-icons ul {
  margin-top: 2rem;
  width: 100%;
  text-align: center;
}

.social-icons ul > li {
  margin-left: 1rem;
  margin-right: 1rem;
  display: inline-block;
}

.social-icons ul > li > a {
  display: block;
  color: white;
  background-color: rgba(0, 46, 102, 0.8);
  border-radius: 100%;
  font-size: 2rem;
  line-height: 4rem;
  height: 4rem;
  width: 4rem;
}

@media (min-width: 768px) {
  .social-icons {
    margin: 0;
    position: absolute;
    right: 2.5rem;
    bottom: 2rem;
    width: auto;
  }
  .social-icons ul {
    margin-top: 0;
    width: auto;
  }
  .social-icons ul > li {
    display: block;
    margin-left: 0;
    margin-right: 0;
    margin-bottom: 2rem;
  }
  .social-icons ul > li:last-child {
    margin-bottom: 0;
  }
  .social-icons ul > li > a {
    transition: all 0.2s ease-in-out;
    font-size: 2rem;
    line-height: 4rem;
    height: 4rem;
    width: 4rem;
  }
  .social-icons ul > li > a:hover {
    background-color: #002E66;
  }
}

.btn-secondary {
  background-color: #cd9557;
  border-color: #cd9557;
}

.btn-secondary:active, .btn-secondary:focus, .btn-secondary:hover {
  background-color: #ba7c37 !important;
  border-color: #ba7c37 !important;
}

.input {
  font-weight: 300 !important;
}
</style> 

<div class="container">
   	<div class="row">
   		<video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
	      <source src="{{asset('assets/videos/') }}/comingsoon.mp4" type="video/mp4">
	    </video>

   		<div class="masthead">
	      <div class="container h-100">
	        <div class="row h-100">
	          <div class="col-12 my-auto">
	            <div class="masthead-content text-white py-5 py-md-0">
	              <h1 class="mb-3" style="margin-top: 10%;">Coming Soon!</h1>	              
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

   	</div>
   <div class="gap"></div>
</div>
@endsection
