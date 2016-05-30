<?php

class Url
{
    public static function get($url)
    {
           return LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),$url);
    }
}