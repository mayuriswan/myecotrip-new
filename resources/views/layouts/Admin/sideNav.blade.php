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
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Masters<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/circles') }}"">Circles</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/parks') }}"">Parks</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/landscape') }}"">Landscapes</a>
                    </li>                    
                </ul>
                <!-- /.nav-second-level -->
            </li>  

            <li>
                <a href="#"><i class="fa fa-user fa-fw"></i> Admins<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('admin/trailAdmins') }}"">Trail Admins</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>