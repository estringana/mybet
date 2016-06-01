<?php

namespace App\Http\Middleware;

use Closure;

class HasStarted
{
    protected function isInscriptionOpen()
    {
           return \App\Models\Championship::active()->hasStarted();
    }

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
        if ( ! $this->isInscriptionOpen() &&  ! $this->isUserAdmin())
        {
             alert()->error(trans('messages.This option is still not available'), trans('messages.Not available yet'));
            return redirect('/');
        }
        
        return $next($request);
    }
}
