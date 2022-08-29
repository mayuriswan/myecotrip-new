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
                    <h1 class="page-header">Boat Type
                        <a href="{{ url('admin/addBoatType') }}" title="Add Boat Type">
                            <button type="button" class="btn btn-primary addNewButton">Add new</button>
                        </a>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Boat Type List</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Park Name</th>
                                    <th>Bird Sanctuary Name</th>
                                    <th>Boat Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($boatTypeList) > 0)
                                    @foreach($boatTypeList as $index => $boatType)
                                        <tr class="odd gradeX">
                                            <td>{{$index + 1}}</td>
                                            <td>{{$boatType['parkname']}}</td>
                                            <td>{{$boatType['birdSanctuaryName']}}</td>
                                            <td>{{$boatType['name']}}</td>
                                            <td>
                                                <a href="{{ url('admin/editBoatType?id=') }}{{$boatType['id']}}"  title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                                                &nbsp;
                                                <a value="{{$boatType['id']}}" class="boatTypeDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
        $(".boatTypeDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var boatTypeId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteBoatType?id=')}}" + boatTypeId
            }
        });
    </script>



@endsection
