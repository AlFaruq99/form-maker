<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

use App\Models\Invoices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function index(){
        return Inertia::render('Admin/InvoiceManajemen/Index');
    }

    public function createInvoice(Request $request){
        DB::beginTransaction();
        try{
            $data = $request->validate([
                'no_invoice' => 'required|string',
                'transaction_date' => 'required|date',
                'due_date' => 'required|date',
                'file' => 'required',
                'invoice_name' => 'required|string',
                's_company_name' => 'required|string',
                's_company_address' => 'required|string',
                's_phone_number' => 'required|string',
                's_email' => 'required',
                'client_id' => 'required',
                'd_company_name' => 'required|string',
                'd_company_address' => 'required|string',
                'd_phone_number' => 'required|string',
                'd_email' => 'required',
                'note' => 'nullable|string',
                'subtotal' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'tax' => 'nullable|numeric',
                'total' => 'nullable|numeric',
            ]);

            $invoiceData = [
                'no_invoice' => $data['no_invoice'],
                'transaction_date' => $data['transaction_date'],
                'due_date' => $data['due_date'],
                'file_path' => $data['file'],
                'invoice_name' => $data['invoice_name']??null,
                's_company_name' => $data['s_company_name']??null,
                's_company_address' => $data['s_company_address']??null,
                's_phone_number' => $data['s_phone_number']??null,
                's_email' => $data['s_email']??null,
                'client_id' => $data['client_id'],
                'd_company_name' => $data['d_company_name']??null,
                'd_company_address' => $data['d_company_address']??null,
                'd_phone_number' => $data['d_phone_number']??null,
                'd_email' => $data['d_email']??null,
                'note' => $data['note']??null,
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'tax' => $data['tax'],
                'total' => $data['total'],
            ];

            $invoiceData = array_filter($invoiceData);

            $invoice = Invoice::create($invoiceData);


            DB::commit();
            return response()
                ->json([
                    "message" => 'Berhasil Membuat Invoice',
                    "invoice_url" => route('invoice.show', ['invoice' => $invoice->id])
                ]);
        }catch(\Throwable $error){
            DB::rollBack();
            Log::error($error->getMessage());
            throw $error;
        }
    }

    public function stream() {
        $customer = new Buyer([
            'name'          => 'John Doe',
            'custom_fields' => [
                'email' => 'test@example.com',
            ],
        ]);
        
        $item = InvoiceItem::make('Service 1')->pricePerUnit(2);
        
        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item);
        return $invoice->toHtml();
    }
}