<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricCompany extends Model
{
    use SoftDeletes;


    /********************************************CUSTOM METHODS************************************************/
    public static function generate(Company $company): void
    {
        //contar quantos meses ate final do ano a partir de mes atual
        $payment_day = $company->payment_day;
        $current_month = now()->month;
        $current_year = now()->year;
        $months_until_end_of_year = 12 - $current_month + 1; //+1 para incluir o mes atual e gerar mês atual

        for ($i = 0; $i < $months_until_end_of_year; $i++) {
            $date = date('Y-m-d', strtotime("$payment_day/$current_month/$current_year"));
            ds($date);
        }
        //gerar data pegando dia selecioando, mes atual e ano atual
        //verficar se dia 30 ou 31 e mes for fevereiro, ajustar dia para 28 ou 29
    }
}
