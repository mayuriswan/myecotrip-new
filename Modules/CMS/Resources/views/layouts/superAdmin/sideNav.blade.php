 <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="#"><i class="fa fa-home fa-fw"></i> Jungle Stay<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/cms/jungle-stay/stays') }}">Jungle Stays</a>
                    </li>
                    <li>
                        <a href="{{ url('/cms/jungle-stay/entry') }}">Entry Fee</a>
                    </li>

                    <li>
                        <a href="{{ url('/cms/jungle-stay/parking') }}">Parking</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-street-view fa-fw"></i>Ecotrails<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('cms/ecotrails/landscape') }}"">Landscapes <i class="fa fa-globe" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('cms/ecotrails/trails') }}"">Trails <i class="fa fa-globe" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('cms/ecotrails/timeslot') }}">TimeSlots <i class="fa fa-clock-o" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('cms/ecotrails/pricing') }}">Pricing <i class="fa fa-money" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('cms/ecotrails/sa-trail-bookings') }}"">Bookings <i class="fa fa-ticket" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('cms/ecotrails/coming-soon') }}"">Coming soon <i class="fa fa-bullhorn" aria-hidden="true"></i></a>
                    </li>

                    <li>
                        <a href="{{ url('cms/ecotrails/report') }}"">Reports <i class="fa fa-download fa-fw"></i></a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
