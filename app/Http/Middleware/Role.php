<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->user()->role == $role) {
            return $next($request);
        }
        return response()->json([
            'code' => '403',
            'message' => 'Terlarang! Anda tidak memiliki izin untuk mengakses sumber daya ini',
        ], 403);
    }
}