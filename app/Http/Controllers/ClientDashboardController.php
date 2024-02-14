<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\FormAnswer;
use App\Models\User;
use App\Models\WaUser;
use App\Models\ClientBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ClientDashboardController extends Controller
{
    public function index(){

        $user = User::where('id',Auth::user()->id)
        ->with('subscription')
        ->first();

        $waInstance = WaUser::where('user_id',$user->id)
        ->first();

        $formulirCount = Formulir::select(DB::raw('COUNT(id)'),DB::raw("date_part('month',created_at) as month"))
        ->where('user_id',$user->id)
        ->groupBy(DB::raw("date_part('month',created_at)"))
        ->get();
        
        $masaAktif = ClientBilling::select('expired_at')
        ->where('user_id', $user->id)
        ->first();

        $formulir = Formulir::where('user_id', $user->id)
        ->count();

        $FormTerbanyak = FormAnswer::select('formulirs.title', DB::raw('COUNT(*) as total'))
        ->join('formulirs', 'form_answers.formulir_id', '=', 'formulirs.id')
        ->groupBy('formulirs.title')
        ->orderByDesc('total')
        ->limit(5)
        ->get();
      
        return Inertia::render('Client/Dashboard',[
            'formulir' => $formulir,
            'masaAktif' => $masaAktif,
            'formTerbanyak' => $FormTerbanyak
        ]);
    }
}
