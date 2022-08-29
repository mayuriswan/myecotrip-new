 <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <!-- <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
            </li> -->
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Masters<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/circles') }}"">Circles</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/parks') }}"">Parks</a>
                    </li>
                    
                    <li>
                        <a href="{{ url('admin/timeslots') }}">TimeSlots</a>
                    </li>
                    
                    
                     <li>
                        <a href="{{ url('admin/bannerImages') }}">Banner Images</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>  

            <li>
                <a href="#"><i class="fa fa-user fa-fw"></i> Admins<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/myAdmins') }}"">Myecotrip Admins</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/circleAdmins') }}"">Circle Admins</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/parkAdmins') }}"">Park Admins</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/trailAdmins') }}"">Trail Admins</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/agents') }}"">Agents</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="#"><i class="fa fa-street-view fa-fw"></i>Ecotrails<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/landscape') }}"">Landscapes <i class="fa fa-globe" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('admin/ecotrailTimeslots') }}">TimeSlots <i class="fa fa-clock-o" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('admin/getTrialPricing') }}">Pricing <i class="fa fa-money" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('admin/SAtrailBookings') }}"">Bookings <i class="fa fa-ticket" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('admin/trailUpcoming') }}"">Coming soon <i class="fa fa-bullhorn" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('admin/trailBookingReports') }}"">Reports <i class="fa fa-download fa-fw"></i></a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-bus fa-fw"></i> Transportations<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/transportationTypes') }}">Types</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-truck fa-fw"></i> Safari<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/safari') }}">Details</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/safariVehicles') }}">Vehicles</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/safariTimeslotsTransportationtype') }}">Trans-TimeSlot-Vehicles Mapping</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/safariEntryFee') }}">Entry Fee</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/safariTransportationPrice') }}">Transportation Price</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/safariBookings') }}">Bookings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-tree fa-fw"></i> Jungle Stay<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/jungleStayLandscapes') }}">Landscapes</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/jungleStay') }}">Details</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/jungleStayRooms') }}">Rooms</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/jungleStayRoomsPrice') }}">Rooms Price</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/jungleStayBookings') }}">Bookings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-twitter"></i> Bird Sanctuary<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/birdSanctuary') }}">Details</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/birdSanctuaryList/entryFee') }}">Entry Fee</a>
                    </li>
                    <!-- <li>
                        <a href="{{ url('admin/boatType') }}">Boat Types</a>
                    </li> -->
                    <li>
                        <a href="{{ url('admin/birdSanctuaryList') }}">Boat Types Price</a>
                    </li>
                    <li>
                        <a href="#">Parking<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ url('admin/parkingType') }}">Parking Type</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/parkingVehicleType') }}">Vehicle Type</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/birdSanctuaryList/parkingFee') }}">Parking Fee</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Camera<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{ url('admin/cameraType') }}">Camera Type</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/birdSanctuaryList/cameraFee') }}">Camera Fee</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('admin/BStimeslots') }}">Time Slots</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/BStimeslotsMapping') }}">Bird Sanctuary Time Slots Mapping</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/birdSanctuaryBookings') }}">Bookings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-twitter"></i> Birds Fest<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/birdsFest') }}">Details</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/addEventPricing') }}">Pricings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-download fa-fw"></i> Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    
                    <li>
                        <a href="{{ url('admin/birdSanctuaryBookingReports') }}"">Bird Sanctuary</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/birdFestBookingReports') }}"">Bird Fest</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>