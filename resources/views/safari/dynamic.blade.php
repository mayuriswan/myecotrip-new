<select id="timeslots1" name="timeslots" required class="form-control">
    <option value="">Select TimeSlot</option>
    @foreach($timeSlots as $timeslotId => $value)
        <option value="{{$timeslotId}}##{{$value}}">{{$value}}</option>
    @endforeach
</select>