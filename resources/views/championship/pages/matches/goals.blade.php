<div class="goals">
    @foreach($goals as $goal)
        <i class="fa fa-futbol-o" aria-hidden="true"></i> {{$goal->player->name}}</br>
    @endforeach
</div>