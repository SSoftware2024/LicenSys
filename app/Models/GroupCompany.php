<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupCompany extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    // Relationships
    public function company(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
