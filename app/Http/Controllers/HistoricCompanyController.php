<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Facades\Toast;
use App\Models\Company;
use App\Enum\MonthlyFee;
use Illuminate\Http\Request;
use App\Models\HistoricCompany;
use App\Http\Controllers\Controller;

class HistoricCompanyController extends Controller
{
    public function index(Request $request)
    {
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();
        $companies = Company::select('id', 'uuid')->get();
        $allYears = range(2025, date('Y'));
        $historicCompany = null;
        $companies->transform(function ($company) {
            //filtro relaizado acima, apenas cria atributo dinâmico
            $company->name = 'name_random_' . rand(1000, 9999);
            return $company;
        });

        return Inertia::render('HistoricCompany/Index', [
            'companies' => $companies,
            'monthly_fee_status' => $monthly_fee_status,
            'allYears' => $allYears,
            'historicCompany' => $historicCompany
        ]);
    }

    public function loadHistoric(Request $request)
    {
        $request->validate([
            'company_uuid' => ['required_without:recieve', 'exists:companies,uuid'],
            'recieve' => 'nullable'
        ], [], [
            'company_uuid' => 'empresa'
        ]);
        $year = $request->year;
        $month_status = $request->month_status;
        $historicCompany = HistoricCompany::query();

        if ($year != 0) {
            $historicCompany->whereYear('pay_date', $year);
        }
        $company_id = Company::where('uuid', $request->company_uuid)->first()->id;
        $historicCompany->where('company_id', $company_id);
        //caso não seja vazio e caso array não contenha null == todos status
        if (!empty($month_status) && !in_array(null, $month_status)) {
            $historicCompany->whereIn('monthly_fee_status', $month_status);
        }
        $historicCompany->orderBy('pay_date', 'desc');
        session()->flash(RESPONSE_DATA_KEY_INERTIA, $historicCompany->paginate()); //padrão 15, preciso de 12
    }
}
