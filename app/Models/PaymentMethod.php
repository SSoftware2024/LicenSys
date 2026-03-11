<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
     protected $guarded = [];


    public function paymentPaymentMethod(): HasMany
    {
        return $this->hasMany(PaymentPaymentMethod::class);
    }
}
