@extends('pages.layout')

@section('content')
<div class="jumbotron">
  <h1>Matches step</h1>
  <p>You have to decide which team will win each match!!</p>
</div>
<div class="alert alert-info" role="alert">
  <ul>
    <li>The bet system is open so you can make a team the winner of all its matches but it does not mean you have to add it to the next round</li>
  </ul>
</div>


<form class="form-horizontal" method="POST" action="store">
  {{ csrf_field() }}
    <div id="responsive-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Local</th>
                    <th>Away</th>
                    <th>Bet</th>
                </tr>
            </thead>
            <tbody>
              @foreach($matchBets as $key => $matchBet)
                    <tr>
                        <th scope="row">{{ $key }}</th>
                        <td data-title="Date">{{ $matchBet->match->date }}</td>
                        <td data-title="Local">{{ $matchBet->match->local->name }}</td>
                        <td data-title="Away">{{ $matchBet->match->away->name }}</td>
                        <td>
                              <div class="btn-group" role="group" aria-label="Sign" data-toggle="buttons">
                                  <label class="btn btn-default {!!$matchBet->prediction == "1"? 'active"':''!!}">
                                    <input type="radio" class="btn btn-default " value="1" name="bet[{{$matchBet->id}}]" {!!$matchBet->prediction == '1'? 'checked="checked"':''!!}/>1
                                  </label>
                                  <label class="btn btn-default {!!$matchBet->prediction == "X"? 'active"':''!!}">
                                    <input type="radio" class="btn btn-default" value="X" name="bet[{{$matchBet->id}}]" {!!$matchBet->prediction == 'X'? 'checked="checked"':''!!}/>X
                                  </label>
                                  <label class="btn btn-default {!!$matchBet->prediction == "2"? 'active"':''!!}">
                                    <input type="radio" class="btn btn-default" value="2" name="bet[{{$matchBet->id}}]" {!!$matchBet->prediction == "2"? 'checked="checked"':''!!}/>2
                                  </label>
                              </div>
                        </td>
                    </tr>
              @endforeach
          </tbody>
        </table> 
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary pull-right">Save bets</button>
    </div>
</form>
@stop