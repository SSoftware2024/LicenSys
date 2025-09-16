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
     * vinculationCodeExists
     * Verfica se o código de vinculação já existe no banco de dados e já atribui os valores às variáveis passadas por referência
     * @param  string $key
     * @param  string $hash
     * @return void
     */
    public static function vinculationCodeExists(string &$key, string &$hash):void
    {
        do {
            $key = Str::random(rand(10, 40));
            $hash = hash_hmac('sha256', $key, config('app.key'));
        } while(self::where('vinculation_code',$hash)->exists());
    }
}
