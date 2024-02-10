<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['formulir_id','answer'];

    public function question(){
        return $this->belongsTo(Formulir::class,'formulir_id','id');
    }
    
}
