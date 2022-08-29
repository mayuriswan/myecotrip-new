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
                    <h1 class="page-header">Jungle Stay Rooms
                        <a href="{{ url('admin/addJungleStayRooms') }}" title="Add Jungle Stay Rooms">
                            <button type="button" class="btn btn-primary addNewButton">Add new</button>
                        </a>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->

                <!-- Modal -->
                <div class="modal fade" id="addNew" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Jungle Stay Rooms</h4>
                            </div>
                            {{ Form::open(array('url' => 'admin/addJungleStayRooms')) }}
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="type" placeholder="JungleStayRoom Type" name="type"  required>
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
                            <b>Jungle Stay Rooms List</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>JungleStay Name</th>
                                    <th>RoomType</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($jungleStayRoomsList) > 0)
                                    @foreach($jungleStayRoomsList as $index => $jungleStayRooms)
                                        <tr class="odd gradeX">
                                            <td>{{$index + 1}}</td>
                                            <td>{{$jungleStayRooms['jungleStayName']}}</td>
                                            <td>{{$jungleStayRooms['type']}}</td>
                                            <td>
                                                <a href="{{ url('admin/editJungleStayRooms?id=') }}{{$jungleStayRooms['id']}}"  title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                                                &nbsp;
                                                <a value="{{$jungleStayRooms['id']}}" class="JungleStayRoomsDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
        $(".JungleStayRoomsDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var JungleStayRoomId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteJungleStayRooms?id=')}}" + JungleStayRoomId
            }
        });
    </script>



@endsection
