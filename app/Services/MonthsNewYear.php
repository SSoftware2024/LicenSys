<?php

namespace App\Services;

use App\Classes\HistoricCompanyClass;
use App\Models\HistoricCompany;
use Carbon\Carbon;

final class MonthsNewYear
{

    public function __construct()
    {

    }

    /**
     * companiesWithoutNewYear
     *
     * Retorna as empresas que não possuem meses gerados para o ano atual
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function companiesWithoutNewYear(): \Illuminate\Database\Eloquent\Collection
    {
        $currentYear = Carbon::now()->year;
        $companies = HistoricCompany::whereYear('pay_date', $currentYear)->pluck('company_id')->toArray();
        $allCompanies = \App\Models\Company::pluck('id')->toArray();
        $companiesWithoutNewYear = array_diff($allCompanies, $companies);
        return \App\Models\Company::whereIn('id', $companiesWithoutNewYear)->get();
    }

    /**
     * generateMonthsToNewYear
     *
     * Gera os meses do ano novo para as empresas que não possuem meses gerados
     *
     * @return void
     */
    public function generateMonthsToNewYear(): void
    {
        $companies = $this->companiesWithoutNewYear();
        if ($companies->count() > 0) {
            foreach ($companies as $company) {
                HistoricCompanyClass::generate($company);
            }
        }
    }
}
