
@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
     @include('layouts.Admin.circleAdmin.topNav')

    @include('layouts.Admin.circleAdmin.sideNav')
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
                        <select name="park" class="col-sm-3 form-control" required id="parksList">
                            <option value="">Select Park</option>
                            <option value="All">All</option>
                            @foreach($parkList as $id => $parkName)
                                <option value="{{$id}}">{{$parkName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3" id="circleTrails">
                        <select name="trail" class="col-sm-3 form-control" required id="circleTrails">
                            <option value="">Select Trails</option>
                        </select>
                    </div>
			   	 	<div class="col-sm-2">
		                <select id="selectMonth" name="selectMonth" class="form-control" required>
                            <option value="">Select Month</option>
                            <?php for ($i = 0; $i <= 12; ++$i) {
                                $time = strtotime(sprintf('-%d months', $i));
                                $value = date('Y-m', $time);
                                $label = date('F Y', $time);
                                printf('<option value="%s">%s</option>', $value, $label);
                            } ?>

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
      $('#parksList').change(function(e) {
        $( "#circleTrails" ).load( "parksTrailList/"+$('#parksList').val());
      });
   });
</script>

@endsection

