<select class="form-control" name="timeslots_id" id="timeslots_id" required>
	<option value="">Select the TimeSlot</option>
	@foreach($timeslots as $timeslotslist)
		<option value="{{$timeslotslist['id']}}">{{$timeslotslist['timeslots']}}</option>
	@endforeach
</select>