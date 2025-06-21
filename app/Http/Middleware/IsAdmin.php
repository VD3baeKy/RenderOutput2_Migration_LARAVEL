<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() &&
            Auth::user()->role && // リレーションが存在し
            Auth::user()->role->name === 'ROLE_ADMIN'
        ) {
            return $next($request);
        }
        return redirect('/')->with('error', '管理者権限が必要です');
    }
}

