<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $recentlyUser = User::whereHas('role', function($sub) {
            $sub->where('level', 'client');
        })
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();


        $totalFormulir = Formulir::count();
        return Inertia::render('Admin/Dashboard', [
            'totalClient' => $totalClient,
            'totalFormulir' => $totalFormulir,
            'recentlyUser' => $recentlyUser
        ]);        
    }
}
