<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientSubscribtion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $active): Response
    {
        
        if ($active == 'active') {
            $userId = Auth::user()->id;
            $user = User::with('subscription')
            ->whereHas('subscription',function($sub){
                $sub->where('expired_at','>',date('Y-m-d'));
            })
            ->find($userId);

            if (isset($user)) {
                return $next($request);
            }
        }

        return redirect()->back()
        ->withErrors(['message' => 'Langganan anda telah habis, silakan menghubungi customer service']);

    }
}
