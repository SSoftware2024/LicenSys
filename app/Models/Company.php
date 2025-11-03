<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\GroupCompany;
use App\Models\HistoricCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = [
        'created_by_user_name',
        'updated_by_user_name',
    ];

    public function groupCompany(): BelongsTo
    {
        return $this->belongsTo(GroupCompany::class);
    }

    public function historicCompany(): HasMany
    {
        return $this->hasMany(HistoricCompany::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
    /********************************************ACESSOR & MUTATORS************************************************/
    public function createdByUserName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->createdByUser()->first()?->name,
        );
    }
    public function updatedByUserName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->updatedByUser()->first()?->name,
        );
    }

    /********************************************CUSTOM METHODS************************************************/
    /**
     * uuidExists
     *
     * Verfica se o UUID existe na base de dados, caso exista gera um novo UUID até encontrar um que não exista.
     * @return string
     */
    public static function uuidExists(): string
    {
        do {
            $uuid = (string) Str::uuid();
        } while (self::where('uuid', $uuid)->exists());
        return $uuid;
    }
}
