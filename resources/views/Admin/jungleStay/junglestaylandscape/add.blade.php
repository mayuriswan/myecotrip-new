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
                <h1 class="page-header">Add Landscape
                    <a href="{{ url('admin/addJungleStayLandscape') }}" title="Edit">
                        <button type="button" class="btn btn-primary addNewButton">Add new</button>
                    </a>
                </h1>
            </div>
		</div>

		<div class="row">
            <div class="col-lg-12">
            	<form action="createJungleStayLandscape" method="post" enctype="multipart/form-data">
				   <div class="row">
				      <div class="col-lg-12">
				         <div class="panel panel-default ">
				            <div class="panel-heading">
				               <h3>
				                  <div class='pull-right'> 
				                     <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
				                     <a href="jungleStayLandscapes" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
				                  </div>
				                  Landscape details
				               </h3>
				            </div>
				            <div class="panel-body">
				               <div class="" role="tabpanel" data-example-id="togglable-tabs">
			                  	<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				                     <li role="presentation" class="active">
				                     	<a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a>
			                     	</li>
				                    
			                  	</ul>
				                  <div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
				                     <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
				                        <div class="row">
				                           <div class="col-xs-3"><strong>Order No.&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
				                           <div class="col-xs-9"> <input name="display_order_no" required type="text" class="form-control validate[required] text-input" id="orderno">
				                           </div>
				                        </div>
				                        <br>
				                        <div class="row">
				                           <div class="col-xs-3"><strong>Landscape Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
				                           <div class="col-xs-9"> <input name="name" type="text" class="form-control validate[required] text-input" id="name" required>
				                           </div>
				                        </div>

				                        <bR>
				                        <div class="row">
				                           <div class="col-xs-3"><strong>Upload New Logo</strong></div>
				                           <div class="col-xs-9"> 
				                              <input name="logo" id="logo" type="file"  >
				                           </div>
				                        </div>

				                     </div>
				                     
				                  </div>
				               </div>
				            </div>
				         </div>
				      </div>
				   </div>
				</form>
            </div>
        </div>
	</div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->




@endsection