<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceFile extends Model
{
    use HasFactory;
    protected $table = 'invoice_files';
    protected $fillable = ['invoice_id','filename','path'];

    public function invoice(){
        return $this->belongsTo(Invoices::class,'id','invoice_id');
    }
}
