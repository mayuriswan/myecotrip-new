@extends('layouts.app')

@section('title', 'Trail Details')
@section('sidebar')
@endsection
@section('content')
    <!-- Header -->
    @include('layouts.header')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a>
            </li>
            <li><a href="{{url('/landscapes')}}">Landscapes</a>
            </li>
            <li><a href="{{Session::get('trailsList')}}">{{Session::get('trailsListName')}}</a>
            </li>
            <li class="active">{{$trailDetail['name']}}</li>
        </ul>

        <div class="booking-item-details">
            <header class="booking-item-header">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="lh1em">{{$trailDetail['name']}}</h2>
                        <ul class="list list-inline text-small">
                            <li><i class="fa fa-map-marker"></i> {{$trailDetail['range']}}, Karnataka</li>
                            @if (count($trailDetail['incharger_details']) > 0)
                                <li><i class="fa fa-user"></i>&nbsp;{{ $trailDetail['incharger_details'][0] }}
                                </li>
                            @endif
                            @if (count($trailDetail['incharger_details']) > 2)
                                <li><i class="fa fa-phone"></i>&nbsp; {{ $trailDetail['incharger_details'][2] }} </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </header>

            @if($trailDetail['id'] == 3)
            <!-- <div class="row">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <strong><i class="fa fa-smile-o"></i> Great News !!</strong> <marquee><p style="font-weight: 700; font-size: 18pt">Slots for Weekends and Government Holidays have been increased to 150 !! Hurry up !! Book it soon and have a great trail.</p></marquee>
                </div>
            </div> -->

            @endif

            <div class="row">
                <div class="col-md-7">
                    <div class="tabbable booking-details-tabbable">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
                            </li>
                            <li><a href="#google-map-tab" data-toggle="tab"><i class="fa fa-map-marker"></i>On the Map</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-1">
                                <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                                    @foreach($trailDetail['trailImages'] as $trekImage)
                                        @if($trekImage['s3_upload'])
                                            <img src="{{$trekImage['name']}}" alt="Trail Image"/>
                                        @else
                                            <img src="{{asset($trekImage['name'])}}" alt="Trail image"/>
                                        @endif
                                    <!-- <img src="{{asset('/assets/img/trails/5/15030077950.JPG')}}" alt="Image Alternative text" title="hotel PORTO BAY RIO INTERNACIONAL de luxe" /> -->
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="google-map-tab">
                                <div style="width:100%; height:500px;">
                                    {!! $trailDetail['map_url'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5" id="bookHere">
                    <div class="booking-item-meta">
                        @if ($trailDetail['status'] != 0)
                            <div>
                                <h4>@if(Session::has('userId')) Hey {{ucwords(Session::get('userName'))}},
                                    @else
                                        Hey Guest,
                                    @endif when do you plan to Hike?
                                </h4>
                            </div>
                            @if(Session::has('userId'))
                                <div class="booking-item-dates-change">
                                    <form action="../../checkAvailability/{{$trailId}}/{{$trailDetail['name']}}" method="POST">

                                        <!-- <div class="input-daterange" data-date-format="yyyy-mm-dd DD"> -->
                                        <div class="input-daterange2" data-date-format="yyyy-mm-dd">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-icon-left showPointer"><i class="fa fa-calendar input-icon"></i>
                                                        <label>Check in</label>
                                                        <input class="form-control showPointer" id="start" name="start" type="text" autocomplete="off" placeholder="YYYY-MM-DD" title="Check in date [YYYY-MM-DD] Ex: 2019-01-24" pattern="\d{4}-\d{2}-\d{2}" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-icon-left showPointer">
                                                        <label>Reporting time</label>
                                                        <select name="timeslot" class="form-control" required>
                                                            <option value="">Select start time</option>
                                                            @foreach ($timeslots as $timeSlot)
                                                                <option value="{{$timeSlot['timeslot_id']}}||{{$timeSlot['timeslots']}}">{{$timeSlot['timeslots']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-md-12" id="trekkersAlert">
                                                    <label style="color: red; display:none "><b>Please select number of trekkers</b></label>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group- form-group-select-plus">
                                                        <label>Adults</label>
                                                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                                            <label class="btn btn-primary active">
                                                                <input type="radio" name="noOfTrekkers" value="0" checked />0</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfTrekkers" value="1"/>1</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfTrekkers" value="2"/>2</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfTrekkers" value="3"/>3</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfTrekkers" value="4"/>4</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfTrekkers" value="4+"/>4+</label>
                                                        </div>
                                                        <select name="noOfTrekkers2" class="form-control hidden">
                                                            @for ($i = 0; $i < 41; $i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group- form-group-select-plus">
                                                        <label>Children [Age 8 - 12]</label>
                                                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                                            <label class="btn btn-primary active">
                                                                <input type="radio" name="noOfChildren" value="0" checked />0</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfChildren" value="1"/>1</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfChildren" value="2"/>2</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfChildren" value="3"/>3</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfChildren" value="4"/>4</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfChildren" value="4+"/>4+</label>
                                                        </div>
                                                        <select name="noOfChildren2" class="form-control hidden">
                                                            @for ($i = 0; $i < 41; $i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group- form-group-select-plus">
                                                        <label>Student [Age 13 - 18]</label>
                                                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                                            <label class="btn btn-primary active">
                                                                <input type="radio" name="noOfStudents" value="0" checked />0</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfStudents" value="1"/>1</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfStudents" value="2"/>2</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfStudents" value="3"/>3</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfStudents" value="4"/>4</label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="noOfStudents" value="4+"/>4+</label>
                                                        </div>
                                                        <select name="noOfStudents2" class="form-control hidden">
                                                            @for ($i = 0; $i < 41; $i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="gap gap-small" title="Check Availability">
                                                        <button type="submit" class="btn btn-primary btn-lg">Check Availability</button>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                @if(Session::has('valMessage'))
                                                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('valMessage') }}</p>
                                                @endif
                                            </div>
                                            <div class="row">
                                                @if(Session::has('verifyMessage'))
                                                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('verifyMessage') }} <a href="{{URL('/')}}/userProfile">Verify Now</a></p>

                                                @endif
                                            </div>

                                        </div>

                                    </form>
                                </div>
                            @else
                                <div class="col-md-12 btn booking-item-dates-change" id="openLoginModal" onclick="openLoginModal()">
                                    <b style="color: #e44f28">Please login to book {{$trailDetail['name']}} trek</b>
                                </div>
                                <br>
                                <br>
                            @endif

                        </div>
                    @endif
                    <div class="booking-item-meta">
                        <br>
                        <h4>Trek Info</h4>
                    </div>
                    <div class="booking-item-dates-change">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Starting point
                            </div>
                            <div class="col-md-6 col-sm-6">
                                {{$trailDetail['starting_point']}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Ends point
                            </div>
                            <div class="col-md-6 col-sm-6">
                                {{$trailDetail['ending_point']}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Trekking distance
                            </div>
                            <div class="col-md-6 col-sm-6">
                                {{$trailDetail['distance']}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Reporting time
                            </div>
                            <div class="col-md-6 col-sm-6">
                                06:00 AM to 09:30 AM
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Trekking duration
                            </div>
                            <div class="col-md-6 col-sm-6">
                                {{$trailDetail['hours']}} Hrs {{$trailDetail['minutes']}} Mins
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                Trekking Type
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <img class="hardIcon" src="{{asset('assets/img/ecotrails')}}/{{$trailDetail['type']}}.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div>
                    <h3>About {{$trailDetail['name']}}</h3>
                    {!! $trailDetail['description'] !!}
                </div>
            </div>
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-6">
                    <h5>Fill the form below for bulk booking</h5>
                    @if(Session::has('contactMessage'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }} signUpAlert">{{ Session::get('contactMessage') }}</p>
                    @endif
                    <form action="{{url('/')}}/ticketRequest" method="POST">
                        <input type="hidden" name="trailName" value="{{$trailDetail['name']}}">
                        <div class="col-md-12">
                          <div class="form-group">
                             <label>Name</label>
                             <input class="form-control" name="name" type="text"  required placeholder="Enter your good name" />
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                             <label>E-mail</label>
                             <input class="form-control" name="email" type="email"  required placeholder="Enter your email" />
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                             <label>Phone no.</label>
                             <input class="form-control" name="phone_no" placeholder="+911234567890" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" type="tel" required/>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                             <label>Number of ticket required</label>
                             <input class="form-control" name="number_of_tickets" placeholder="Minimum number of tickets is 30" type="number" min="30" required/>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                             <label>Other info</label>
                             <textarea class="form-control" name="details" required ></textarea>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                             <div class="g-recaptcha" name="captcha" data-sitekey="6Lcz24IUAAAAAESSofZ03DoKdlOsffLC8w7NlNz_"></div>
                          </div>
                        </div>


                        <div class="col-md-3 col-md-offset-9">
                          <div class="form-group">
                            <button class="form-group btn-primary" type="submit">Send Request</button>
                          </div>
                        </div>
                    </form>


                    <!-- <div class="gap gap-small"></div> -->
                </div>
                <div class="col-md-6">
                    <h5>Availability Calander</h5>

                    <div id='wrap' style="border:1px #ed8323 solid;">

                    <div id='calendar'></div>

                    <div style='clear:both'></div>

                </div>
            </div>

            <div class="row col-md-6">
                <div id='wrap'>

                <div id='calendar'></div>

                <div style='clear:both'></div>
            </div>
        </div>
    </div>
    <div class="gap gap-small"></div>
    </div>

@endsection

@section('script')
    <script>

    $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        /*  className colors

        className: default(transparent), important(red), chill(pink), success(green), info(blue)

        */


        /* initialize the external events
        -----------------------------------------------------------------*/

        $('#external-events div.external-event').each(function() {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });


        /* initialize the calendar
        -----------------------------------------------------------------*/

        var calendar =  $('#calendar').fullCalendar({
            header: {
                left: 'title',
                // center: 'agendaDay,agendaWeek,month',
                right: 'prev,next today'
            },
            editable: false,
            firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
            selectable: true,
            defaultView: 'month',

            axisFormat: 'h:mm',
            columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
            allDaySlot: false,
            selectHelper: true,
            select: function(start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    calendar.fullCalendar('renderEvent',
                        {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        },
                        true // make the event "stick"
                    );
                }
                calendar.fullCalendar('unselect');
            },
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function(date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }

            },

            events: [

                @foreach($calendarData['maxList'] as $date => $maxTrekkers)
                    @if(isset($calendarData['bookedList'][$date]) && $maxTrekkers - $calendarData['bookedList'][$date] >= 0)
                        {
                            title: "{{$maxTrekkers - $calendarData['bookedList'][$date]}}",
                            start: new Date("{{$date}}"),
                            end: new Date("{{$date}}"),
                            allDay: false,
                            className: 'fastBooking'
                        },
                    @else

                        {
                            title: "{{$maxTrekkers}}",
                            start: new Date("{{$date}}"),
                            end: new Date("{{$date}}"),
                            allDay: false,
                            className: 'fastBooking'
                        },

                    @endif



                @endforeach
                // {
                //     title: 'All Day Event',
                //     start: new Date(y, m, 1)
                // },
                // {
                //     id: 999,
                //     title: 'Repeating Event',
                //     start: new Date(y, m, d-3, 16, 0),
                //     allDay: false,
                //     className: 'info'
                // },
                // {
                //     id: 999,
                //     title: 'Repeating Event',
                //     start: new Date(y, m, d+4, 16, 0),
                //     allDay: false,
                //     className: 'info'
                // },
                // {
                //     title: 'Meeting',
                //     start: new Date(y, m, d, 10, 30),
                //     allDay: false,
                //     className: 'important'
                // },
                // {
                //     title: '20 / 40',
                //     start: new Date(y, m, d, 12, 0),
                //     end: new Date(y, m, d, 14, 0),
                //     allDay: false,
                //     className: 'fastBooking'
                // },
                // {
                //     title: '20 / 40',
                //     start: new Date(y, m, d + 1, 12, 0),
                //     end: new Date(y, m, d + 1, 14, 0),
                //     allDay: false,
                //     className: 'fastBooking'
                // }
                // ,
                // {
                //     title: 'Birthday Party',
                //     start: new Date('2019-12-22'),
                //     end: new Date(y, m, d+1, 22, 30),
                //     allDay: false,
                //     className: 'booked'
                // }
                // ,
                // {
                //     title: 'Click for Google',
                //     start: new Date(y, m, 28),
                //     end: new Date(y, m, 29),
                //     url: 'https://ccp.cloudaccess.net/aff.php?aff=5188',
                //     className: 'success'
                // }
            ],
        });

calendar.setOption('height', 700);


    });

</script>
@endsection
