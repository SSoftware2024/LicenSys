<?php
namespace App\Facades;

use App\Services\ToastFacade;
use Illuminate\Support\Facades\Facade;

class Toast extends Facade
{
    protected static function getFacadeAccessor(){
        return ToastFacade::class;
    }
}
