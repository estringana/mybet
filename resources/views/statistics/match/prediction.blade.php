<div class="page-header">
         <h2>{{trans('messages.Prediction')}}: {{$predictionValue}}</h2>
      </div>
      <div class="panel panel-default">
              <div class="panel-body">
                    <p>{{trans('messages.This prediction has been choose on')}} {{round($prediction->percentage,2)}}% {{trans('messages.of the bets')}}</p>                
                </div>
        </div>
        @if($prediction->coupons->count() > 0 )
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('messages.Bets')}}:</div>
                <div class="panel-body">
                          <ul class="list-group">
                            @foreach($prediction->coupons as $coupon)
                            <li class="list-group-item"><a href="/coupon/view/{{$coupon->user->id}}">{{$coupon->user->name}}</a></li>
                            @endforeach
                          </ul>
                </div>
            </div>
        @endif