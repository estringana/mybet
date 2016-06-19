<div class="panel panel-default {{($editable?'editable':'')}}">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="{{$collapsable or ''}}" data-parent="#bets" href="#{{strtolower(str_replace(' ','',$title))}}" aria-expanded="false" aria-controls="{{strtolower(str_replace(' ','',$title))}}">{{trans('messages.'.$title)}}</a>
        </h4>        
    </div>
    <div class="panel-body {{$collapsable or ''}}" id="{{strtolower(str_replace(' ','',$title))}}">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.team') }}</th>
                </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              @foreach($bets as $key => $bet)
                    @if ($bet->getPointsAttribute() == 1)
                        <tr class='success'>
                    @else
                        <tr>
                    @endif
                        <th scope="row">{{ $i++ }}</th>
                        <td class="bet">
                            @if ($bet->isFilled()) 
                                <a href="/statistics/team/{{$bet->team->id}}">{!! FlagIcon::get($bet->team->short_code, $bet->team->name)." ".trans('teams.'.$bet->team->name) !!}</a>
                            @else
                                 <span class="pending-bet label label-danger">Pending</span>
                            @endif
                        </td>
                    </tr>
              @endforeach
          </tbody>
        </table> 
        @if (isset($editable) && $editable == true)
            <a class="btn btn-primary btn-lg pull-right" href="{{ Url::get('/coupon/round/'.strtolower(str_replace(' ','',str_replace('-','',$title))).'/update') }}" role="button">                    
                        {{ trans('messages.Changeyourteamsonthisround') }}
            </a>
        @endif
    </div>
</div>