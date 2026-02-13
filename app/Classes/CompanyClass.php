<?php

namespace App\Classes;

use App\Models\Company;

final class CompanyClass
{
    private string $id;
    private string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getStatusCurrentMonth(){
        $companies = Company::query()->where('uuid', $this->uuid);
        $companies->select('id','uuid','value_monthly_fee','payment_day');
        $date = now();
        $companies->with(['historicCompany' => function ($query) use ($date) {
            $query->select('company_id','pay_date', 'monthly_fee_status')
                ->whereMonth('pay_date', $date->month)
                ->whereYear('pay_date', $date->year);
        }]);
        $company = $companies->first();
        return $company->historicCompany->first()->monthly_fee_status ?? null;
    }
}
