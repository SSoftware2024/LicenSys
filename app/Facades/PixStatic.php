<?php

namespace App\Facades;

use App\Utils\PixStaticFacade;
use Illuminate\Support\Facades\Facade;

final class PixStatic extends Facade
{
    protected static function getFacadeAccessor(){
        return PixStaticFacade::class;
    }
}
