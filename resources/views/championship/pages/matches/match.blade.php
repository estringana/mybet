@foreach($matches as $match)
<div class="panel panel-default">
    <div class="panel-heading">
        @include('championship.utils.match', [ 'match' => $match])   
    </div>
    <div class="panel-body">
            <i class="fa fa-calendar" aria-hidden="true"></i> {{$match->date}}       
                <a class="btn btn-default pull-right" href="{{ Url::get('/matches/propose/'.$match->id) }}" role="button">{{ trans('messages.reportScore')}}</a>
                @include('championship.pages.matches.goals', [ 'goals' => $match->goals])
    </div>
</div>
@endforeach