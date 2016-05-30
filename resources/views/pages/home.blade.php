@extends('pages.layout')

@section('content')
    <div class="jumbotron">
      <h1>{{ trans('messages.title') }}</h1>
      <p>{{ trans('messages.create_a_team.message') }}</p>
      <p>
        <a class="btn btn-primary btn-lg" href="{{ Url::get('/coupon') }}" role="button">
            {{ trans('messages.create_a_team.button') }}
        </a>
    </p>
    </div>
    <div class="page-header">
      <h1>Rules</h1>
      <ol>
            <li>Payments</li>
                <ul>
                    <li>Every player must paid 10€ or £8 to join the championship.</li>
                    <li>The payment needs to be done directly to the person you know within the myporra team</li>
                    <li>The prizes will be paid using the same approach but on the other direction</li>
                    <li>Every player must paid by 8th of June</li>
                </ul>
            <li>Bets</li>
                <ul>
                    <li>The system will stop accepting bet changes on 9th of June at 17:00</li>
                    <li>You must have your bet finished by then, if not money won't be given back</li>
                    <li>It won't be possible to do any change after this time</li>
                    <li>If a player gets injured once the bet changes is closed, it won't be possible to change it</li>
                </ul>
            <li>Website</li>
                <ul>
                    <li>The website won't show any player bet until 10th of June at 19:00</li>
                    <li>All the bets will be sent on a PDF file. Therefore you will be able to download it. We do this to prove none of the bets gets changed once published</li>
                    <li>Once the championship starts you will be able to follow all the matches and tables on the website</li>
                    <li>The table will be kept up to date</li>
                    <li>You will be able to report scores of games. This system will be initially open and will alow people to report scores to keep the matches up to date. We will keep who has report each score so please don't try to get advantage of this system to send fake scores. An score will require four people reporting the same to be approved</li>                    
                </ul>
            <li>Prizes</li>
                <ul>
                    <li>1st - 70% of the money collected</li>
                    <li>2nd - 20% of the money collected</li>
                    <li>3rd - 10% of the money collected</li>
                    <li>All the money collected will be used for prizes.</li>
                    <li>The total amount collected will be published once we have all the bets.</li>
                    <li>In case two or more players end with the same amount of points, the prizes will be combined and divide by the amount of players with the same points. For example, if two players end with the same amount of points on the 2nd position. Both player will get 30% divided by two (20% of the second prize and 10% of the 3rd). If the top four end with the same points, the total amount will be splited by four... etc.</li>
                </ul>
            <li>Goals</li>
                <ul>
                    <li>We will use the goals reported by FIFA. In case of own goals or something like that. We will count them only if FIFA count it.</li>
                </ul>
            <li>Points</li>
                <ul>
                    <li>1 point for each match guessed</li>
                    <li>1 point for each goal of your players</li>
                    <li>2 points for each team guessed on the round of 16</li>
                    <li>3 points for each team guessed on Quarter finals</li>
                    <li>4 points for each team guessed on Semi finals</li>
                    <li>5 points for each team guessed on the final</li>
                    <li>2 points if you guess the the runners-up team</li>
                    <li>3 points if you guess the the champion team</li>
                </ul>
      </ol>
    </div>
@stop