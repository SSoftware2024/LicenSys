<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    protected $guarded = [];
    /********************************************RELATIONSHIP************************************************/
    public function historicCompany(): BelongsTo
    {
        return $this->belongsTo(HistoricCompany::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
