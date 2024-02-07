<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WaUser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class WhatsappController extends Controller
{
    public function index(){
        $user = User::with('wa_instance')->find(Auth::user()->id);
        $clientWaStatus = $this->getClientWaStatus();
        $status = $clientWaStatus->status == 'success' ? 'online' : 'offline';
        return Inertia::render('Client/Whatsapp/Index',[
            'status-prop' => $status
        ]);
    }

    public function getInstanceToken(){
        try {
            $client = new Client;
            $response = $client->request('GET', env('VITE_TIBOT_API').'/create_instance',[
                "query" => [
                    "access_token" => env("VITE_WA_ACCESS")
                ]
            ]);
            $instance = json_decode($response->getBody()->getContents());
            $instanceId = $instance->instance_id;
            
            
            $generateQrCode = $this->getQrCode($instance->instance_id);
            $storeInstance = $this->storeInstance($instanceId, Auth::user()->id);
            
            return response()
            ->json($generateQrCode);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function storeInstance($instanceId, $userId){
        try {
            WaUser::updateOrCreate(
                [
                    'user_id' => $userId,
                ],
                [
                    'instance_id' => $instanceId,
                    'last_login' => date('Y-m-d H:i:s')
                ]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getQrCode($instance){
       try {
        $client = new Client;
        $response = $client->request('GET', env('VITE_TIBOT_API').'/get_qrcode',[
            "query" => [
                "instance_id" => $instance,
                "access_token" => env("VITE_WA_ACCESS")
            ]
        ]);
        $response = json_decode($response->getBody()->getContents());
        return $response;
       } catch (\Throwable $th) {
        Log::error($th->getMessage());
        throw $th;
       }
    }

    public function addWebhook(){
        try {
            
            $response = $this->getClientWaStatus();
            if ($response->status == 'success') {
                return response()
                ->json([
                    "message" => "user aktif"
                ]);
            }else{
                return response()
                ->json([
                    "message" => "user tidak aktif"
                ],500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getClientWaStatus(){
        $user = User::with('wa_instance')->find(Auth::user()->id);

        $client = new Client;
        $response = $client->request('GET', env('VITE_TIBOT_API').'/set_webhook',[
            "query" => [
                "webhook_url" => env('NGROK_URL_TUNELLING').'/webhook/get_webhook',
                "enable" => true,
                "instance_id" => $user->wa_instance->instance_id,
                "access_token" => env("VITE_WA_ACCESS"),
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
}
