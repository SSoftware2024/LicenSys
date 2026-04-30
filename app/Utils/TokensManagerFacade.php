<?php

namespace App\Utils;

use App\Models\Company;

final class TokensManagerFacade
{
    public function isHaveTokenActive(Company $company)
    {
        $expiration = config('sanctum.expiration'); // minutos ou null

        // Verifica se já possui um token ativo
        $tokenActive = $company->tokens()
            ->where(function ($query) use ($expiration) {
                // Token com expires_at individual ainda válido
                $query->where('expires_at', '>', now())
                    // OU token sem expires_at (controla pela config global)
                    ->orWhere(function ($q) use ($expiration) {
                        $q->whereNull('expires_at');
                        // Se config global definida, verifica pelo created_at
                        if ($expiration) {
                            $q->where('created_at', '>', now()->subMinutes($expiration));
                        }
                        // Se config null, token sem expires_at nunca expira — sempre válido
                    });
            })
            ->latest()
            ->first();
            return $tokenActive;
    }
}
