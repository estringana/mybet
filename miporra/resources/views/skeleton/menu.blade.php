<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">{{ trans('messages.title') }}</a>       
    </div>
    <ul class="nav navbar-nav">
    @if(Auth::check())
            <li><a href="{{Url::get('/coupon')}}">{{ trans('messages.yourbet') }}</a></li>
            <li><a href="{{Url::get('/table')}}">{{ trans('messages.table') }}</a></li>
    @endif
        <li><a href="{{Url::get('/matches')}}">{{ trans('messages.matches') }}</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li>
            @if(Auth::check())
                <li><a href="{{Url::get('/logout')}}">{{ trans('auth.logout') }}</a></li>
            @else
                <li><a href="{{Url::get('/register')}}">{{ trans('auth.register') }}</a>
                <li><a href="{{Url::get('/login')}}">{{ trans('auth.login') }}</a></li>
            @endif
        </li>
            @include('skeleton.menu.languageSelector')        
    </ul>
  </div><!-- /.container -->
</nav>