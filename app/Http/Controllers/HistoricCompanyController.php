<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Facades\Toast;
use App\Models\Company;
use App\Enum\MonthlyFee;
use Illuminate\Http\Request;
use App\Models\HistoricCompany;
use App\Http\Controllers\Controller;
use App\Services\MonthlyStatusService;

class HistoricCompanyController extends Controller
{
    public function index(Request $request)
    {
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();
        $companies = Company::select('id', 'uuid','company_name')->get();
        $allYears = range(2025, date('Y'));
        $historicCompany = null;
        if (isset($request->month_status)) {
            $historicCompany = $this->loadHistoric($request);
        }

        return Inertia::render('HistoricCompany/Index', [
            'companies' => $companies,
            'monthly_fee_status' => $monthly_fee_status,
            'allYears' => $allYears,
            'historicCompany' => $historicCompany,
            //parametros url
            'year' => $request->year ?? 'all',
            'company_uuid' => $request->company_uuid ?? 'empty',
            'month_status' => $request->month_status ?? 'all',
            'month' => $request->month ?? 0,

        ]);
    }
    //colocar filtro de mês
    private function loadHistoric(Request $request)
    {
        $year = $request->year ?: 0;
        $month = $request->month ?? 0;
        $month_status = $request->month_status ?: null;
        $historicCompany = HistoricCompany::query();
        $historicCompany->with('company:id,company_name,uuid');

        if ($year != 'all') {
            $historicCompany->whereYear('pay_date', $year);
        }
        if ($request->company_uuid != 'empty') {
            $company_id = Company::where('uuid', $request->company_uuid)->first()->id;
            $historicCompany->where('company_id', $company_id);
        }
        //caso não seja vazio e caso array não contenha null == todos status
        if ($month_status != 'all' && !in_array('all', $month_status) && !in_array(null, $month_status)) {
            $historicCompany->whereIn('monthly_fee_status', $month_status);
        }
        if($month > 0 && $month <=12){
            $historicCompany->whereMonth('pay_date', $month);
        }

        $historicCompany->orderBy('pay_date', 'desc');
        return $historicCompany->paginate(12)->appends($request->all());
    }


    public function pay(Request $request)
    {
        $request->validate([
            'historic_company_id' => 'required|exists:historic_companies,id',
        ]);

        HistoricCompany::where('id',$request->historic_company_id)->update([
            'monthly_fee_status' => MonthlyFee::PAID->value
        ]);
        Toast::success('Mensalidade paga com sucesso');
    }
    public function removePayment(Request $request)
    {
        $request->validate([
            'historic_company_id' => 'required|exists:historic_companies,id',
        ]);
        $historicCompany = HistoricCompany::find($request->historic_company_id);
        $historicCompany->monthly_fee_status = (new MonthlyStatusService())->getStatusMonthByDate($historicCompany, true);
        $historicCompany->save();
        Toast::info('Remoção de pagamento aplicada');

    }
}
