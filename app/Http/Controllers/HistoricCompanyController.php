<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Facades\Toast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\HistoricCompanyService;

class HistoricCompanyController extends Controller
{

    public function __construct(
        private HistoricCompanyService $service
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
            'historic_company_id' => 'required|exists:historic_companies,id',
        ]);
        $this->service->pay($request->historic_company_id);
        Toast::success('Mensalidade paga com sucesso');
    }
    public function removePayment(Request $request)
    {
        $request->validate([
            'historic_company_id' => 'required|exists:historic_companies,id',
        ]);
        $this->service->removePayment($request->historic_company_id);
        Toast::info('Remoção de pagamento aplicada');
    }
}
