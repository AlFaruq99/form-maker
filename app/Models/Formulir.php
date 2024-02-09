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
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function answer(){
        return $this->hasMany(FormAnswer::class,'formulir_id','id');
    }

    public function shortLink(){
        return $this->hasOne(ShortLink::class,'short_url','url');
    }
}
