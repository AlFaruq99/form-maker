<?php

namespace App\Http\Controllers;

use App\Models\LogWaSummary;
use App\Models\LogWaUser;
use App\Models\WaUser;
use App\Models\WaWebhook;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WaWebhookController extends Controller
{

    private $user;
    private $urlWebhook;

    public function __construct()
    {
        $this->user = Auth::user();
        if ($this->user) {
            $webhook = WaWebhook::where('user_id',$this->user->id)
            ->first();
    
            if (isset($webhook)) {
                $this->urlWebhook = $webhook->url_webhook;
            }
        }

    }

    public function getWebhook(string $instanceId, string $accessToken){

        try {
            
            if (!isset($this->urlWebhook)) {
                $this->urlWebhook = env('APP_URL')."/api/wa/webhook/{$this->user->id}";    
                $requestData = [
                    'url_webhook' => $this->urlWebhook
                ];
                $request = new Request($requestData);
                $this->store($request);
            }
            $client = new Client();
            $query = [
                "webhook_url" => $this->urlWebhook,
                "enable" => 'true',
                "access_token" => $accessToken,
                "instance_id" => $instanceId
            ];
            
            Log::info('trying connect webhook wa',$query);
            $response = $client->request('GET', env('VITE_TIBOT_API').'/set_webhook',[
                "query" => $query
            ]);
            $response = json_decode($response->getBody()->getContents(),true);
            if ($response['status'] == 'success') {
                return $response;
            }else{
                Log::error('Gagal menautkan aplikasi',$response);
                throw new Exception($response['message'], 1);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request){
        try {
            WaWebhook::create([
                'user_id' => $this->user->id,
                'url_webhook' => $request->url_webhook
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function receiveWebhook(Request $request){
        DB::beginTransaction();
        try {
                $content = $request->getContent();
                $response = json_decode($content, true);
                Log::info('webhook response', $response);   

                $instanceId = $response['instance_id'];

                $userId = WaUser::where('instance_id',$instanceId)->first();

                $logWaSum = LogWaSummary::where('user_id',$userId->user_id)
                ->first();

                if (!isset($logWaSum)) {
                    
                    $logWaSum = LogWaSummary::create([
                        'user_id' => $userId->user_id,
                        'total_message' => 1
                    ]);
                }else{
                    $logWaSum->total_message = $logWaSum->total_message + 1;
                    $logWaSum->save();
                }


                $dataResponse = $response['data']['data'];
                $clientMessages = $dataResponse['messages']??[];
                foreach ($clientMessages as $key => $value) {
                    $key = $value['key'];

                    if (isset($key)) {
                        $parts = explode('@', $key['remoteJid']);
                        $number = $parts[0];
                        
                        LogWaUser::create([
                            'summary_id' => $logWaSum->id,
                            'dest_num' => $number,
                            'broadcast' => $value['broadcast']??true,
                            'message' => $value['message']['conversation'],
                            'status' => $value['status'],
                            'tipe' => $dataResponse['type'],
                            'tgl_dikirim' =>  date('Y-m-d H:i:s', $value['messageTimestamp']),
                        ]);
                    }
                }

                DB::commit();
                Log::info('sukses menerima webhook');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal memenrima webhook',['message' => $th->getMessage()]);
        }

        
    }
}
