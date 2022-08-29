@extends('cms::layouts.app')

@section('title', '')

@section('navBar')
    @include('cms::layouts.superAdmin.topNav')

    @include('cms::layouts.superAdmin.sideNav')
@endsection

@section('content')
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Download</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <form action="downloadReport" method="POST">
        	<div class="row">
            <input type="hidden" name="requestFrom" value="circleAdmin">
        	<div class="container">
			   	<div class="row">
                    <div class="col-sm-3">
                        <select name="park" class="col-sm-3 form-control" required id="circleList">
                            <option value="">Select Circle</option>
                            <option value="All">All</option>
                            @foreach($circleList as $id => $circle)
                                <option value="{{$id}}">{{$circle}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-sm-3" id="circleParksDiv">
                        <select name="trail" class="col-sm-3 form-control" required id="parksList">
                            <option value="">Select Parks</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3" id="circleTrailsDiv">
                        <select name="trail" class="col-sm-3 form-control" required id="trails">
                            <option value="">Select Trails</option>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <select id="selectMonth" name="selectMonth" class="form-control" required>
                            <option value="">Select Month</option>
                            <?php 
                                for ($i = 0; $i <= 12; $i++) {
                                    $backend = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
                                    $view    = date("F Y", strtotime( date( 'Y-m-01' )." -$i months"));
                                    printf('<option value="%s">%s</option>', $backend, $view);
                                }

                            ?>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <select name="report_for" class="col-sm-3 form-control" required>
                            <option value="date_of_booking">Date of booking</option>
                            <option value="checkIn">Date of check in</option>
                        </select>
                    </div>
                    
			   	 	<div class="col-sm-2">
	                    <select name="type" class="col-sm-3 form-control" required>
	                    	<option value="">Select type</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
	                    </select>
	                </div>
			    </div>

                <br>
                <div class="row">
                    <div class='col-sm-4'>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Download</button>
                        </div>
                    </div>
                </div>

			</div>                
        </form>

    </div>
    <!-- /.container-fluid -->
</div>
    <!-- /#page-wrapper -->

<script type="text/javascript">
   $(function(){

      $('#circleList').change(function(e) {
        $( "#circleParksDiv" ).load( "{{url('/admin/')}}"+"/circlesParlList/"+$('#circleList').val());
      });

   });

</script>
@endsection
