@foreach($players as $player)
<div class="input-group col-xs-12 col-md-12 margin-top-sm">
  <span class="input-group-addon" id="sizing-addon2">{{$player->name}}</span>
  <input type="text" name="player[{{$player->id}}]" id="player[{{$player->id}}]" class="form-control" placeholder="Goals..." aria-describedby="sizing-addon2">
</div>
@endforeach