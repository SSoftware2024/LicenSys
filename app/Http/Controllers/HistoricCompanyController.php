<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use App\Enum\MonthlyFee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistoricCompany;

class HistoricCompanyController extends Controller
{
    public function index()
    {
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();
        $companies = Company::select('id', 'uuid')->get();
        $allYears = range(2025, date('Y'));
        $companies->transform(function ($company) {
            //filtro relaizado acima, apenas cria atributo dinâmico
            $company->name = 'name_random_' . rand(1000, 9999);
            return $company;
        });

        return Inertia::render('HistoricCompany/Index', [
            'companies' => $companies,
            'monthly_fee_status' => $monthly_fee_status,
            'allYears' => $allYears
        ]);
    }

    public function loadHistoric(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
        ],[], [
            'company_id' => 'empresa'
        ]);
        $year = $request->year;
        $company_id = $request->company_id;
        $month_status = $request->month_status;
        $historicCompany = HistoricCompany::query();

        if ($year != 0) {
            $historicCompany->whereYear('pay_date', $year);
        }
        //verficar se existe variavel receber, caso exista buscar todas as contas a receber
        if (!empty($request?->receber)) {
            $historicCompany->where('monthly_fee_status', MonthlyFee::PAY->value);
        } else {
            $historicCompany->where('company_id', $company_id);
            //caso não seja vazio e caso array não contenha null == todos status
            if (!empty($month_status) && !in_array(null, $month_status)) {
                $historicCompany->whereIn('monthly_fee_status', $month_status);
            }
        }
        session()->flash(RESPONSE_DATA_KEY_INERTIA, $historicCompany->paginate());
    }
}
