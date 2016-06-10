<?php

namespace App\Http\Middleware;

use Closure;

class TemporalyDisabled
{
    protected function isUserAdmin()
    {
        return \Auth::user() && \Auth::user()->is_admin;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->isUserAdmin())
        {
            alert()->error(trans('Temporary disabled'), trans('Disabled'));
            return redirect('/');
        }

        return $next($request);
    }
}
