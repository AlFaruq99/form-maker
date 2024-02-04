<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBilling extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','expired_at'];
}
