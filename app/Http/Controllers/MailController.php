<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Models\Invoices;
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
        $this->send($request, $invoicePath);

    }

    private function send(MailRequest $request, string $filePath){
        try {
            $params = $request->all();

            $client = new Client();
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];
            $request = $client->request('POST', env('VITE_API_MAILKETING').'/v1/send', [
                'headers' => $headers,
                'form_params' => [
                    'api_token' => env('VITE_MAILKETING_TOKEN'),
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
}
