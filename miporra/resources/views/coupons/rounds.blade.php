<div class="panel panel-default {{($editable?'editable':'')}}">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#bets" href="#{{strtolower(str_replace(' ','',$title))}}" aria-expanded="false" aria-controls="{{strtolower(str_replace(' ','',$title))}}">{{$title}}</a>
        </h4>        
    </div>
    <div class="panel-body collapse" id="{{strtolower(str_replace(' ','',$title))}}">
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
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td class="bet">{!! $bet->isFilled() ? 
                                FlagIcon::get($bet->team->short_code, $bet->team->name)." ".$bet->team->name :
                                 '<span class="pending-bet label label-danger">Pending</span>' !!}
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