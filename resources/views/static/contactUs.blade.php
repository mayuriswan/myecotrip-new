@extends('layouts.app')

@section('title', 'Contact Us')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
        <h1 class="page-title">Contact Us</h1>
    </div>

    <div class="container">
		</div>

		<div class="container">
		   <div class="row">
		      <div class="col-md-7">
		      	@if(Session::has('contactMessage'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('contactMessage') }}</p>
                @endif
		         <!-- <p>Sodales laoreet mattis ut in nullam consequat turpis mus aenean mattis senectus mollis luctus ornare et at feugiat a habitasse hendrerit justo mollis penatibus cras blandit proin euismod nostra dignissim</p>
		         <p>Morbi sit mattis at ligula himenaeos ante morbi lacinia mattis varius vulputate ultricies habitant ipsum elit ultrices lorem diam orci</p> -->
		         <form class="mt30" action="contactUsMail" method="POST">
		            <div class="row">
		               <div class="col-md-6">
		                  <div class="form-group">
		                     <label>Name</label>
		                     <input class="form-control" name="name" type="text"  required />
		                  </div>
		               </div>
		               <div class="col-md-6">
		                  <div class="form-group">
		                     <label>E-mail</label>
		                     <input class="form-control" name="email" type="email"  required />
		                  </div>
		               </div>
		            </div>
		            <div class="form-group">
		               <label>Message</label>
		               <textarea class="form-control" name="message" required ></textarea>
		            </div>
		            <input class="btn btn-primary" style="background-color: #823c3a !important;" type="submit" value="Send Message" />
		         </form>
		      </div>
		      <div class="col-md-4">
		         <aside class="sidebar-right">
		            <ul class="address-list list">
		               <li>
		                  <h5>Email</h5>
		                  <a href="#">support@myecotrip.com</a>
		               </li>
		               <li>
		                  <h5>Phone Number</h5>
		                  <a href="#">+916363193770</a>
		               </li>
		               <!-- <li>
		                  <h5>Skype</h5>
		                  <a href="#">contact_traveller</a>
		               </li> -->
		               <li>
		                  <h5>Address</h5>
		                  <address>Karnataka Ecotourism Development board, 2nd floor, Vanavikas, room no. 202, 18th Cross, Malleshwaram, Bengaluru-560003</address>
		               </li>
		            </ul>
		         </aside>
		      </div>
		   </div>
		   <div class="gap"></div>

		   <div style="height:400px;">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887.3945186920123!2d77.56863615001264!3d13.010530190785346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae162d26211f51%3A0x2f972d143dd33fc8!2sAranya+Bhavan!5e0!3m2!1sen!2sin!4v1503004046625" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
@endsection
