<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRegister;
use App\Http\Requests\MailRequest;
use App\Models\Invoices;
use App\Models\User;
use App\Models\UserMailConfig;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use LaravelDaily\Invoices\Facades\Invoice;

class MailController extends Controller
{

    public function sendMailPage(int $id){
        $userRole = Auth::user()->role->level;
        $invoice = Invoices::with('file')->where('id',$id)
        ->first();

        return Inertia::render(
            'Mail/SendMail',
            [
                'userRole' => $userRole,
                'data' => $invoice
            ]
        );
    }

    public function sendInvoice(InvoiceController $invoiceController, MailRequest $request){
        $params = $request->all();
        $invoicePath = $invoiceController->invoicePath($params['id']);
        $send = $this->send($request, $invoicePath);
        $message = json_decode($send->content(),true);
        return response()
        ->json([
            'message' => $message['message']??''
        ],$send->getStatusCode());
    }

    private function send(MailRequest $request, string $filePath){
       
        try {
            $params = $request->all();

            $user = User::with('mail_token')
            ->where('id',Auth::user()->id)
            ->first();

            
            $mailToken = $user->mail_token->mail_token;
            
            if (!isset($user->mail_token)) {
                return response()
                ->json([
                    "message" => 'User token tidak ditemukan'
                ],500);
            }

            $client = new Client();
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];
            $request = $client->request('POST', env('VITE_API_MAILKETING').'/v1/send', [
                'headers' => $headers,
                'form_params' => [
                    'api_token' => $mailToken,
                    'from_name' => $params['from_name'],
                    'from_email' => $params['from_email'],
                    'recipient' => $params['recipient'],
                    'subject' => $params['subject'],
                    'content' => $params['content'],
                    'attach1' => $filePath
                ]
            ]);

            $response = $request->getBody()->getContents();
            Log::info('',json_decode($response,true));
            return response()
            ->json(json_decode($response,true));
            
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()
            ->json([
                "message" => 'Gagal mengirim email'
            ],500);
        }
    }

    public function register(MailRegister $request){
        try {
            dd($request->all());

            UserMailConfig::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                ],
                [
                    'mail_token' => $request->token
                ]
            );
            return response()
            ->json([
                'message' => 'success add mail token'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()
            ->json([
                'message' => 'success add mail token',
                'description' => $th->getMessage()
            ],500);
        }
    }
}
