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
    public function create(Request $request)
    {
        try {
            $this->service->create($request->payment_methods_list, $request->historic_company_id);
            Toast::success('Pagamentos registrados');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}
