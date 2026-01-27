<?php
namespace App\Services\API;

final class ConectorService
{
    public function connect(){
        // return response()->json(['message' => 'ConectorService is working!']);
        return json_encode(['status' => 'success', 'data' => []]);
    }
}
