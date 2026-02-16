<?php

namespace App\Services;

use App\Models\System;
use Illuminate\Support\Facades\Crypt;

final class SystemService
{
    public function save(
        string $code_access_api,
        string $code_access_api_generics_systems,
        int $limit_days,
        string $onwer_pix,
        string $key_pix
    ) {
        try {
            $system = System::findOrFail(1);
            if ($system->code_access_api != $code_access_api || $system->code_access_api_generics_systems != $code_access_api_generics_systems) { //verfica se alguma chave mudou
                $system->code_access_api = $code_access_api;
                $system->code_access_api_cripty = Crypt::encryptString($code_access_api);
                $system->code_access_api_generics_systems = $code_access_api_generics_systems;
                $system->code_access_api_generics_systems_cripty = Crypt::encryptString($code_access_api_generics_systems);
            }
            $system->limit_days = $limit_days;
            $system->name_owner_pix = $onwer_pix;
            $system->pix_key = $key_pix;
            $system->save();
        } catch (\Exception $e) { //cadastrar
            $system = System::create([
                'limit_days' => $limit_days,
                'code_access_api' => $code_access_api,
                'code_access_api_cripty' => Crypt::encryptString($code_access_api),
                'code_access_api_generics_systems' => $code_access_api_generics_systems,
                'code_access_api_generics_systems_cripty' => Crypt::encryptString($code_access_api_generics_systems),
                'name_owner_pix' => $onwer_pix,
                'pix_key' => $key_pix
            ]);
        }
    }
}
