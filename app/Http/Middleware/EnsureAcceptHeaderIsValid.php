<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponses;
use Closure;
use Illuminate\Http\Request;

class EnsureAcceptHeaderIsValid
{
    use ApiResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(! ($request->hasHeader('accept'))){
            return $this->error(['accept'=>'is missed']);
        }
        if($request->header('accept') != 'application/json'){
            return $this->error(['accept'=>'application/json']);
        }
        return $next($request);
    }
}
