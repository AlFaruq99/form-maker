<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientManajemen;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserLevelMiddlerware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::controller(AuthController::class)
->group(function(){
    Route::get('login','login')->name('login');
    Route::post('authenticate','authenticate')->name('authenticate');
    Route::post('logout','logout')->name('logout');
});

Route::prefix('panel')
->name('panel.')
->middleware('userlevel:admin')
->group(function(){
    
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::prefix('user')
    ->name('user.')
    ->controller(ClientManajemen::class)
    ->group(function(){
        Route::get('index','index')->name('index');
        Route::get('client_data','clientData')->name('clientData');
        Route::get('index_activation','userActivation')->name('userActivation');
        Route::post('activate','activate')->name('activate');
    });
});

Route::prefix('client')
->name('client.')
->middleware('userlevel:client')
->group(function(){
    Route::get('/dashboard',function(){
        return Inertia::render('Client/Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::prefix('form')
    ->name('form.')
    ->controller(FormulirController::class)
    ->middleware('subscribtion:active')
    ->group(function(){
        Route::get('index','index')->name('index');
        Route::get('create_form','CreateForm')->name('CreateForm');
        Route::get('formulir_data','FormulirData')->name('FormulirData');
        Route::get('view_form/{form_id}','ViewForm')->name('ViewForm');

        Route::post('create','Create')->name('create');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

