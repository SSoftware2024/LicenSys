<?php

namespace App\Services\API;

use App\Classes\CompanyClass;
use App\Facades\SystemClassFacade;
use App\Models\Company;
use App\Models\HistoricCompany;

final class LicenseManagerService
{
    public function getMonths(string $uuid, int $month = 0, int|string $year = 'all', array|string $monthly_fee = 'all')
    {
        //validar para uuid ser da empresa que esta fazendo requisção, só autorização de token não é suficiente
        $company = Company::query();
        $company->where('uuid', $uuid);

        $historicCompany = HistoricCompany::query();
        $historicCompany->with('company:id,company_name,uuid');
        $historicCompany->where('company_id', $company->first()->id);

        if ($year != 'all') {
            $historicCompany->whereYear('pay_date', $year);
        }
        //caso não seja vazio e caso array não contenha null == todos status
        if ($monthly_fee != 'all' && !in_array('all', $monthly_fee) && !in_array(null, $monthly_fee)) {
            $historicCompany->whereIn('monthly_fee_status', $monthly_fee);
        }
        if ($month > 0 && $month <= 12) {
            $historicCompany->whereMonth('pay_date', $month);
        }

        $historicCompany->orderBy('pay_date', 'desc');
        $parameters = compact('uuid', 'month', 'year', 'monthly_fee');
        return $historicCompany->paginate(12)->appends($parameters);
    }

    public function getData(string $uuid) {
        $company = Company::where('uuid', $uuid)->firstOrFail();
        $companyClass = new CompanyClass($company->uuid);
        return response()->json([
            'payment_day' => $companyClass->paymentDayCurrentMonth(),
            'value_monthly_fee' => getMoneyToStringBr($company->value_monthly_fee),
            'status_current_month' => $companyClass->getStatusCurrentMonth(),
            'limit_days_alert' => SystemClassFacade::getLimitDays(),
        ]);

    }

    public function payMonth(string $uuid, int|string $month, int|string $year)
    {
        $company = Company::query();
    }
}
