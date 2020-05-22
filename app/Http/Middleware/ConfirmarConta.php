<?php

namespace App\Http\Middleware;

use Closure;
use App\Conta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ConfirmarConta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        dd($request);
        $user = Auth::user()->id;
        $conta = DB::table('contas')->where('user_id', $user)->first();
        if ($user) {
           return $next($request);
        }

        return redirect()->route('me');

    
    }
}
