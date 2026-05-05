<?php

namespace App\Http\Controllers;

use App\Facades\Toast;
use App\Services\HistoricPaymentMethodsService;
use Illuminate\Http\Request;

class HistoricPaymentMethodsController
{
    public function __construct(
        private HistoricPaymentMethodsService $service
    ) {}
}
