@extends('pages.layout')

@section('content')
    <div class="jumbotron">
            <h1>Users on championship</h1>      
    </div>
    <ul>
        @foreach($coupons as $coupon)
            <li><a href="{{Url::get('/coupon/view/'.$coupon->user->id)}}">{{$coupon->user->name}}</a></li>
        @endforeach
    </ul>
@stop