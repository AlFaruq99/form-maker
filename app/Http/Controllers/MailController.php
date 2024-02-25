<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use GuzzleHttp\Client;
use Inertia\Inertia;

class MailController extends Controller
{

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
            
            
            return response()
            ->json([
                "message" => 'Berhasil mengirim email'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
