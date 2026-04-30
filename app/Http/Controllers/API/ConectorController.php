<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\ConectorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConectorController extends Controller
{
    public function connect(Request $request, ConectorService $conectorService)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => ['required', 'string', 'uuid'],
            'api_key_crypt' => ['required', 'string']
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Erro na validação dos dados',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $conectorService->connect($request->uuid, $request->api_key_crypt);
        return response()->json($data);
    }
    public function revokeMyTokens(Request $request, ConectorService $conectorService)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => ['required', 'string', 'uuid'],
            'api_key_crypt' => ['required', 'string']
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Erro na validação dos dados',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $conectorService->revokeMyTokens($request->uuid, $request->api_key_crypt);
        return response()->json($data);
    }
}
