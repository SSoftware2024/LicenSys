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
        $year = 0;
        $company_id = 0;
        $status = [];
        ds('load here');
    }
}
