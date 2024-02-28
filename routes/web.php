<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\ClientManajemen;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\FormAnswerController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\GuestFormulirController;
use App\Http\Controllers\MailController;
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

$prefixUser = ['panel','client','guest'];

Route::middleware('guest')->get('/', [DashboardController::class,'welcomePage']);
Route::controller(AuthController::class)
->middleware('guest')
->group(function(){
    Route::get('login','login')->name('login');
    Route::get('register','register')->name('register');
    Route::post('authenticate','authenticate')->name('authenticate');
});

Route::post('logout',[AuthController::class,'logout'])->name('logout');

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
    
    Route::get('/dashboard',[DashboardController::class,'adminDashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::prefix('user')
    ->name('user.')
    ->controller(ClientManajemen::class)
    ->group(function(){
        Route::get('index','index')->name('index');
        Route::get('client_data','clientData')->name('clientData');
        Route::get('index_activation','userActivation')->name('userActivation');
        Route::get('create','create')->name('create');
        Route::post('store','store')->name('store');
        Route::post('activate','activate')->name('activate');
    });


    Route::prefix('invoice')
    ->name('invoice.')
    ->controller(InvoiceController::class)
    ->group(function(){
        Route::get('index','index')->name('index');
        Route::get('preview-pdf-file', 'stream')->name('stream');
        Route::get('fetch_invoice','fetchInvoice')->name('fetchInvoice');
        Route::get('create','create')->name('create');
        Route::post('update','update')->name('update');
        Route::post('delete','destroy')->name('destroy');
        Route::post('store','store')->name('store');
        
        Route::get('download/{invoice_id}','download')->name('download');
        Route::get('send_media','sendMedia')->name('sendMedia');
    });


    Route::prefix('whatsapp')
    ->name('whatsapp.')
    ->controller(WhatsappController::class)
    ->group(function(){
        Route::get('index','connectPageAdmin')->name('connectPageAdmin');
        Route::get('set_webhook','connectWhatsappSetWebhook')->name('setWebhook');
        Route::post('send_media',"sendMediaMessage")->name('sendMediaMessage');
    });
   
  
});


foreach ($prefixUser as $key => $prefix) {

    if ($prefix === 'panel') {
        $middleware = ['userlevel:admin'];
    }else if($prefix === 'client'){
        $middleware = ['userlevel:client','subscribtion:active'];
    }
    Route::prefix($prefix)->name($prefix.'.')
    ->middleware($middleware)
    ->group(function(){
        Route::prefix('mail')
        ->name('mail.')
        ->controller(MailController::class)
        ->group(function(){
            Route::get('page/{id}','sendMailPage')->name('sendMailPage');
            Route::post('send_invoice','sendInvoice')->name('sendInvoice');
        });
    });
}

Route::prefix('client')
->name('client.')
->middleware('userlevel:client')
->group(function(){
    Route::get('/dashboard',[ClientDashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

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
        Route::get('export_excel','exportExcel')->name('exportExcel');
    });

    Route::prefix('form_answer')
    ->name('formAnswer.')
    ->controller(FormAnswerController::class)
    ->middleware('subscribtion:active')
    ->group(function(){
        Route::delete('delete_anwer/{form_id}','destroy')->name('deleteAnswer');
        Route::get('show/{form_id}','show')->name('show');
    });

    Route::prefix('invoice')
    ->name('invoice.')
    ->controller(InvoiceController::class)
    ->group(function(){
        Route::get('index','clientIndex')->name('clientIndex');
        Route::get('preview-pdf-file', 'stream')->name('stream');
        Route::get('fetch_invoice','fetchInvoice')->name('fetchInvoice');
        Route::get('create','clientCreate')->name('clientCreate');
        Route::post('update','update')->name('update');
        Route::post('delete','destroy')->name('destroy');
        Route::post('store','store')->name('store');

        Route::get('download/{invoice_id}','download')->name('download');
        Route::get('send_media','sendMedia')->name('sendMedia');
    });
    
    Route::prefix('wa')
    ->name('wa.')
    ->controller(WhatsappController::class)
    ->middleware('subscribtion:active')
    ->group(function(){
        Route::get('index','index')->name('index');
        Route::get('set_webhook','connectWhatsappSetWebhook')->name('setWebhook');
        Route::post('send_media',"sendMediaMessage")->name('sendMediaMessage');
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

