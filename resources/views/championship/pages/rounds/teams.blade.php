<table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('messages.Team') }}</th>
                </tr>
            </thead>
            <tbody>
               <?php $i = 1; ?>
              @foreach($teams as $team)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>
                            <a href="/statistics/team/{{$team->id}}">
                                @include('championship.utils.team',['team' => $team])
                            </a>
                        </td>
                    </tr>
              @endforeach
            </tbody>
    </table>  