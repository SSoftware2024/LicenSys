<?php

namespace App\Models;

use App\Models\GroupCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use SoftDeletes;


    public function groupCompany(): BelongsTo
    {
        return $this->belongsTo(GroupCompany::class);
    }
}
