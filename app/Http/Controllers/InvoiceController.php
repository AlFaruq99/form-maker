<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InvoiceAsset;
use App\Models\InvoiceFile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

use App\Models\Invoices as InvoiceModel;
use App\Models\User;
use App\Service\PhoneService;
use Illuminate\Support\Facades\Auth;
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
            'status' => $status,
            'userId' => Auth::user()->id
        ]);
    }


    public function clientIndex(Request $request){
        
        $status = $this->statusValidate($request->status);
        if ($status == false) {
            return abort(404);
        }
        return Inertia::render('Client/InvoiceManajemen/Index',[
            'status' => $status,
            'userId' => Auth::user()->id
        ]);
    }

    
    /**
     * @return String
     */
    private function createNoInvoice(){
        $user = User::find(Auth::user()->id);
        $latestInvoice = InvoiceModel::orderBy('id','Desc')->where('client_id',$user->id)
        ->first();

        $latestNumber = null;
        if ($latestInvoice == null) {
            $latestNumber = 1;
        } else{
            $latestNumber = $latestInvoice->id;
        }
        $invoiceGenerator = new Invoice();
    
        $invoiceGenerator = $invoiceGenerator->series('INV')
        ->sequence(date('Y'))
        ->delimiter('/');

        return date('Y')."/INV/$user->id/".$latestNumber;
    }

    /**
     * @param Request
     * @return Inertia
     */
    public function create(Request $request){
        $noInvoice = $this->createNoInvoice();
        $status = $this->statusValidate($request->status);
        if ($status == false) {
            return abort(404);
        }
        return Inertia::render('Admin/InvoiceManajemen/Create',[
            'status' => $status,
            'no_invoice' => $noInvoice
        ]);
    }
    
    public function clientCreate(Request $request){
        $noInvoice = $this->createNoInvoice();
        $status = $this->statusValidate($request->status);
        if ($status == false) {
            return abort(404);
        }
        return Inertia::render('Client/InvoiceManajemen/Create',[
            'status' => $status,
            'no_invoice' => $noInvoice
        ]);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{

            $uploadedFile = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $uploadedFile = Storage::disk('image')->put('',$file);
            }

            $data = $request->validate([
                'status' => 'required|string',
                'no_invoice' => 'required|string',
                'transaksiDate' => 'required|string',
                'dueDate' => 'required|string',
                's_company_name' => 'nullable|string',
                's_company_address' => 'nullable|string',
                's_phone_number' => 'nullable|string',
                's_email' => 'nullable|string',
                'd_company_name' => 'nullable|string',
                'd_company_address' => 'nullable|string',
                'd_phone_number' => 'nullable|string',
                'd_email' => 'nullable|string',
                'note' => 'nullable|string',
                'subtotal' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'tax' => 'nullable|numeric',
                'total' => 'nullable|numeric',
            ]);

            $invoiceData = [
                'status' => $data['status'],
                'no_invoice' => $data['no_invoice'],
                'transaction_date' => $data['transaksiDate'],
                'due_date' => $data['dueDate'],
                'invoice_name' => $data['invoice_name']??null,
                's_company_name' => $data['s_company_name']??null,
                's_company_address' => $data['s_company_address']??null,
                's_phone_number' => PhoneService::formatNumber($data['s_phone_number']),
                's_email' => $data['s_email']??null,
                'client_id' => Auth::user()->id,
                'd_company_name' => $data['d_company_name']??null,
                'd_company_address' => $data['d_company_address']??null,
                'd_phone_number' => PhoneService::formatNumber($data['d_phone_number']),
                'd_email' => $data['d_email']??null,
                'note' => $data['note']??null,
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'tax' => $data['tax'],
                'total' => $data['total'],
                'file_path' => $uploadedFile
            ];

            $invoiceData = array_filter($invoiceData);
            $invoice = InvoiceModel::create($invoiceData);

            $invoiceRow = $request->rows;
            $invoiceItem = array_map(function($item) use($invoiceData,$invoice){
                return [
                    'invoice_id' => $invoice->id,
                    'no_invoice' => $invoiceData['no_invoice'],
                    'produk' => $item['produk']??'-',
                    'description' => $item['description']??'-',
                    'qty' => $item['quantity']??0,
                    'unit' => $item['unit']??0,
                    'price' => $item['price']??0,
                    'discount' => $item['discount']??0,
                    'tax' => $item['tax']??0,
                    'total'=> $item['total']??0,
                ];
            },$invoiceRow);

            foreach ($invoiceItem as $key => $value) {
                InvoiceAsset::create($value);
            }
            DB::commit();
            Log::info('Data created',[$invoiceData,$invoiceItem]);
            return response()
            ->json([
                "message" => 'Berhasil Membuat Invoice',
            ]);
        }catch(\Throwable $error){
            DB::rollBack();
            Log::error($error->getMessage());
            return response()
            ->json([
                'message' => 'Gagal membuat data',
            ],500);
        }
    }


    public function update(Request $request){
        try {
        
            $listId = $request->listId;
            $status = $request->status;
            foreach ($listId as $key => $value) {
                $invoice = InvoiceModel::with('file')->find($value);
                $invoice->status = $status;
                $invoice->save();

                $items = InvoiceAsset::where('invoice_id',$invoice->id)->get();
                $filePath = storage_path('app/public/image/').$invoice->file_path;
                $fileInvoice = $this->createInvoice($invoice->toArray(), $items->toArray(), $filePath);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function createInvoice(array $invoice, array $item, string $filePath = null) {
        $dari = new Party([
            'name'          => $invoice['s_company_name']??'',
            'phone'         => $invoice['s_phone_number']??'',
            'email'         => $invoice['s_email']??'',
            'address'       => $invoice['s_company_address']??'',
        ]);
        
        $kepada = new Party([
            'name'          => $invoice['d_company_name']??'',
            'phone'       => $invoice['d_phone_number']??'',
            'email'         => $invoice['d_email']??'',
            'address'       => $invoice['d_company_address']??'',
        ]);


        foreach ($item as $key => $value) {
            $items[] = 
                InvoiceItem::make($value['produk'])
                    ->description($value['description'])
                    ->pricePerUnit($value['price'])
                    ->quantity($value['qty'])
                    ->discount(($value['price'] * $value['discount'] / 100))
                    ->tax(($value['price'] * $value['tax'] / 100))
                    ->subTotalPrice($value['total'])
            ;
        }
        
        $notes = $invoice['note']??'';
        $status = $this->statusValidate($invoice['status']);
        $invoiceNameFile = $dari->name . '_' . $kepada->name.'_'.$invoice['no_invoice'];


        $invoiceCreate = Invoice::make('invoice')
            ->serialNumberCustom($invoice['no_invoice'])
            ->status($status['text'])
            ->seller($dari)
            ->buyer($kepada)
            ->date(now())
            ->dateFormat('m/d/Y')
            ->payUntilDays(3)
            ->currencySymbol('Rp.')
            ->currencyCode('IDR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($invoiceNameFile)
            ->addItems($items)
            ->notes($notes);
            if (isset($filePath)) {
                $invoiceCreate->logo($filePath);
            }
            
            $invoiceCreate->save('invoice');
            
            $link = storage_path('app/public/invoice/').$invoiceNameFile.'.pdf';

            $invoiceFileCreate = InvoiceFile::create([
                'invoice_id' => $invoice['id'],
                'filename' => $invoiceNameFile.'.pdf',
                'path' => $link
            ]);
            return $link;
    }


    public function destroy(Request $request){
        $idInvoice = $request->list;

        if (!isset($idInvoice) || count($idInvoice) < 1) {
            return response()
            ->json([
                'message' => 'data invoice tidak ditemukan'
            ],400);
        }

        try {
            
            InvoiceModel::whereIn('id',$idInvoice)
            ->delete();
            return response()
            ->json([
                'message' => 'data berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()
            ->json([
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function fetchInvoice(Request $request){
        $status = $this->statusValidate($request->status);
        $search = $request->search??null;
        $length = $request->length ?? 10;
        $userId = $request->user_id;

        if ($status == false) {
            return response()
            ->json([
                'message' => 'no data available'
            ],400);
        }

        $invoice = InvoiceModel::with('item')
        ->when($search, function($sub) use($search){
            $sub->where('s_company_name','ilike',"%$search%")
            ->orwhere('d_company_name','ilike',"%$search%");
        })
        
        ->where('client_id',$userId)
        ->where('status',$status['value'])
        ->paginate($length);

        return response()
        ->json($invoice);

    }

    public function download($invoice_id){
        try {
            $invoice = InvoiceModel::with('file')->find($invoice_id);
            $items = InvoiceAsset::where('invoice_id',$invoice->id)->get();
            $filePath = storage_path('app/public/image/').$invoice->file_path;
            $fileInvoice = $this->createInvoice($invoice->toArray(), $items->toArray(), $filePath);
            return response()->download($fileInvoice);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    

    public function sendMedia(WhatsappController $whatsappController, Request $request){
        try {
            $invoiceId = $request->id;
            $invoice = InvoiceModel::with('file')
            ->find($invoiceId);
            $fileName = $invoice->file->filename;

            $filePath =  Storage::disk('invoice')->url($fileName);
            
            $data = $request->all();
            $whatsappController->sendMediaMessage($data, $filePath);
            return response()
            ->json([
                "message" => 'Berhasil mengirim file'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}