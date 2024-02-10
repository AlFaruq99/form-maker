<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientManajemen;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\FormAnswerController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\GuestFormulirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WhatsappController;
use App\Models\FormAnswer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
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

Route::get('/', [DashboardController::class,'welcomePage']);


Route::controller(AuthController::class)
->group(function(){
    Route::get('login','login')->name('login');
    Route::get('register','register')->name('register');
    Route::post('authenticate','authenticate')->name('authenticate');
    Route::post('logout','logout')->name('logout');
});

Route::middleware('guest')
->group(function(){
    Route::prefix('webhook')
    ->name('webhook.')
    ->group(function(){
        Route::get('/',function(){
            return 'aaa';
        });
        Route::post('get_webhook',function(Request $request){
            $data = $request->all();
            Log::info('webhook',$data);
        });
    });
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
    Route::prefix('invoice')
    ->name('invoice.')
    ->controller(InvoiceController::class)
    ->group(function(){
        Route::get('index','index')->name('index');
        Route::get('invoices/{invoice}', 'show')->name('preview');

        Route::post('create','createInvoice')->name('create');
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
        Route::get('responder_page','responderPage')->name('responderPage');
        Route::get('responder_list','responderList')->name('responderList');
        Route::post('create','Create')->name('create');
        Route::delete('delete/{form_id}','delete')->name('delete');
    });

    Route::prefix('form_answer')
    ->name('formAnswer.')
    ->controller(FormAnswerController::class)
    ->middleware('subscribtion:active')
    ->group(function(){
        Route::delete('delete_anwer/{form_id}','destroy')->name('deleteAnswer');
        Route::get('show/{form_id}','show')->name('show');
    });
    
    Route::prefix('wa')
    ->name('wa.')
    ->controller(WhatsappController::class)
    ->middleware('subscribtion:active')
    ->group(function(){
        Route::get('index','index')->name('index');
        Route::get('instance_token','getInstanceToken')->name('getInstanceToken');
        Route::get('check_status','addWebhook')->name('addWebhook');
    });
});

Route::prefix('guest')
->name('guest.')
->group(function(){
    Route::get('formulir/{form_id}',[GuestFormulirController::class,'formulir'])->name('formulir');
    Route::post('post_formulir',[FormAnswerController::class,'store'])->name('post_formulir');
    Route::get('response_formulir',[FormAnswerController::class,'responsePage'])->name('responsePage');
    //----------- send message
    Route::post('send_wa/{form_id}',[WhatsappController::class,'sendMessage'])->name('sendMessage');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

