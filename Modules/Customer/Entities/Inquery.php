<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquery extends Model
{
    use HasFactory;

    protected $fillable = ['name','number','email','subject','message','type'];

    protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\InqueryFactory::new();
    }
}
