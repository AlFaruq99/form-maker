<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index(){
        return Inertia::render('Admin/InvoiceManajemen/Index');
    }

    public function createInvoice(Request $request){
        try{
            $data = $request->validate([
                'no_invoice' => 'required|string',
                'transaction_date' => 'required|date',
                'due_date' => 'required|date',
                'url' => 'required|url',
                'invoice_name' => 'required|string',
                's_company_name' => 'required|string',
                's_company_address' => 'required|string',
                's_phone_number' => 'required|string',
                's_email' => 'required|email',
                'd_company_name' => 'required|string',
                'd_company_address' => 'required|string',
                'd_phone_number' => 'required|string',
                'd_email' => 'required|email',
                'note' => 'nullable|string',
                'subtotal' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'tax' => 'nullable|numeric',
                'total' => 'nullable|numeric',
            ]);
            $invoice = Invoice::create([
                'no_invoice' => $data['no_invoice'],
                'transaction_date' => $data['transaction_date'],
                'due_date' => $data['due_date'],
                'url' => $data['url'],
                'invoice_name' => $data['invoice_name'],
                's_company_name' => $data['s_company_name'],
                's_company_address' => $data['s_company_address'],
                's_phone_number' => $data['s_phone_number'],
                's_email' => $data['s_email'],
                'd_company_name' => $data['d_company_name'],
                'd_company_address' => $data['d_company_address'],
                'd_phone_number' => $data['d_phone_number'],
                'd_email' => $data['d_email'],
                'note' => $data['note'],
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'tax' => $data['tax'],
                'total' => $data['total'],
            ]);
        
            return response()
                ->json([
                    "message" => 'Berhasil Membuat Invoice',
                    "invoice_url" => route('invoice.show', ['invoice' => $invoice->id])
                ]);
        }catch(\Throwable $error){
            Log::error($error->getMessage());
            throw $error;
        }
    }

    public function show($no_invoice){
        $invoice = Invoice::findOrFail($no_invoice);
        return Inertia::render('Admin/InvoiceManajemen/Show', [
            'invoice' => $invoice,
        ]);
    }
}