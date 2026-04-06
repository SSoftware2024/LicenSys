<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model_Pivot
 *  1 - historic_companies
 *  2 - payment_methods
 */
class HistoricPaymentMethod extends Model
{
    protected $guarded = [];


    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
