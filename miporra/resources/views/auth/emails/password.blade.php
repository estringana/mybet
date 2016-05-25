{{ trans('auth.clickheretoresetyourpassword') }}<a href="{{ $link = Url::get('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
