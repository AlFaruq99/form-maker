<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

use App\Models\Invoices as InvoiceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function statusValidate($status){
        $status = $status??'belum_bayar';
        $statusList = ['belum_bayar','dp','lunas'];
        if (!in_array($status,$statusList)) {
            return false;
        }

        switch ($status) {
            case 'belum_bayar':
                    return [
                        "value" => 'belum_bayar',
                        "text" => 'Belum Bayar'
                    ];
                break;
            case 'dp':
                    return [
                        'value' => 'dp',
                        "text" => 'DP'
                    ];
                break;
            case 'lunas':
                    return [
                        'value' => 'lunas',
                        "text" => 'Lunas'
                    ];
                break;
        }
    }

    public function index(Request $request){
        
        $status = $this->statusValidate($request->status);
        if ($status == false) {
            return abort(404);
        }
        return Inertia::render('Admin/InvoiceManajemen/Index',[
            'status' => $status
        ]);
    }

    public function create(Request $request){
        $status = $this->statusValidate($request->status);
        if ($status == false) {
            return abort(404);
        }
        return Inertia::render('Admin/InvoiceManajemen/Create',[
            'status' => $status
        ]);
    }

    public function store(Request $request){
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

            $invoice = InvoiceModel::create($invoiceData);


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
        $dari = new Party([
            'name'          => 'Roosevelt Lloyd',
            'phone'         => '(520) 318-9486',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);
        
        $kepada = new Party([
            'name'          => 'Ashley Medina',
            'address'       => 'The Green Street 12',
            'code'          => '#22663214',
            'custom_fields' => [
                'order number' => '> 654321 <',
            ],
        ]);
        $items = [
            InvoiceItem::make('Service 1')
                ->description('Your product or service description')
                ->pricePerUnit(47.79)
                ->quantity(2)
                ->discount(10),
            InvoiceItem::make('Service 2')->pricePerUnit(71.96)->quantity(2)->tax(8),
            InvoiceItem::make('Service 3')->pricePerUnit(4.56),
            InvoiceItem::make('Service 4')->pricePerUnit(87.51)->quantity(7)->discount(4)->units('kg'),
            InvoiceItem::make('Service 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
            InvoiceItem::make('Service 6')->pricePerUnit(76.32)->quantity(9),
            InvoiceItem::make('Service 7')->pricePerUnit(58.18)->quantity(3)->discount(3),
            InvoiceItem::make('Service 8')->pricePerUnit(42.99)->quantity(4)->discountByPercent(3),
            InvoiceItem::make('Service 9')->pricePerUnit(33.24)->quantity(6)->units('m2'),
            InvoiceItem::make('Service 11')->pricePerUnit(97.45)->quantity(2),
            InvoiceItem::make('Service 12')->pricePerUnit(92.82),
            InvoiceItem::make('Service 13')->pricePerUnit(12.98),
            InvoiceItem::make('Service 14')->pricePerUnit(160)->units('hours'),
            InvoiceItem::make('Service 15')->pricePerUnit(62.21)->discountByPercent(5),
            InvoiceItem::make('Service 16')->pricePerUnit(2.80),
            InvoiceItem::make('Service 17')->pricePerUnit(56.21),
            InvoiceItem::make('Service 18')->pricePerUnit(66.81)->discountByPercent(8),
            InvoiceItem::make('Service 19')->pricePerUnit(76.37),
            InvoiceItem::make('Service 20')->pricePerUnit(55.80),
        ];
        
        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);
        
        $invoice = Invoice::make('receipt')
            ->series('BIG')
            ->status(__('BELUM BAYAR'))
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($dari)
            ->buyer($kepada)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('Rp.')
            ->currencyCode('IDR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($dari->name . ' ' . $kepada->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            ->save('public');
        
            $invoice->save('public');
            $link = Storage::url($dari->name . ' ' . $kepada->name).'.pdf';
            return $link;
    }
}