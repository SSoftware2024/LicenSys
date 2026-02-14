<?php

namespace App\Classes;

use App\Models\Company;

final class CompanyClass
{
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getStatusCurrentMonth(){
        $this->company->select('id','uuid','value_monthly_fee','payment_day');
        $date = now();
        $this->company->with(['historicCompany' => function ($query) use ($date) {
            $query->select('company_id','pay_date', 'monthly_fee_status')
                ->whereMonth('pay_date', $date->month)
                ->whereYear('pay_date', $date->year);
        }]);
        return $this->company->historicCompany->first()->monthly_fee_status ?? null;
    }

    public function paymentDayCurrentMonth(){
        $payment_day = $this->company->select('payment_day')->first()->payment_day;
        $max_day =  cal_days_in_month(CAL_GREGORIAN, now()->month, now()->year);
        return $payment_day > $max_day ? $payment_day : (string)$max_day;
    }
}
