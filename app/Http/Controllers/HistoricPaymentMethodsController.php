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
        //validar se existe id, nome, valor uuid e mes referente, backend //caso error exebir no alert, não toast
        $request->validate([
            'historic_company_id' => ['required', 'exists:historic_companies,id'],
            'payment_methods_list' => ['required', 'array'],
            'payment_methods_list.*.payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'payment_methods_list.*.value' => ['required', 'max:7'],
        ], [
            'payment_methods_list.*.value' => [
                'max' => 'O campo :attribute não pode ser maior que 9.999,99'
            ]
        ], [
            'payment_methods_list' => 'lista de pagamentos',
            'payment_methods_list.*.value' => 'valor'
        ]);
        try {
            $this->service->create($request->payment_methods_list, $request->historic_company_id);
            Toast::success('Pagamentos registrados');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
}
