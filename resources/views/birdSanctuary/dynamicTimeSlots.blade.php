<label>TimeSlots</label>
<select id="timeslots_id" name="timeslots" required class="form-control">
    <option value="">Select TimeSlot</option>
    @foreach($birdSanctuaryTimeSlots as $timeslots)
       <option value="{{$timeslots['timeslots_id']}}">{{$timeslots['timeslots']}}</option>
    @endforeach()
</select>
