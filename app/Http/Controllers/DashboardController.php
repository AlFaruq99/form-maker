<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
