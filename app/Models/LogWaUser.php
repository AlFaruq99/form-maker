<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogWaUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'summary_id',
        'dest_num',
        'broadcast',
        'message',
        'status',
        'tipe',
        'tgl_dikirim',
    ];
}
