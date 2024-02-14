<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClientBilling;
use App\Models\Formulir;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function welcomePage(){

        $totalClient = User::whereHas('role',function($sub){
            $sub->where('level','client');
        })->withCount('role')->count();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'appName' => env('APP_NAME'),
            'version' => env('APP_VERSION'),
            'phpVersion' => PHP_VERSION,
            'totalClient' => $totalClient
        ]);
    }

    public function adminDashboard(){

        $totalClient = User::whereHas('role',function($sub){
            $sub->where('level','client');
        })->withCount('role')->count();
        $totalFormulir = Formulir::count();
        
        $clientBilling = ClientBilling::join('users', 'client_billings.user_id', '=', 'users.id')
        ->select('users.name', 'users.email', 'client_billings.expired_at')
        ->orderByDesc('client_billings.expired_at')
        ->limit(5)
        ->get();

        return Inertia::render('Admin/Dashboard', [
            'totalClient' => $totalClient,
            'totalFormulir' => $totalFormulir,
            'clientBilling' => $clientBilling
        ]);        
    }
}
