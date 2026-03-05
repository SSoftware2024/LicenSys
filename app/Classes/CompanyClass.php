<?php

namespace App\Classes;

use App\Models\Company;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;

final class CompanyClass
{
    private Company $company;

    public function __construct() {}

    public function setCompany(Company $company)
    {
        $this->company = $company;
    }

    public function getCompany()
    {
        if (!empty($this->company)) {
            return $this->company;
        }
        throw new \Exception("Company is empty");
        
    }

    public function getStatusCurrentMonth()
    {
        $this->getCompany()->select('id', 'uuid', 'value_monthly_fee', 'payment_day');
        $date = now();
        $this->getCompany()->with(['historicCompany' => function ($query) use ($date) {
            $query->select('company_id', 'pay_date', 'monthly_fee_status')
                ->whereMonth('pay_date', $date->month)
                ->whereYear('pay_date', $date->year);
        }]);
        return $this->getCompany()->historicCompany->first()->monthly_fee_status ?? null;
    }

    public function paymentDayCurrentMonth()
    {
        $payment_day = $this->getCompany()->select('payment_day')->first()->payment_day;
        $max_day =  cal_days_in_month(CAL_GREGORIAN, now()->month, now()->year);
        return $payment_day > $max_day ? $payment_day : (string)$max_day;
    }


    /**
     * buildFilterCompanyQuery
     * 
     * Filtra com base na data fornecedia m-Y, já relaciona com grupo da empresa e histórico
     * 
     * @param array $filter
     * ['uuid','company_name','group_company','monthly_fee_status']
     * @param ?CarbonInterface $date 
     * Só interessa mês e ano da data
     * @param Builder<App\Models\Company> $companies 
     * Company::query()
     *
     * @return Builder<App\Models\Company>
     */
    public function buildFilterCompanyQuery(array $filter, ?CarbonInterface $date = null, Builder $companies)
    {
        if (is_null($date)) {
            $date = now();
        }
        # ======================== FILTRO  ======================== #
        // filtrando logo 'current_month_status' para minimizar loops em querys no tranforms abaixo
        $companies->with(['groupCompany:id,name', 'historicCompany' => function ($query) use ($date) {
            $query->select('id', 'company_id', 'pay_date', 'monthly_fee_status')
                ->whereMonth('pay_date', $date->month)
                ->whereYear('pay_date', $date->year);
        }]);
        //filtro de campos
        $companies->when($filter['uuid'] ?? false, function ($query, $value) {
            $query->where('uuid', 'like', "%{$value}%");
        })->when($filter['company_name'] ?? false, function ($query, $value) {
            $query->where('company_name', 'like', "%{$value}%");
        })->when($filter['group_company'] ?? false, function ($query, $value) {
            $query->whereHas('groupCompany', function ($query) use ($value) {
                $query->where('id', $value);
            });
        })->when($filter['monthly_fee_status'] ?? false, function ($query, $value) {
            $query->whereHas('historicCompany', function ($query) use ($value) {
                $query->where('monthly_fee_status', $value)->whereMonth('pay_date', date('m'));
            });
        });
        return $companies;
    }
}
