<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'instance_id',
        'last_login',
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
