<?php
namespace App\Facades;


use App\Utils\TokensManagerFacade;
use Illuminate\Support\Facades\Facade;

class TokensManager extends Facade
{
    protected static function getFacadeAccessor(){
        return TokensManagerFacade::class;
    }
}