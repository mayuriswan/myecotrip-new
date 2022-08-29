<select id="birdSanctuary" name="birdSanctuary_id" required class="form-control">
    <option value="">Select the Bird Sanctuary</option>
    @foreach($birdSanctuarylist as $birdSanctuary)
    <option value="{{$birdSanctuary['id']}}">{{$birdSanctuary['name']}}</option>
    @endforeach
</select>