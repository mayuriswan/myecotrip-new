 <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ url('admin/trailBookings') }}">Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Offline Booking<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/oflineTrailBookings') }}"">Bookings</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/offlineTrailBookNow') }}"">Book now</a>
                    </li>                    
                </ul>
                <!-- /.nav-second-level -->
            </li> 
            <li>
                <a href="{{ url('admin/TAbookingReports') }}"><i class="fa fa-download fa-fw"></i> Reports<span class="fa arrow"></span></a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-nav-collapse -->
</div>