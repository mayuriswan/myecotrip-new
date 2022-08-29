@extends('beautymail::templates.ark')
@section('content')

	@include('beautymail::templates.ark.heading', [
	'heading' => 'Butterfly & Bee Festival 23rd Nov 2019',
	'level' => 'h1'
	])

	@include('beautymail::templates.ark.contentStart')

		<!-- <h4 class="secondary"><strong>Hello World</strong></h4> -->
		<p>
			Ever wondered how butterflies got their extravagant colored wings? Well, you could know even more. All you have to do is make sure to register for this beautiful butterfly and bee festival where you can watch, explore and learn about their species. Take a walk with nature and identify different species of butterflies, share interesting facts about them, educate one another on their life cycles and much more!
		</p>

		<p>
			We want you to cherish and connect with nature in all little and beautiful ways possible. Hop into Doresanipalya Forest Research Station, Arekere, Mico Layout on 23rd November 2019 and make sure you register with us to get the most of the festival.
		</p>

		<p>
			Maybe it’s time to see the world from the eyes of a butterfly- warm and free; Bright and colorful...
		</p>

	@include('beautymail::templates.ark.contentEnd')

	@include('beautymail::templates.ark.contentStart')
	
		@include('beautymail::templates.minty.button', [
	        	'text' => 'Click here to Book Now / To know more',
	        	'link' => 'https://bit.ly/3788I7b'
	    ])
	@include('beautymail::templates.ark.contentEnd')

@stop