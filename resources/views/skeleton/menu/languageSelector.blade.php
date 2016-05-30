<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('messages.language') }}<span class="caret"></span></a>
     <ul class="dropdown-menu">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li>
                <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                    <img src="{{ asset('/images/flags/'.$localeCode.'.icon.png') }}"> {{$localeCode}}
                </a>
            </li>
    @endforeach
    </ul>
</li>