@extends('layouts.Admin.app')
@section('title', '')

@section('navBar')
    @include('layouts.Admin.superAdmin.topNav')

    @include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')
<!-- include summernote wysiwyg css/js-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>  


<!-- Page Content -->
<div id="page-wrapper">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">Add Trails
               <a href="{{ url('admin/addTrail') }}" title="Edit">
               <button type="button" class="btn btn-primary addNewButton">Add new</button>
               </a>
            </h1>
         </div>
      </div>

      <div class="row">
         <form action="{{url('/')}}/admin/createTrail" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="landscape_id" value="{{$landscapeId}}">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="panel panel-default ">
                        <div class="panel-heading">
                           <h3>
                              <div class='pull-right'> 
                                 <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                 <a href="landscape" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
                              </div>
                              Trail details
                           </h3>
                        </div>
                        <div class="panel-body">
                           <div class="" role="tabpanel" data-example-id="togglable-tabs">
                              <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                 <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a></li>
                                 <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Images</a></li>
                                 <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Price</a></li>
                                 <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Other's</a></li>
                              </ul>
                              <div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
                                 <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                    <div class="row form-group">
                                       <div class="col-xs-3">
                                          <strong>Select the park&nbsp;</strong>
                                       </div>
                                       <div class="col-xs-5">
                                          <select class="form-control"  name="park_id" required>
                                             <option value="">Select</option>
                                             @foreach ($parkList as $park)
                                             <option value="{{$park['id']}}">{{ $park['name'] }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Order No.&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="display_order_no" required type="number" min="1" class="form-control " id="orderno">
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Trail Name&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="name" type="text" class="form-control " id="name" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Range&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="range" type="text" class="form-control " id="range" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Maximum Trekkers&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="max_trekkers" type="number" min="1" class="form-control " id="max_trekkers" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Distance&nbsp;</strong></div>
                                       <div class="col-xs-2"> <input name="distance" type="text" class="form-control " id="distance" required></div>
                                       <div class="col-xs-2">
                                           <select class="form-control" name="distance_unit">
                                             @foreach ($distanceUnit as $disUnit)
                                                <option value="{{$disUnit['name']}}">{{$disUnit['name']}}</option>
                                             @endforeach
                                           </select>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Duration&nbsp;</strong></div>
                                       <div class="col-xs-2">
                                          <select class="form-control" name="hours">
                                             @for($i = 0; $i < 25; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                             @endfor
                                          </select> 
                                       </div>
                                       <div class="col-xs-1">
                                          <label>Hrs</label>
                                       </div>
                                       <div class="col-xs-2">
                                             <select class="form-control" name="minutes">
                                             @for($i = 0; $i < 61; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                             @endfor
                                          </select>
                                       </div>
                                        <div class="col-xs-1">
                                          <label>Mins</label>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Trail Type&nbsp;</strong></div>
                                       <div class="col-xs-5">
                                          <select class="form-control"  name="type" required>
                                             <option value="">Select</option>
                                             <option value="Soft">Soft</option>
                                             <option value="Medium">Medium</option>
                                             <option value="Hard">Hard</option>
                                          </select>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Trail Description&nbsp;</strong></div>
                                       <div class="col-xs-9"> 
                                          <textarea name="description" rows="7" class="summernote form-control validate[required] text-input" id="description" required>
                                                </textarea>

                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Starting point&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="starting_point" type="text" class="form-control " id="starting_point" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Ending point&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="ending_point" type="text" class="form-control " id="ending_point" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Reporting time&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="reporting_time" type="text" class="form-control " id="reporting_time" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>When to visit&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="when_to_visit" type="text" class="form-control " id="when_to_visit" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Incharger details&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="incharger_details" type="text" class="form-control " id="incharger_details" placeholder="Seperate each fied by ',' Ex: Name:Vinay,PhoneNo:1234567890" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>Starting price&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="display_price" type="number" class="form-control " id="display_price" min="0" placeholder="Starting Price" required>
                                       </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                       <div class="col-xs-3"><strong>General instruction&nbsp;</strong></div>
                                       <div class="col-xs-5"> <textarea name="general_instruction" rows="7" class="form-control  TEditor" id="general_instruction" required></textarea>
                                       </div>
                                    </div>
                                 </div>

                                 <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">
                                    <bR>
                                    <div class="row">
                                       <div class="col-xs-3"><strong>Upload New Logo</strong></div>
                                       <div class="col-xs-5"> 
                                          <input name="logo" id="logo" type="file"  required>
                                       </div>
                                    </div>

                                    <br>
                                    <br>
                                    <div class="row">
                                       <div class="col-xs-3"><strong>Upload trek images</strong></div>
                                       <div class="col-xs-5"> 
                                          <input name="trekImages[]" id="trek[]" type="file" multiple>
                                       </div>
                                    </div>

                                 </div> <!--tab_content2 end  -->

                                 <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="home-tab">
                                    <br>
                                    <div class="row">
                                       <div class="col-xs-3"><strong> Meta Title&nbsp;</strong></div>
                                       <div class="col-xs-5"> <input name="meta_title" type="text" class="form-control " id="meta_title">
                                       </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                       <div class="col-xs-3"><strong>Meta Description&nbsp;</strong></div>
                                       <div class="col-xs-5"> <textarea name="meta_description" rows="4" class="form-control " id="meta_description"></textarea>
                                       </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                       <div class="col-xs-3"><strong>Keywords&nbsp;</strong></div>
                                       <div class="col-xs-5"> <textarea name="meta_keywords" rows="3" class="form-control " id="meta_keywords"></textarea>
                                       </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                       <div class="col-sm-3"><strong>Directions&nbsp;</strong></div>
                                       <div class="col-sm-9">
                                          <textarea name="direction" rows="4"  id="direction" style="resize:none;width:100%;" class="form-control TEditor"></textarea>
                                       </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                       <div class="col-sm-3"><strong>Transportation&nbsp;</strong></div>
                                       <div class="col-sm-9">
                                          <textarea name="transportation" rows="4"  id="transportation" style="resize:none;width:100%;" class="form-control TEditor"></textarea>
                                       </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                       <div class="col-sm-3"><strong>Map URL&nbsp;</strong></div>
                                       <div class="col-sm-9">
                                          <input name="map_url" type="text" class="form-control " id="map_url">
                                       </div>
                                    </div>
                                 </div><!-- tab_contrnt3 end -->

                                 <!--price-->
                                 <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="home-tab">
                                    <div class="row col-md-6">
                                       <div class="panel-body">
                                          <div class="row">
                                             <div class="col-sm-6"><strong>From &nbsp;</strong></div>
                                             <div class="col-sm-6">
                                                <input type="text" name="fromDate" class="form-control " id="fromDate" placeholder="From Date">
                                             </div>
                                          </div>
                                          <br>
                                       </div>
                                    </div>
                                    <div class="row col-md-6">
                                       <div class="panel-body">
                                          <div class="row">
                                             <div class="col-sm-6"><strong>To &nbsp;</strong></div>
                                             <div class="col-sm-6">
                                                <input type="text" required name="toDate" class="form-control " id="toDate" placeholder="To Date">
                                             </div>
                                          </div>
                                          <br>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="panel panel-default">
                                             <div class="panel-heading">
                                                <h3>Indian Adult</h3>
                                             </div>
                                             <div class="panel-body">
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Entry Fee&nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][adult][entry_fee]" class="form-control " id="entry_fee" placeholder="Entry Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Guide Fee &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][adult][guide_fee]" class="form-control " id="guide_fee" placeholder="Guide Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>TAC &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][adult][TAC]" class="form-control " id="TAC" placeholder="TAC">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="panel panel-default">
                                             <div class="panel-heading">
                                                <h3>Foreign Adult</h3>
                                             </div>
                                             <div class="panel-body">
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Entry Fee&nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[Foreign][adult][entry_fee_foreign]" class="form-control " id="entry_fee" placeholder="Entry Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Guide Fee &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[Foreign][adult][guide_fee_foreign]" class="form-control " id="guide_fee" placeholder="Guide Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>TAC &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[Foreign][adult][TAC_foreign]" class="form-control " id="TAC" placeholder="TAC">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <br>
                                    </div>
                                    <!--Child-->
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="panel panel-default">
                                             <div class="panel-heading">
                                                <h3>Indian Child</h3>
                                             </div>
                                             <div class="panel-body">
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Entry Fee&nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][child][entry_fee_child]" class="form-control " id="entry_fee" placeholder="Entry Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Guide Fee &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][child][guide_fee_child]" class="form-control " id="guide_fee" placeholder="Guide Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>TAC &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][child][TAC_child]" class="form-control " id="TAC" placeholder="TAC">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="col-md-6">
                                          <div class="panel panel-default">
                                             <div class="panel-heading">
                                                <h3>Foreign Child</h3>
                                             </div>
                                             <div class="panel-body">
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Entry Fee&nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[Foreign][child][entry_fee_foreign_child]" class="form-control " id="entry_fee" placeholder="Entry Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Guide Fee &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[Foreign][child][guide_fee_foreign_child]" class="form-control " id="guide_fee" placeholder="Guide Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>TAC &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required required name="pricing[Foreign][child][TAC_foreign_child]" class="form-control " id="TAC" placeholder="TAC">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <br>
                                    </div>

                                    <div class="row">
                                       <!--Student-->
                                       <div class="col-md-6">
                                          <div class="panel panel-default">
                                             <div class="panel-heading">
                                                <h3>Indian Student</h3>
                                             </div>
                                             <div class="panel-body">
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Entry Fee&nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][student][entry_fee]" class="form-control " id="entry_fee" placeholder="Entry Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>Guide Fee &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][student][guide_fee]" class="form-control " id="guide_fee" placeholder="Guide Fee">
                                                   </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                   <div class="col-sm-6"><strong>TAC &nbsp;</strong></div>
                                                   <div class="col-sm-6">
                                                      <input type="number" min="0" required name="pricing[India][student][TAC]" class="form-control " id="TAC" placeholder="TAC">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>

                                 </div>
                                 <!--End price  -->

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form> 
      </div>

   
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<!--Datepicker  -->
<script src="{{ asset('assets/js/jquery.min.js') }} "></script>
<script src="{{ asset('assets/js/moments.js') }} "></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }} "></script>
<script>
   $(function () {
   	$('#fromDate').datetimepicker({  
   		minDate:new Date()
   	});
   
   	$('#toDate').datetimepicker({  
   		minDate:new Date()
   	});
   });
</script>

<script type="text/javascript">
   //For wysiwyg
    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>

@endsection