<?php

namespace App\Models;

use App\Models\HistoricPaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $guarded = [];


    /********************************************RELATIONSHIP************************************************/
    public function historicPaymentMethod(): HasMany
    {
        return $this->hasMany(HistoricPaymentMethod::class, 'payment_method_id');
    }

}
