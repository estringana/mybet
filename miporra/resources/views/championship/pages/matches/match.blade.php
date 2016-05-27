<div class="list-group">
@foreach($matches as $match)
    <a href="#" class="list-group-item">
        <h4 class="list-group-item-heading">
            <i class="fa fa-calendar" aria-hidden="true"></i> {{$match->date}}  {!!FlagIcon::get($match->local->short_code,$match->local->name)!!} {{$match->local->name}} {{$match->local_score}} - {{$match->away_score}} {{$match->away->name}} {!!FlagIcon::get($match->away->short_code,$match->away->name)!!}</h4>
        <p class="list-group-item-text">
            @include('championship.pages.matches.goals', [ 'goals' => $match->goals])
        </p>
  </a>
@endforeach
</div>