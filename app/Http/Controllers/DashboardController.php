<?php

namespace App\Http\Controllers;

use App\Enum\MonthlyFee;
use App\Models\Company;
use App\Models\HistoricCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $date_string = $request->input('date_month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $date_string);
        //resgatar dia máximo do mês
        $max_day = date("t", strtotime($date . '-01'));
        $companies = null;

        # -------------- CONTAGEM DE STATUS MENSAL -------------- #
        $array_monthly_status = [];
        $historic_companies = HistoricCompany::query()
            ->whereMonth('pay_date', $date->month)
            ->whereYear('pay_date', $date->year);

        foreach (MonthlyFee::cases() as $status) {
            $array_monthly_status[$status->value] =  (clone $historic_companies)
                ->where('monthly_fee_status', $status->value)
                ->count();
        }
        # -------------- FIM CONTAGEM DE STATUS MENSAL -------------- #

        #-------------------------FILTRO GANHOS POR DIA NO MÊS ----------------------------#

        $array_days_max_values = [];
        $total_value = 0;
        $total_recieve = 0;
        for ($i = 1; $i <= $max_day; $i++) {
            $day = $i <= 9 ? "0$i" : $i;
            $array_days_max_values[$i] = HistoricCompany::whereMonth('pay_date', $date->month)
                ->whereYear('pay_date', $date->year)
                ->whereDay('pay_date', $day)->sum('amount_paid');
            $total_value += $array_days_max_values[$i];
            $array_days_max_values[$i] = getMoneyToStringBr($array_days_max_values[$i]);
        }
        //total recebido(pago)
        $total_recieve += HistoricCompany::whereMonth('pay_date', $date->month)
            ->whereYear('pay_date', $date->year)
            ->where('monthly_fee_status', MonthlyFee::PAID->value)
            ->sum('amount_paid');

        #------------------------- FIM FILTRO GANHOS POR DIA NO MÊS ----------------------------#

        #---------------------------------FILTRO EMPRESAS QUE PAGAM NO DIA x ------------------------------------#
        if(isset($request->companies_the_day)){
            $date_complete = date('Y-m-d', strtotime($date_string."-".$request->companies_the_day));
            $companies = Company::whereHas('historicCompany', function ($query) use($date_complete) {
                $query->whereDate('pay_date', $date_complete);
            })->select('company_name','uuid')->get();
        }
        #---------------------------------FIM FILTRO EMPRESAS QUE PAGAM NO DIA x ------------------------------------#

        return Inertia::render('Index', [
            'monthly_fee_status_count' => $array_monthly_status,
            'array_days_max_values' => $array_days_max_values,
            'total_value' => getMoneyToStringBr($total_value),
            'total_recieve' => getMoneyToStringBr($total_recieve),
            'companies' => $companies,
            'year' => $date->year,
            'month' => $date->month,
            'images' => [
                'load_gif' => asset('img/load.gif')
            ]
        ]);
    }
}
