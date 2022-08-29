<select name="trail" class="col-sm-3 form-control" required id="circleTrails">
    <option value="">Select Trails</option>
    <option value="All_{{$allValue}}">All</option>
    @foreach($traillist as $id => $trails)
    	<option value="{{$id}}_{{$trails}}">{{$trails}}</option>
    @endforeach
</select>