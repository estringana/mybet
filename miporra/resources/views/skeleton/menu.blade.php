<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">{{ trans('messages.title') }}</a>       
    </div>
    @if(Auth::check())
        <ul class="nav navbar-nav">
            <li><a href="#">Your bet</a></li>
        </ul>
    @endif
    <ul class="nav navbar-nav navbar-right">
        <li>
            @if(Auth::check())
                <li><a href="{{Url::get('logout')}}">Log out</a></li>
            @else
                <li><a href="{{Url::get('login')}}">Log in</a></li>
            @endif
        </li>
            @include('skeleton.menu.languageSelector')        
    </ul>
  </div><!-- /.container -->
</nav>