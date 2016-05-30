@extends('pages.layout')

@section('content')
    <div class="jumbotron">
            <h1>Users on championship</h1>      
    </div>
    <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Is bet completed?</th>
                    <th>Admin?</th>
                    <th>Friend of</th>
                    <th>Has paid?</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        @foreach($coupons as $key => $coupon)
                 <tr>
                    <th>{{$key+1}}</th>
                    <td>{{$coupon->user->name}}</td>
                    <td>{{$coupon->user->email}}</td>
                    <td>
                        @if ($coupon->isFullyComplete())
                          <span class="pending-bet label label-success">Yes</span>
                        @else
                            <span class="pending-bet label label-danger">No</span>
                        @endif
                    </td>
                    <td>
                        @if ($coupon->user->is_admin)
                            <span class="pending-bet label label-success">admin</span>
                        @endif
                    </td>
                    <td>{{$coupon->user->is_friend_of}}</td>
                    <td>
                        @if ($coupon->user->has_paid)
                            <span class="pending-bet label label-success">Yes</span>
                        @else
                            <span class="pending-bet label label-danger">No</span>
                        @endif
                    </td>
                    <td>
                        <a type="button" href="/users/edit/{{$coupon->user->id}}" class="btn btn-default">Edit</a>
                    </td>
                </tr>
        @endforeach
          </tbody>
    </table> 
@stop