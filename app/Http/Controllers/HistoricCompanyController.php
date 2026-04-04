<?php

namespace App\Http\Controllers;

use App\Facades\Toast;
use App\Http\Controllers\Controller;
use App\Services\HistoricCompanyService;
use App\Services\HistoricPaymentMethodsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoricCompanyController extends Controller
{

    public function __construct(
        private HistoricCompanyService $service,
        private HistoricPaymentMethodsService $historicPaymentMethodService
    ) {}

    public function index(Request $request)
    {
        $data = $this->service->indexViewData($request);
        return Inertia::render('HistoricCompany/Index', [
            'companies' => $data['companies'],
            'monthly_fee_status' => $data['monthly_fee_status'],
            'allYears' => $data['allYears'],
            'historicCompany' => $data['historicCompany'],
            //parametros url
            ...$data['url_paramters']

        ]);
    }
    public function pay(Request $request)
    {

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
            $this->historicPaymentMethodService->create($request->payment_methods_list, $request->historic_company_id);
            $this->service->pay($request->historic_company_id);
            Toast::info('Pagamentos registrados');
            Toast::success('Mensalidade paga com sucesso');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => $e->getMessage()]);
        }
    }
    public function removePayment(Request $request)
    {
        $request->validate([
            'historic_company_id' => 'required|exists:historic_companies,id',
        ]);
        $payments_methods_removed = $this->historicPaymentMethodService->removeAllPaymentsMethodsBy($request->historic_company_id);
        $this->service->removePayment($request->historic_company_id);
        Toast::info('Remoção de pagamento aplicada');
        Toast::info("$payments_methods_removed métodos de pagamentos removidos");
    }
}
