<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{

    public function sendInvoice(InvoiceController $invoiceController, MailRequest $request){
        $params = $request->all();
        $invoicePath = $invoiceController->invoicePath($params['id']);
        $this->send($request, $invoicePath);

    }

    private function send(MailRequest $request, string $filePath){
        $params = $request->all();

        $client = new Client();

        $request = $client->request('POST', env('VITE_API_MAILKETING').'/v1/send', [
            'multipart' => [
                [
                    'name' => 'api_token',
                    'contents' => env('VITE_MAILKETING_TOKEN')
                ],
                [
                    'name'     => 'from_name',
                    'contents' => $params['from_name'],
                ],
                [
                    'name'     => 'from_email',
                    'contents' => $params['from_email']
                ],
                [
                    'name' => 'recipient',
                    'contents' => $params['recipient']
                ],
                [
                    'name' => 'subject',
                    'contents' => $params['subject']
                ],
                [
                    'name' => 'content',
                    'contents' => $params['content']
                ],
                [
                    'name' => 'attach1',
                    'contents' => $filePath
                ],
            ]
        ]);

        $response = $request->getBody()->getContents();
        Log::info($response);
        return response()
        ->json([
            "message" => 'Berhasil mengirim email'
        ]);
    }
}
