<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'no_invoice',
        'status',
        'transaction_date',
        'due_date',
        'file_path',
        's_company_name',
        's_company_address',
        's_phone_number',
        's_email',
        'd_company_name',
        'd_company_address',
        'd_phone_number',
        'd_email',
        'note',
        'subtotal',
        'discount',
        'tax',
        'total',
    ];

    public function item(){
        return $this->hasMany(InvoiceAsset::class,'invoice_id','id');
    }
}
