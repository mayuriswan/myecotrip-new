@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('sidebar')
   
@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
        <h1 class="page-title">Frequently Asked Questions  ???? </h1>
    </div>

    <div class="container">
        <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Why should you book a Trek/Eco trail online?</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <p>Any person entering the Forest needs to have a permit to do so. As long as the trekking trail involves passing through a forest area, procuring a permit is mandatory.</p>

                    <p>A trekker can approach the Karnataka Forest Department (KFD) to apply for a trekking permit which is a time-consuming and lengthy process. Or book a trekking permit online without any hassles at <a href="https://myecotrip.com" target="_blank" rel="noopener">https://myecotrip.com</a>.</p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">Why MyEcoTrip?</a>
                </h4>
            </div>
            <div id="collapseTen" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>MyEcoTrip is the brand created by KEDB with an intention to bring about all the tourism-related offerings in Karnataka on a single platform.</p>

                    <p>Currently, all the trekking agencies book their permits online through us. In fact, if you wish to apply for a trekking permit online, you'd have to do it through our site as we are the only ones offering this service online.</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen2">What does the trek cover?/ What does the (permit) fee cover? </a>
                </h4>
            </div>
            <div id="collapseTen2" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>When you make a booking with us for a particular trek, you’ll be granted a permit for the particular day you’ve opted for &amp; usually be accompanied with a well versed local guide to help you out.</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen3">How to book an Eco Trail at MyEcoTrip? </a>
                </h4>
            </div>
            <div id="collapseTen3" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Well, it’s quite simple really.</p>
                    <p>Step 1: Signup as a new user. Validate your email address and mobile number.</p>
                    <p>Step 2: Navigate to your desired trail. Login in, fill details and make the payment.</p>
                    <p>Step 3: Verify your eco trail confirmation on email and SMS.</p>
                    <p>Step 4: Go to the trekking location and present your eco trail confirmation email along with valid ID. Enjoy and Rejuvenate.</p>

                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen4">What if you don’t have a permit? </a>
                </h4>
            </div>
            <div id="collapseTen4" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Well, In that case, we’re sorry, you won’t be allowed for the trek. If you still go ahead and do it, you’re breaking the law !!</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen5">What if there aren’t any slots for a particular day? </a>
                </h4>
            </div>
            <div id="collapseTen5" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>We’re sorry! We have limited permits to be issued, Do check other treks being offered! It’s right here!</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen6">What does the booking exclude?</a>
                </h4>
            </div>
            <div id="collapseTen6" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>The booking only includes a valid permit for a particular day and a local guide for your trek. Everything else is NOT a part of the booking. Please note that this is NOT a full package to and from the city.</p>
                    <ul>
                        <li>Transport to and from the trekking location is not included.</li>
                        <li>NO food</li>
                        <li>NO water</li>
                        <li>Parking fees not included</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen7">How much does it cost?</a>
                </h4>
            </div>
            <div id="collapseTen7" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Prices start from Rs. 250 per person per permit. Check out our individual <u><a href="https://myecotrip.com/index.php/landscapes" target="_blank" rel="noopener">Eco trail pages</a></u> for more information.</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen8">What treks are available?</a>
                </h4>
            </div>
            <div id="collapseTen8" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>We have eco trails available around <u><a href="http://myecotrip.com/trails/1/Bangalore%20landscape" target="_blank" rel="noopener">Bangalore</a></u> at the moment. We are targeting to add more eco-trails in other regions pretty soon. Keep your eyes peeled on our social media pages -  <u><a href="https://twitter.com/myecotrip" target="_blank" rel="noopener">Twitter</a></u>, and <u><a href="https://www.instagram.com/myecotrip/" target="_blank" rel="noopener">Instagram</a></u> for updates.</p>

                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen9">What to do after a successful booking? </a>
                </h4>
            </div>
            <div id="collapseTen9" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>We’ll send you an Email and SMS confirmation after the booking. Take a print out of the email confirmation page and carry it with you while going on the trek along with a valid ID (PAN Card, Passport, Aadhar Card, or Voter’s Id). They will assign a local guide at the starting point of the trek. Happy trekking!</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen10"> What if your trek booking wasn’t successful?</a>
                </h4>
            </div>
            <div id="collapseTen10" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Oops. Sorry to hear that you couldn’t finish your booking. In that case, retry booking, or reach out to us at support@myecotrip.com if you still have concerns.</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen11"> Need to book for more than 30 people?</a>
                </h4>
            </div>
            <div id="collapseTen11" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Contact us at support@myecotrip.com for bulk bookings.</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen12">Additional information</a>
                </h4>
            </div>
            <div id="collapseTen12" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li>You can usually find a Parking near the starting point of your trek.</li>
                        <li>Be present at the starting point of the trek about 30 minutes before the reporting time.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen13">Things to carry</a>
                </h4>
            </div>
            <div id="collapseTen13" class="panel-collapse collapse">
                <div class="panel-body">
                    <p>Carry a backpack for your personal belongings, a bottle of water, a light jacket and wear trekking shoes. Also pack sunscreen, sunglasses, and a cap for convenience.</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen14">Do’s &amp; Don’ts</a>
                </h4>
            </div>
            <div id="collapseTen14" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li>Please keep the area clean. Strictly NO LITTER. Take only memories. Leave only footprints.</li>
                        <li>Don’t go on your own. Make sure you are always accompanied by a local guide.</li>
                        <li>Don’t make loud noises or play music when trekking. You are usually trekking in a restricted forest area. So make sure you respect your surroundings.</li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
@endsection
