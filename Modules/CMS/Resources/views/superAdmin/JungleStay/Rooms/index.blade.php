@extends('cms::layouts.app')

@section('title', '')

@section('navBar')
    @include('cms::layouts.superAdmin.topNav')

    @include('cms::layouts.superAdmin.sideNav')
@endsection

@section('content')
<!-- <ul class="breadcrumb">
    <li><a href="{{url('/')}}">Home</a>
    </li>
    <li><a href="{{url('/jungle-stays')}}">Jungle Stays</a>
    </li>
    <li><a href="{{url('/jungle-stays')}}">  Jungle Stay</a>
    </li>
    <li class="active">Available Rooms</li>
</ul> -->
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Jungle Stays Rooms
                        <a href="{{url('/cms/jungle-stay/create-room')}}/{{$jsId}}" title="Add new admin">
                            <button type="button" class="btn btn-danger">Add new</button>
                        </a>
                        <a href="{{url('/cms/jungle-stay/stays')}}" title="Add new admin">
                            <button type="button" class="btn btn-info addNewButton">Back to Stays List</button>
                        </a>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        <div class="flash-message">
    	  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    	    @if(Session::has('alert-' . $msg))
    	    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
    	    @endif
    	  @endforeach
    	</div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List of all jungle rooms
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sl no</th>
                                    <th>Type</th>
                                    <th>No. Of Rooms</th>
                                    <th>Order No</th>
                                    <th>Display price</th>
                                    <th>Status</th>
                                    <th>Pricing</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody class="tblFont">
                                @foreach($data as $key => $row)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$row['type']}}</td>
                                        <td>{{$row['no_of_rooms']}}</td>
                                        <td>{{$row['display_order']}}</td>
                                        <td>{{$row['display_price']}}</td>
                                        <td>{{$row['status']}}</td>
                                        <td>
                                            <a href="{{ url('cms/jungle-stay/pricing')}}/{{$row['id']}}" title="Edit"><i class="fa fa-money fa-fw"></i> Pricing</a>
                                        </td>
                                        <td>
                                        	<a href="{{ url('cms/jungle-stay/rooms')}}/{{$row['id']}}" title="Edit"><i class="fa fa-edit fa-fw"></i> Edit</a>
                                        </td>
                                        <td>
                                            <a value="{{$row['id']}}" class="deleteRow" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->

                    </div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->


    </div>
    <!-- /.container-fluid -->
</div>
    <!-- /#page-wrapper -->

<script>

    $(".deleteRow").on("click", function(){
        var decision = confirm("Do you want to delete this item?");
        var id = $(this).attr('value');

        if (decision) {
        	$.ajax({
    		 	headers: {
				    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  },
			  	type: "DELETE",
			  	url: "{{URL::to('cms/jungle-stay/rooms')}}/" + id,
                success: function(data, textStatus, jqXHR){
	                console.log(jqXHR.status);
	                window.location.href= "{{url('/')}}" + '/cms/jungle-stay/rooms';
	            }
			});
        }
    });

</script>

@endsection
