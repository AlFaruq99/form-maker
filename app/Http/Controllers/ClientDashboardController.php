<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use App\Models\User;
use App\Models\WaUser;
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

        return Inertia::render('Client/Dashboard',[
            'user' => $user,
            'waInstance' => $waInstance,
            'formulir' => $formulirCount
        ]);
    }
}
