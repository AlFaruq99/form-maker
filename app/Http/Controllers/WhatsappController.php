<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
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
        $waInstance = WaUser::where('user_id',Auth::user()->id)->first();
        $client = new Client;
        $response = $client->request('GET', env('VITE_TIBOT_API').'/set_webhook',[
            "query" => [
                "webhook_url" => env('NGROK_URL_TUNELLING').'/webhook/get_webhook',
                "enable" => true,
                "instance_id" => $waInstance->instance_id??null,
                "access_token" => env("VITE_WA_ACCESS"),
            ]
        ]);


        $response = json_decode($response->getBody()->getContents());
        if ($response->status == 'error') {
            WaUser::where('user_id',Auth::user()->id)->delete();
        }
        return $response;
    }

    public function sendMessage(Request $request, int $form_id){

        try {
            $phone = $request->phone??null;
            $formulir = Formulir::with('user')->find($form_id);
            $user = $formulir->user;
            $waInstance = WaUser::where('user_id',$user->id)->first();
            
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);
            
            $response = $client->post(env('VITE_TIBOT_API').'/send',
                ['body' => json_encode(
                    [
                        "number"=> $phone,
                        "type"=> "text",
                        "message"=> "Jawaban anda telah kami simpan"."\r\n\r\n"."Form-maker: ".$formulir->title."\r\n"."Tanggal ".date('d-M-Y')."\r\n".date('H:i:s'),
                        "instance_id"=> $waInstance->instance_id,
                        "access_token"=> env('VITE_WA_ACCESS')
                    ]
                )]
            );
            $response = json_decode($response->getBody()->getContents());

            if ($response->status == 'success') {
                return response()
                ->json([
                    "message" => 'Berhasil mengirim pesan'
                ]);
            }else{
                return response()
                ->json([
                    "message" => 'Gagal mengirim pesan'
                ],500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
