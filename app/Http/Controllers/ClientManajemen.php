<?php

namespace App\Http\Controllers;

use App\Models\ClientBilling;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ClientManajemen extends Controller
{
    public function index(Request $request){
        return Inertia::render(
            'Admin/UserManajemen/Index',
        );
    }

    public function ClientData(Request $request){
        $length = $request->length??10;
        $search = $request->search??null;
        $status = $request->status??null;

        $client = User::whereHas('role',function($sub){
            $sub->where('level','client');
        })
        ->when($search,function($sub) use($search){
            $sub->where('name','ilike',"%$search%");
        })
        ->when($status, function($sub) use($status){
            if ($status == 'active') {
                $sub->whereHas('subscription',function($subBilling) use($status){
                    $subBilling->where('expired_at','>',date('Y-m-d'));
                });
            }else if($status == 'inactive'){
                $sub->whereDoesntHave('subscription');
            }
        })
        ->with('subscription')
        ->paginate($length)->onEachSide(1);

        return response()
        ->json($client);
    }

    public function userActivation(Request $request){
        $user = User::with('subscription')->find($request->id);
        
        return Inertia::render('Admin/UserManajemen/Activation',[
            'user' => $user
        ]);
    }

    public function activate(Request $request){
        
        try {
            
            $data = $request->validate([
                'user_id' => 'required',
                'date' => 'required'
            ]);

            ClientBilling::updateOrCreate(
                ['user_id' => $data['user_id']],
                ['expired_at' => $data['date']]
            );

            return response()
            ->json([
                'message' => 'Berhasil menambahkan billing'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()
            ->json([
                "message" => 'Gagal menambahkan billing'
            ],500);
        }

    }


    
}
