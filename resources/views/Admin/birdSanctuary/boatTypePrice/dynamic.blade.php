<select class="form-control" name="boatType_id" id="boatType_id" required>
	<option value="">Select the Boat Type</option>
	@foreach($boatTypeData as $boatType)
		<option value="{{$boatType['id']}}">{{$boatType['name']}}</option>
	@endforeach
</select>