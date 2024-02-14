<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAsset extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'no_invoice',
        'produk',
        'description',
        'qty',
        'unit',
        'price',
        'discount',
        'tax',
        'total'
    ];
}
