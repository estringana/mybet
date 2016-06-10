<table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.username') }}</th>
                    <th>{{ trans('messages.total') }}</th>
                    <th>{{ trans('messages.playerbets') }}</th>
                    <th>{{ trans('messages.matches') }}</th>
                    <th>{{ trans('messages.roundOf16Bets') }}</th>
                    <th>{{ trans('messages.quarterFinalsBets') }}</th>
                    <th>{{ trans('messages.semiFinals') }}</th>
                    <th>{{ trans('messages.final') }}</th>
                    <th>{{ trans('messages.champion') }}</th>
                    <th>{{ trans('messages.runnersup') }}</th>
                </tr>
            </thead>
            <tbody>
               <?php $i = 1; ?>
              @foreach($table as $key => $line)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td><a href="{{Url::get('/coupon/view/'.$line->userId)}}">{{$line->userName}}</a></td>
                        <td>{{ $line->total }}</td>
                        <td>{{ $line->playerBets }}</td>
                        <td>{{ $line->matchBets }}</td>
                        <td>{{ $line->roundOf16Bets }}</td>
                        <td>{{ $line->quarterFinalsBets }}</td>
                        <td>{{ $line->semiFinals }}</td>
                        <td>{{ $line->final }}</td>
                        <td>{{ $line->champion }}</td>
                        <td>{{ $line->runnersup }}</td>
                    </tr>
              @endforeach
          </tbody>
        </table> 