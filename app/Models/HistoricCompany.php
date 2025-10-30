<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricCompany extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    /********************************************CUSTOM METHODS************************************************/

    /**
     * generate
     *
     * Gera registros históricos de pagamento para uma empresa até o final do ano corrente.
     *
     * Para cada mês, a partir do mês atual até dezembro, cria um registro com a data de pagamento
     * baseada no dia de pagamento da empresa. Caso o dia de pagamento seja maior que o número máximo
     * de dias de fevereiro, ajusta para o último dia de fevereiro.
     *
     * @param Company $company Instância da empresa para a qual os históricos serão gerados.
     *
     * @return void
     */
    public static function generate(Company $company): void
    {
        //contar quantos meses ate final do ano a partir de mes atual
        $payment_day = $company->payment_day;
        $current_month = date('m');
        $current_year = now()->year;
        $months_until_end_of_year = 12 - $current_month + 1; //+1 para incluir o mes atual e gerar mês atual
        $max_day_february = cal_days_in_month(CAL_GREGORIAN, 2, now()->year);
        $historicData = [];
        for ($i = 0; $i < $months_until_end_of_year; $i++) {
            $dateString = "$current_month/$payment_day/$current_year";
            //verficando se o dia de pagamento é maior que o maximo dia de fevereiro
            if ($current_month == 2 && $max_day_february < $payment_day) {
                $dateString = "$current_month/$max_day_february/$current_year";
            }
            $date = date('Y-m-d', strtotime($dateString)); //gerar data pegando dia selecioando, mes atual e ano atual
            $historicData[] = [
                'amount_paid' => $company->value_monthly_fee,
                'pay_date' => $date,
                'company_id' => $company->id
            ];
            //icrementando mês até final do ano
            $current_month < 12 ? $current_month++ : null;
        }
        self::insert($historicData);
    }
}
