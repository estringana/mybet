<?php

class FlagIcon
{
    public static function get($code,$name = null)
    {
           return "<img src=\"data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7\" class=\"flag flag-$code\" alt=\"$name\" />";
    }
}