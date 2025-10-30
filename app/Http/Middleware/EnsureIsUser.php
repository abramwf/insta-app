<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureIsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->route('username');
        $user = User::where('username', $username)->first();

        if (!$user || $request->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
