<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserLevelMiddlerware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next, string $role): Response
    {

        try {

            $userId = Auth::user()->id;
            $user = User::with('role')->find($userId);
            
            if ($user->role->level == $role) {
                return $next($request);
            }
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            return redirect('/login');
        } catch (\Throwable $th) {
            return redirect('/login');

        }
        
    }
}
