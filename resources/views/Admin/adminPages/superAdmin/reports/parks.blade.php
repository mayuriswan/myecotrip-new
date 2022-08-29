<select name="trail" class="col-sm-3 form-control" required id="parksList">
    <option value="">Select Parks</option>
    <option value="All_{{$allValue}}">All</option>
    @foreach($parklist as $id => $parks)
    	<option value="{{$id}}_{{str_replace(' ', '', $parks)}}">{{$parks}}</option>
    @endforeach
</select>

<script type="text/javascript">
   $(function(){

      $('#parksList').change(function(e) {
        $( "#circleTrailsDiv" ).load(  "{{url('/admin')}}" +"/parksTrailList/"+$('#parksList').val());
      });
   });

</script>