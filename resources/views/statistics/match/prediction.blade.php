<div class="page-header">
         <h2>{{trans('messages.Prediction')}}: {{$predictionValue}}</h2>
      </div>
      <div class="panel panel-default">
              <div class="panel-body">
                    <p>{{trans('messages.This prediction has been choose on')}} {{round($prediction->percentage,2)}}% {{trans('messages.of the bets')}}</p>                
                </div>
        </div>
        @if($prediction->coupons->count() > 0 )
            <div class="panel panel-default prediction{{$predictionValue}}title">
                <div class="panel-heading">
                     <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent=".prediction{{$predictionValue}}title" href=".prediction{{$predictionValue}}" aria-expanded="false" aria-controls="prediction{{$predictionValue}}">
                                {{trans('messages.Bets')}}:
                              </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse prediction{{$predictionValue}}" role="tabpanel" aria-labelledby="prediction{{$predictionValue}}title">
                      <div class="panel-body">
                                <ul class="list-group">
                                  @foreach($prediction->coupons as $coupon)
                                  <li class="list-group-item"><a href="/coupon/view/{{$coupon->user->id}}">{{$coupon->user->name}}</a></li>
                                  @endforeach
                                </ul>
                      </div>
                  </div>
            </div>
        @endif