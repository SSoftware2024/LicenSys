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
        $date = $request->input('date_month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $date);
        //calcular dia máximo do mês
        $max_day = date("t", strtotime($date . '-01'));

        # -------------- CONTAGEM DE STATUS MENSAL -------------- #
        $array_monthly_status = [];
        $historic_companies = HistoricCompany::query()
            ->whereMonth('pay_date', $date->month)
            ->whereYear('pay_date', $date->year);

        foreach (MonthlyFee::cases() as $status) {
            $array_monthly_status[$status->value] =  $historic_companies
                ->where('monthly_fee_status', $status->value)
                ->count();
        }
        # -------------- FIM CONTAGEM DE STATUS MENSAL -------------- #

        return Inertia::render('Index', [
            'max_day' => (int) $max_day,
            'monthly_fee_status_count' => $array_monthly_status,
        ]);
    }
}
