@extends('beautymail::templates.ark')
@section('content')

	@include('beautymail::templates.ark.heading', [
	'heading' => 'Bird Festival 2020 - 17th, 18th and 19th of January',
	'level' => 'h1'
	])

	@include('beautymail::templates.ark.contentStart')

		<!-- <h4 class="secondary"><strong>Hello World</strong></h4> -->
		<p>
			Nandi never ceases to spring surprises to birdwatchers with more than 200 species of birds. From spotting unusual birds like Black Baza, Blue-headed rock thrush, white-throated ground thrush, Eurasian Blackbird, Pied thrush, Indian blue robin, Ultramarine Flycatcher, spotted babbler, Malabar Whistling Thrush, Niligiri woodpigeon and many species of migrant Warblers. Nandi is a paradise for birdwatchers. In this most sought-after bird watching destination, we want to share incredible knowledge and experiences on Birds. A flock of circling vultures is quite a familiar scene depicted in literature and motion pictures. It symbolizes the forthcoming danger or scary tales about to unfold in time. Well, is that all about them? We don’t think so. 
		</p>

		<p>
			Vultures are more than just that. They are often called nature’s clean-up crew as they play a vital role in the clean-up of the environment. They are an extremely important part of our ecosystem. Without them, we’ll be amidst foul-smelling carcasses that linger longer which would cause diseases. They are crucial to our ecosystem’s balance yet poached, poisoned and killed globally. 
		</p>

		<p>
			it’s valuable to educate people about the true nature of these vulnerable birds. In 2020, we want to tell you more about them on the 17th, 18th and 19th of January on the beautiful hill fortress – Nandi Hills. To New Beginnings because that’s what Bird festival represents…
		</p>

		<p>
			Breakfast, lunch, and dinner will be provided and keep posted for further itinerary updates …
		</p>

		<p>
			Maybe it’s time to see the world from the eyes of a butterfly- warm and free; Bright and colorful...
		</p>

	@include('beautymail::templates.ark.contentEnd')

	@include('beautymail::templates.ark.contentStart')
	
		@include('beautymail::templates.minty.button', [
	        	'text' => 'Click here to Book Now / To know more',
	        	'link' => 'https://bit.ly/2ZA2Eko'
	    ])
	@include('beautymail::templates.ark.contentEnd')

@stop