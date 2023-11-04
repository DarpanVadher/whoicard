<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\QR\Entities\qr;

class customer extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','number','profileImage','username','password','info','documents','indentifier'];

    protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\CustomerFactory::new();
    }


    public function customer_documents(): HasMany
    {
        return $this->hasMany(customer_documents::class);
    }

    public function customer_qr() : HasOne
    {

        return $this->HasOne(qr::class);
    }
}
