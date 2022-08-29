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
                    <h1 class="page-header">Jungle Stays Parking
                        <a href="{{url('/cms/jungle-stay/parking/create')}}" title="Add new">
                            <button type="button" class="btn btn-primary addNewButton">Add new</button>
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
                        List of parking prices
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sl no</th>
                                    <th>Stay</th>
                                    <th>Vehicle</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody class="tblFont">
                                @foreach($data as $key => $row)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$row['name']}}</td>
                                        <td>{{$row['type']}}</td>
                                        <td>{{$row['price']}}</td>
                                        <td>{{$row['status']}}</td>
                                        <td>
                                        	<a href="{{ url('cms/jungle-stay/parking')}}/{{$row['id']}}" title="Edit"><i class="fa fa-edit fa-fw"></i> Edit</a>
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
			  	url: "{{URL::to('cms/jungle-stay/parking')}}/" + id,
                success: function(data, textStatus, jqXHR){
	                console.log(jqXHR.status);
	                window.location.href= "{{url('/')}}" + '/cms/jungle-stay/parking';
	            }
			});
        }
    });

</script>

@endsection
