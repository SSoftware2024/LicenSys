<?php
namespace App\Services\API;

final class ConectorService
{
    public function connect(){
        return response()->json(['message' => 'ConectorService is working!']);
    }
}
