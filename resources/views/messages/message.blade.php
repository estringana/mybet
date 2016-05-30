@extends('pages.layout')

@section('content')
<div class="jumbotron">
            <h1>Send us a message</h1>      
    </div>
<div class="container">
    <form class="form-horizontal" method="POST" action="">
        {{ csrf_field() }}
        <div class="form-group">
              <label for="comment">Send us a message and we will contact you back at some point:</label>
              <textarea class="form-control" rows="5" id="message" name="message"></textarea>
        </div>
        <button type="submit" class="btn btn-default pull-right">Submit</button>
    </form>
</div>
@stop