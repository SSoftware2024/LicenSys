<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HistoricCompany extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    /********************************************RELATIONSHIP************************************************/
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function paymentMethods(): BelongsToMany
    {
        return $this->belongsToMany(PaymentMethod::class, 'historic_payment_methods');
    }


    /********************************************CUSTOM METHODS************************************************/






}
