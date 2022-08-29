<select id="transportation" name="transportation_id" required class="form-control">
    <option value="">Select Transportation</option>
    @foreach($transportList as $tranportlist)
    <option value="{{$tranportlist['id']}}">{{$tranportlist['name']}}</option>
    @endforeach
</select>