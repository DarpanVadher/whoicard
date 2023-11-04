<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class customer_documents extends Model
{
    use HasFactory;

    protected $fillable = ['fileName', 'fileUrl','fileType','fileSize','customer_id'];

    protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\DocumentsFactory::new();
    }
}
