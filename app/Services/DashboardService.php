<?php

namespace App\Services;

use App\Classes\HistoricCompanyClass;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

final class DashboardService
{
    public function index(Request $request)
    {
        $date_string = $request->input('date_month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $date_string);
        $companies_per_payment_day = null;
        $historicCompanyClass = new HistoricCompanyClass();
        # -------------- CONTAGEM DE STATUS MENSAL -------------- #
        $array_monthly_status = [];
        $array_monthly_status = $historicCompanyClass->countMonthStatusPerDate($date);
        #------------------------- FILTRO GANHOS POR DIA NO MÊS ----------------------------#
        $value_per_day_data = $historicCompanyClass->valuePerDay($date);
        #---------------------------------FILTRO EMPRESAS QUE PAGAM NO DIA: X ------------------------------------#
        if (isset($request->companies_the_day)) {
            $date_complete = date('Y-m-d', strtotime($date_string . "-" . $request->companies_the_day));
            $companies_per_payment_day = $historicCompanyClass->getCompaniesByPaymentDay($date_complete);
        }

        return  [
            'monthly_fee_status_count' => $array_monthly_status,
            'array_days_max_values' => $value_per_day_data['array_days_max_values'],
            'total_value' => getMoneyToStringBr($value_per_day_data['total_value']),
            'total_recieve' => getMoneyToStringBr($value_per_day_data['total_recieve']),
            'companies_per_payment_day' => $companies_per_payment_day,
            'year' => $date->year,
            'month' => $date->month,
            'date_month' => $date->year."-".$date->month,
            'images' => [
                'load_gif' => asset('img/load.gif')
            ]
        ];
    }
}
