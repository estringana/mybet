@extends('pages.layout')

@section('content')
    <div class="jumbotron">
            <h1>Editing user {{$user->name}}</h1>      
    </div>
    <div class="container">
    <form class="form-horizontal" method="POST" action="">
        {{ csrf_field() }}
        <div>Is user admin?
              <div class="btn-group" role="group" aria-label="Sign" data-toggle="buttons">
                  <label class="btn btn-default {!!$user->is_admin? 'active"':''!!}">
                    <input type="radio" class="btn btn-default " value="1" name="admin" {!!$user->is_admin? 'checked="checked"':''!!}/>Yes
                  </label>
                  <label class="btn btn-default {!!$user->is_admin? '"':'active'!!}">
                    <input type="radio" class="btn btn-default " value="0" name="admin" {!!$user->is_admin?'' : 'checked="checked"'!!}/>No
                  </label>
              </div>
        </div>
        <div>Has user paid?
            <div class="btn-group" role="group" aria-label="Sign" data-toggle="buttons">
                <label class="btn btn-default {!!$user->has_paid? 'active"':''!!}">
                  <input type="radio" class="btn btn-default " value="1" name="paid" {!!$user->has_paid? 'checked="checked"':''!!}/>Yes
                </label>
                <label class="btn btn-default {!!$user->has_paid? '"':'active'!!}">
                  <input type="radio" class="btn btn-default " value="0" name="paid" {!!$user->has_paid?'' : 'checked="checked"'!!}/>No
                </label>
            </div>
        </div>
        <div class="form-group">
          <label for="friend">Friend of:</label>
            <input type="text" class="form-control" id="friend" name="friend" placeholder="Friend of..." value="{{$user->is_friend_of}}">
          </div>
            <button type="submit" class="btn btn-default">Submit</button>
    </form>
    </div>
@stop