<ul class="nav navbar-top-links navbar-right">
    @if(Session::has('userId'))
     <li class="top-user-area-avatar">
        <a href="#">
        Hi, {{Session::get('adminName')}}</a>
     </li>
     @endif
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
            </li>
            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
            </li> -->
            <!-- <li class="divider"></li> -->
            <li><a href="{{url('/')}}/circleAdmin"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->