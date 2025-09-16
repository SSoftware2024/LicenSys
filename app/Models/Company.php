<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\GroupCompany;
use Illuminate\Support\Facades\Crypt;
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


    /********************************************CUSTOM METHODS************************************************/
    /**
     * uuidExists
     *
     * Verfica se o uuid já existe no banco de dados e já atribui os valores às variáveis passadas por referência
     * @param string $key
     * @param string $hash
     * @return void
     */
    public static function uuidExists(string &$uuid):void
    {
        do {
            $uuid = (string) Str::uuid();
        } while(self::where('uuid',$uuid)->exists());
    }
}
