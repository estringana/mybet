<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="/">{{ trans('messages.title') }}</a>       
    </div>
    <ul class="nav navbar-nav">
    @if(Auth::check())
            <li><a href="{{Url::get('/coupon')}}">{{ trans('messages.yourbet') }}</a></li>
            <li><a href="{{Url::get('/table')}}">{{ trans('messages.table') }}</a></li>
            @if(Auth::user()->is_admin)
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/users/printable">Users printable</a></li>
                    <li><a href="/users/list">Users</a></li>
                    <li><a href="/messages">Messages from users</a></li>
                    <li><a href="/cache/flush">Flush cache</a></li>
                  </ul>
                </li>
            @endif
    @endif
        <li><a href="{{Url::get('/matches')}}">{{ trans('messages.matches') }}</a></li>
        <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{trans('messages.Statistics')}}<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/statistics/players">{{trans('messages.Players')}}</a></li>
                    <li><a href="/statistics/round/2">{{trans('messages.Round of 16')}}</a></li>
                    <li><a href="/statistics/round/3">{{trans('messages.Quarter-Finals')}}</a></li>
                    <li><a href="/statistics/round/4">{{trans('messages.Semi-Finals')}}</a></li>
                    <li><a href="/statistics/round/5">{{trans('messages.Final')}}</a></li>
                    <li><a href="/statistics/round/6">{{trans('messages.Champion')}}</a></li>
                    <li><a href="/statistics/round/7">{{trans('messages.Runners-up')}}</a></li>
                  </ul>
                </li>
        <li><a href="{{Url::get('/coupon/all')}}">{{ trans('messages.users') }}</a></li>    
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