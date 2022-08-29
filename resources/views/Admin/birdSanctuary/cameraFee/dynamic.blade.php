<select class="form-control" name="cameratype_id" id="cameratype_id" required>
	<option value="">Select the Camera Type</option>
	@foreach($cameraTypeData as $cameraType)
		<option value="{{$cameraType['id']}}">{{$cameraType['type']}}</option>
	@endforeach
</select>