<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class WhatsappController extends Controller
{
    public function index(){
        return Inertia::render('Client/Whatsapp/Index');
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
            $generateQrCode = $this->getQrCode($instance->instance_id);
            Log::info($instance->instance_id);
            return response()
            ->json($generateQrCode);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
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
}
