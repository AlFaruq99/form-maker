<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_invoice', 
        'transaction_date', 
        'due_date', 
        'url',
        'invoice_name',
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
        'total'
    ];

    public function content(){
        return $this.belongsTo(InvoiceAsset::class,'no_invoice','no_invoice');
    }
}
