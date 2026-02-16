<?php

namespace App\Http\Controllers;

use App\Facades\Toast;
use App\Http\Controllers\Controller;
use App\Models\System;
use App\Services\SystemService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SystemController extends Controller
{
    public function __construct(
        private SystemService $service
    ) {}
    public function index(): InertiaResponse
    {
        $system_saved = System::find(1);
        return Inertia::render('System', [
            'system_saved' => $system_saved
        ]);
    }
    public function save(Request $request): void
    {
        //validação
        $request->validate([
            'limit_days' => ['required', 'integer', 'between:1,15'],
            'code_access_api' => ['required', 'min:5'],
            'code_access_api_generics_systems' => ['required', 'min:5'],
            'onwer_pix' => ['required','string'],
            'key_pix' => ['required','string'],
        ], [], [
            'limit_days' => 'Limite de dias',
            'code_access_api' => 'Código de acesso API',
            'code_access_api_generics_systems' => 'Código de acesso API - genérico',
            'onwer_pix' => 'Pix dono',
            'key_pix' => 'Chave pix',
        ]);
        try {
            $this->service->save(
                $request->code_access_api,
                $request->code_access_api_generics_systems,
                $request->limit_days,
                $request->limit_days,
                $request->onwer_pix,
                $request->key_pix
            );
            Toast::success('Dados salvos com sucesso');
        } catch (\Exception $e) {
            Toast::warning($e->getMessage());
        } catch (\Error $e) {
            Toast::error($e->getMessage());
        }
    }
}
