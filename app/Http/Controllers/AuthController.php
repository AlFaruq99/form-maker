<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(){
        return Inertia::render('Auth/Login');
    }

    public function register(){
        return Inertia::render('Auth/Register');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::with('role')->find(Auth::user()->id);
            if ($user->role->level == 'admin') {
                return redirect()->intended('panel/dashboard');
            }else if($user->role->level == 'client'){
                return redirect()->intended('client/dashboard');
            }
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function registerProcess(RegisterRequest $request){
        DB::beginTransaction();
        try {
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'wa_number' => $request->whatsapp_number,
            ]);

            Role::create([
                'user_id' => $user->id,
                'level' => 'client'
            ]);

            DB::commit();
            Auth::login($user);
            $request->session()->regenerate();
            $user = User::with('role')->find(Auth::user()->id);
            if ($user->role->level == 'admin') {
                return redirect()->intended('panel/dashboard');
            }else if($user->role->level == 'client'){
                return redirect()->intended('client/dashboard');
            }
            
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function resetPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $client = new Client();
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];
            $request = $client->request('POST', env('VITE_API_MAILKETING').'/v1/send', [
                'headers' => $headers,
                'form_params' => [
                    'api_token' => env('VITE_MAILKETING_TOKEN','9b4554bae944b0bf9e7f4b8150bc1bd8'),
                    'from_name' => 'noreply@tiltas.id',
                    'from_email' => 'noreply@tiltas.id',
                    'recipient' => $request->email,
                    'subject' => 'password reset',
                    'content' => route('passwordResetPage')
                ]
            ]);
    }

    public function resetPasswordProcess(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $user = User::where('email',$request->email)->first();
        if (!isset($user)) {
            return response()
            ->json([
                'message' => 'No email found'
            ],400);
        }

        $password = Hash::make($request->password);
        
        User::find($user->id)->update([
            'password' => $password
        ]);

        return response()
        ->json([
            'message' => 'user updated'
        ]);


       
    }
}
