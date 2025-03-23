<?php

namespace App\Http\Controllers;

use App\Facades\Toast;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Support\Facades\Crypt;
use Inertia\Response as InertiaResponse;

class SystemController extends Controller
{
    public function index(): InertiaResponse
    {

        $system_saved = System::find(1);
        // dd($system_saved);
        return Inertia::render('System', [
            'system_saved' => $system_saved
        ]);
    }
    public function save(Request $request)
    {
        //validação
        $request->validate([
            'limit_days' => ['required', 'integer', 'between:1,15'],
            'code_access_api' => ['required', 'min:5'],
            'code_access_api_generics_systems' => ['required', 'min:5'],
        ], [], [
            'limit_days' => 'Limite de dias',
            'code_access_api' => 'Código de acesso API',
            'code_access_api_generics_systems' => 'Código de acesso API - genérico'
        ]);
        try {
            try {
                $system = System::findOrFail(1);
                if ($system->code_access_api != $request->code_access_api || $system->code_access_api_generics_systems != $request->code_access_api_generics_systems) { //verficar se alguma chave mudou
                    $system->code_access_api = $request->code_access_api;
                    $system->code_access_api_cripty = Crypt::encryptString($request->code_access_api);
                    $system->code_access_api_generics_systems = $request->code_access_api_generics_systems;
                    $system->code_access_api_generics_systems_cripty = Crypt::encryptString($request->code_access_api_generics_systems);
                }
                $system->limit_days = $request->limit_days;
                $system->save();
            } catch (\Exception $e) { //cadastrar
                $system = System::create([
                    'limit_days' => $request->limit_days,
                    'code_access_api' => $request->code_access_api,
                    'code_access_api_cripty' => Crypt::encryptString($request->code_access_api),
                    'code_access_api_generics_systems' => $request->code_access_api_generics_systems,
                    'code_access_api_generics_systems_cripty' => Crypt::encryptString($request->code_access_api_generics_systems),
                ]);
            }
            //toast de aviso
            Toast::success('Dados salvos com sucesso');
        } catch (\Exception $e) {
            Toast::warning($e->getMessage());
        } catch (\Error $e) {
            Toast::error($e->getMessage());
        }
    }
}
