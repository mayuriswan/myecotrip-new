@extends('birdsanctuary::layouts.master')

@section('title', 'Bird Sanctuary Admin')

@section('navBar')
    @include('birdsanctuary::layouts.topNav')
    @include('birdsanctuary::layouts.sideNav')
@endsection

@section('content')

    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Download Monthly Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <form action="{{url('/')}}/bs-admin/booking_report" method="POST">
        	<div class="row">
            <input type="hidden" name="requestFrom" value="circleAdmin">
        	<div class="container">
			   	<div class="row">
                    <div class="col-sm-4">
                        <select id="selectMonth" name="selectMonth" class="form-control" required>
                            <option value="">Select Month</option>
                            <?php for ($i = 0; $i <= 6; ++$i) {
                                $time = strtotime(sprintf('-%d months', $i));
                                $value = date('Y-m', $time);
                                $label = date('F Y', $time);
                                printf('<option value="%s">%s</option>', $value, $label);
                            } ?>

                        </select>
                    </div>

                    <div class='col-sm-4'>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Download Report</button>
                        </div>
                    </div>


                </div>
                <br>
                <div class="row">


			   	 	<!-- <div class="col-sm-2">
	                    <select name="type" class="col-sm-3 form-control" required>
	                    	<option value="">Select type</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
	                    </select>
	                </div> -->
			    </div>

                <br>
                <div class="row">

                </div>

			</div>
        </form>

    </div>
    <!-- /.container-fluid -->
</div>
    <!-- /#page-wrapper -->

@endsection
