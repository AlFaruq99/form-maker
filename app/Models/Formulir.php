<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'content',
        'background',
        'url'
    ];

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
