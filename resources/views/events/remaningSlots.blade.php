<select name="tickets" class="form-control" required>
    <option value="">Select Value</option>
    @for ($i = 1; $i<= $noOfSlots; $i++)
        <option value="{{$i}}">{{$i}}</option>
    @endfor
</select>
