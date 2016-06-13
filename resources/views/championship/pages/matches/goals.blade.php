<div class="goals">
    @foreach($goals as $goal)
        <i class="fa fa-futbol-o" aria-hidden="true"></i> {{$goal->player->name}} {!!FlagIcon::get($goal->player->team->short_code,$goal->player->team->name)!!}
        @if($goal->own_goal)
            (own goal)
        @endif
        @if($goal->penalty)
            (p)
        @endif
        </br>
    @endforeach
</div>