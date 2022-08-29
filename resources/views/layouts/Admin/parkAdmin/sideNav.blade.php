 <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
                <!-- /input-group -->
            </li>
           

            <li>
                <a href="#"><i class="fa fa-list-alt fa-fw"></i> Bookings<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('parkAdmin/parkBookings') }}"">Trails</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{ url('parkAdmin/PAbookingReports') }}"><i class="fa fa-download fa-fw"></i> Reports<span class="fa arrow"></span></a>
            </li>      
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>