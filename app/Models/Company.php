<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\GroupCompany;
use App\Models\HistoricCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function groupCompany(): BelongsTo
    {
        return $this->belongsTo(GroupCompany::class);
    }

    public function historicCompany() : HasMany
    {
        return $this->hasMany(HistoricCompany::class);

    }


    /********************************************CUSTOM METHODS************************************************/
    /**
     * uuidExists
     *
     * Verfica se o UUID existe na base de dados, caso exista gera um novo UUID até encontrar um que não exista.
     * @return string
     */
    public static function uuidExists():string
    {
        do {
            $uuid = (string) Str::uuid();
        } while(self::where('uuid',$uuid)->exists());
        return $uuid;
    }
}
