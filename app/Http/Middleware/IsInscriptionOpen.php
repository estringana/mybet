<?php

namespace App\Http\Middleware;

use Closure;

class IsInscriptionOpen
{

    protected function isInscriptionOpen()
    {
           return \App\Models\Championship::active()->isInscriptionOpen();
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
            alert()->error(trans('messages.It is not possible to make more changes'), trans('messages.Not allowed any more'));
            return redirect('/');
        }
        
        return $next($request);
    }
}
