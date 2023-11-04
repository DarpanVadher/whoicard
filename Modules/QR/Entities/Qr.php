<?php

namespace Modules\QR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class qr extends Model
{
    use HasFactory;

    protected $fillable = ['filename','format','identifier','link','qrcode','scan','state','created_by','updated_by'];

    protected static function newFactory()
    {
        return \Modules\QR\Database\factories\QrFactory::new();
    }
}
