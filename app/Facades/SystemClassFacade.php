<?php
namespace App\Facades;

use App\Classes\SystemClass;
use Illuminate\Support\Facades\Facade;

class SystemClassFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return SystemClass::class;
    }
}
