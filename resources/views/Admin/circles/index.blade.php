@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.superAdmin.topNav')

    @include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-lg-12">
                <h1 class="page-header">Circles
                <button type="button" class="btn btn-primary addNewButton" data-toggle="modal" data-target="#addNew">Add new</button></h1>
            </div>
            <!-- /.col-lg-12 -->

            <!-- Modal -->
			<div class="modal fade" id="addNew" role="dialog">
				<div class="modal-dialog">

				  <!-- Modal content-->
				  <div class="modal-content">
				    <div class="modal-header">
				      <button type="button" class="close" data-dismiss="modal">&times;</button>
				      <h4 class="modal-title">Add Circle</h4>
				    </div>
		    		{{ Form::open(array('url' => 'admin/addCircle')) }}
					    <div class="modal-body">				    	
							<div class="form-group row">
								<label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" id="name" placeholder="Circle Name" name="name"  required>
								</div>
							</div>
					    </div>
					    <div class="modal-footer">
					      <button type="submit" class="btn btn-success">Add</button>
					      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					    </div>
			    	{{ Form::close() }}				      
				  </div>
				  
				</div>
			</div>			
        </div>
        <!-- /.row -->

        @if(Session::has('message'))
			<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
		@endif

		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Circle list
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @if(count($circleList) > 0)
                            	@foreach($circleList as $index => $circle)
                                    <tr class="odd gradeX">
                                        <td>{{$index + 1}}</td>
                                        <td>{{$circle['name']}}</td>
                                        <td>{{$circle['status']}}</td>
                                        <td>
                                        	<a href="{{ url('admin/circles/edit?id=') }}{{$circle['id']}}"  title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                                        	<a value="{{$circle['id']}}" class="circleDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
							    @endforeach				             	                             
							@else
								<div class="alert alert-warning">
							        <strong>Sorry!</strong> No Product Found.
							    </div>								    
							@endif

                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                        <br>
                        <div class="well">
                            <h4>Information to be know :</h4>
                            <p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website.</p>
                           
                        </div>
                    </div>
                    <!-- /.panel-body -->
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
    $(".circleDelete").on("click", function(){
        var decision = confirm("Do you want to delete this item?");

        if (decision) {
            var circleId = $(this).attr('value');
            window.location.href = "{{URL::to('admin/deleteCircle?id=')}}" + circleId
        }
    });
</script>



@endsection
