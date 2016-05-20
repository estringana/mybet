    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                <img src="{{ asset('/images/flags/'.$localeCode.'.icon.png') }}">
            </a>
    @endforeach