<div class="goals">
    @foreach($goals as $goal)
        <i class="fa fa-futbol-o" aria-hidden="true"></i> {{$goal->player->name}} {!!FlagIcon::get($goal->player->team->short_code,$goal->player->team->name)!!}</br>
    @endforeach
</div>