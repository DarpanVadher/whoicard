<?php

namespace Modules\SiteSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfileTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name','value'];

    protected static function newFactory()
    {
        return \Modules\SiteSetting\Database\factories\ProfileTemplateFactory::new();
    }
}
