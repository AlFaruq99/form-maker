<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMailConfig extends Model
{
    use HasFactory;
    protected $table = 'user_mail_config';
    protected $fillable = ['user_id','mail_token'];

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
