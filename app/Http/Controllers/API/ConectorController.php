<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\ConectorService;
use Illuminate\Http\Request;

class ConectorController extends Controller
{
    public function connect(Request $request, ConectorService $conectorService) {
        $data = $conectorService->connect($request->uuid, $request->api_key_crypt);
        //ds(response()->json($data));
        return response()->json($data);

    }
}
