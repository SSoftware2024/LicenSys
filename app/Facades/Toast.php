<?php
namespace App\Facades;


use App\Utils\ToastFacade;
use Illuminate\Support\Facades\Facade;

class Toast extends Facade
{
    protected static function getFacadeAccessor(){
        return ToastFacade::class;
    }
}
