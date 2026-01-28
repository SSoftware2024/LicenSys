<?php

namespace App\Services\API;

use App\Models\System;
use App\Models\Company;
use Illuminate\Support\Facades\Crypt;

final class ConectorService
{
    public function connect(string $uuid, string $apiKeyCrypt)
    {
        $data = [];
        try {
            $system = System::findOrFail(1);
            $company = Company::where('uuid', $uuid)->first(); //object(true), null(false), no if abaixo
            if (
                $company &&
                Crypt::decryptString($apiKeyCrypt) === $system->code_access_api
            ) {
                $data['token'] = $company->createToken($system->code_access_api)->plainTextToken;
            }
            return [
                ...$data,
                'message' => 'Conexão realizada com sucesso',
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Erro na conexão: ' . $e->getMessage(),
            ];
        }
    }
}
