<?php

namespace App\Http\Controllers;

use App\Models\ClientBilling;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ClientManajemen extends Controller
{
    public function index(Request $request){

        $totalClient = User::with('role')
        ->whereHas('role',function($sub){
            $sub->where('level','client');
        })
        ->count();

        $clientActive = User::with('role','subscription')
        ->whereHas('role',function($sub){
            $sub->where('level','client');
        })
        ->whereHas('subscription',function($sub){
            $sub->where('expired_at','>',date('Y-m-d'));
        })
        ->count();

        $clientInactive = User::with('role')
        ->whereHas('role',function($sub){
            $sub->where('level','client');
        })
        ->where(function($sub){
            $sub->whereHas('subscription',function($subItem){
                $subItem->where('expired_at','<',date('Y-m-d'));
            })
            ->orWhereDoesntHave('subscription');
        })
        ->count();

        return Inertia::render(
            'Admin/UserManajemen/Index',[
                'total_client' => $totalClient,
                'client_active' => $clientActive,
                'client_inactive' => $clientInactive
            ]
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
                $sub->whereDoesntHave('subscription')
                ->orWhereHas('subscription',function($sub) {
                    $sub->where('expired_at','<',date('Y-m-d'));
                });
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

    public function create(){
        return Inertia::render('Admin/UserManajemen/Create');
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {

            $data = $request->validate([
                'nama' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|same:confirm_password',
                'confirm_password' => 'required|min:6',
                'level' => 'required|string',
                'tgl_exp' => 'nullable'
            ]);

            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            $level = Role::create([
                'user_id' => $user->id,
                'level' => $data['level']
            ]);

            $subsription = Subscription::create([
                'user_id' => $user->id,
                'expired_at' => $data['tgl_exp']
            ]);

            DB::commit();
            return response()
            ->json([
                "message" => 'Berhasil membuat pengguna'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }
    
}
