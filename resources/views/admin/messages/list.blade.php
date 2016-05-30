@extends('pages.layout')

@section('content')
    <div class="jumbotron">
            <h1>Messages from users</h1>      
    </div>
    <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Send date</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
        @foreach($messages as $key => $message)
                 <tr>
                    <th>{{$key+1}}</th>
                    <td>{{$message->user->name}}</td>
                    <td>{{$message->created_at}}</td>
                    <td>{{$message->message}}</td>                    
                </tr>
        @endforeach
          </tbody>
    </table> 
@stop