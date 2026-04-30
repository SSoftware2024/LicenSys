<?php

namespace App\Services\API;

use App\Facades\TokensManager;
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
                $token_active = TokensManager::isHaveTokenActive($company);

                if (empty($token_active)) {
                    $company->tokens()->delete(); //revogando todos os tokens, ja que não tem ativo
                    $data['token'] = $company->createToken($system->code_access_api)->plainTextToken;
                } else {
                    $data['token'] = $token_active->plainTextToken;
                }
            }
            return [
                ...$data,
                'message' => 'Conexão realizada com sucesso, salve seu token em um local seguro, não perca!!!',
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Erro na conexão: ' . $e->getMessage(),
            ];
        }
    }

    public function revokeMyTokens(string $uuid, string $apiKeyCrypt)
    {
        try {
            $system = System::findOrFail(1);
            $company = Company::where('uuid', $uuid)->first(); //object(true), null(false), no if abaixo
            if (
                $company &&
                Crypt::decryptString($apiKeyCrypt) === $system->code_access_api
            ) {
                $company->tokens()->delete();
            }
            return [
                'message' => 'Conexão encerrada, todos tokens foram revogados!',
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Erro na conexão: ' . $e->getMessage(),
            ];
        }
    }
}
