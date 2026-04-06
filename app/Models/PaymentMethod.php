<?php

namespace App\Models;

use App\Models\HistoricPaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaymentMethod extends Model
{
    protected $guarded = [];


    /********************************************RELATIONSHIP************************************************/
    public function historicCompanies(): BelongsToMany
    {
        return $this->belongsToMany(HistoricCompany::class, 'historic_payment_methods')
            ->withPivot('value_paid')
            ->withTimestamps();
    }
}
