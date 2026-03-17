<?php

namespace App\Classes;

use App\Enum\MonthlyFee;
use App\Models\Company;
use App\Models\HistoricCompany;
use Illuminate\Support\Carbon;

final class HistoricCompanyClass
{
    #-------------------------------------ESTÁTICOS----------------------------------------------#
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
                'company_id' => $company->id,
                'created_at' => now(),
                'updated_at' => now()
            ];
            //icrementando mês até final do ano
            $current_month < 12 ? $current_month++ : null;
        }
        HistoricCompany::insert($historicData);
    }


    /**
     * generateUpdate
     *
     * Atualiza os registros historicos de pagamentos já existentes para uma empresa quando há uma alteração no dia de pagamento ou no valor mensal.
     *
     * Atualiza mês atual se dia do pagamento for maior que dia atual e mês esteja com status de 'pagar'
     *
     * @param  Company $company
     * @param  int $old_payment_day
     * @param  float $old_value_monthly_fee
     * @return void
     */
    public static function generateUpdate(Company $company, int $old_payment_day, float $old_value_monthly_fee): void
    {
        // Só processa se algo realmente mudou
        if (
            $company->payment_day == $old_payment_day &&
            $company->value_monthly_fee == $old_value_monthly_fee
        ) {
            return;
        }

        $currentYear = now()->year;
        $currentMonth = now()->month;
        $currentDay = now()->day;
        $paymentDay = $company->payment_day;
        $newValue = $company->value_monthly_fee;

        // Se o novo dia de pagamento já passou neste mês, começa no próximo, caso não começa no atual
        $startMonth = $paymentDay > $currentDay ? $currentMonth : $currentMonth + 1;
        if ($startMonth > 12) {
            return;
        } // já acabou o ano

        // Busca todos os históricos da empresa a partir do mês inicial
        $historics = HistoricCompany::where('company_id', $company->id)
            ->whereYear('pay_date', $currentYear)
            ->whereMonth('pay_date', '>=', $startMonth)
            ->get();

        foreach ($historics as $historic) {
            // Só muda status a pagar
            if ($historic->monthly_fee_status === MonthlyFee::PAY->value) {
                $month = date('m', strtotime($historic->pay_date));
                $maxDay = cal_days_in_month(CAL_GREGORIAN, (int)$month, $currentYear);
                $day = min($paymentDay, $maxDay); //pega menor valor dos dois
                $newDate = date('Y-m-d', strtotime("$currentYear-$month-$day"));
                $historic->update([
                    'amount_paid' => convertToMoney($newValue),
                    'pay_date' => $newDate,
                ]);
            }
        }
    }


    /**
     * Method countMonthStatusPerDate
     * 
     * Retorna meses divididos por status e quantidade de empresas naquele status
     * @param Carbon $date [Y-m]
     *
     * @return array
     */
    public function countMonthStatusPerDate(Carbon $date): array
    {
        $array_monthly_status = [];
        $historic_companies = HistoricCompany::query()
            ->whereMonth('pay_date', $date->month)
            ->whereYear('pay_date', $date->year);

        foreach (MonthlyFee::cases() as $status) {
            $array_monthly_status[$status->value] =  (clone $historic_companies)
                ->where('monthly_fee_status', $status->value)
                ->count();
        }
        return $array_monthly_status;
    }
    
    /**
     * Method valuePerDay
     *
     * Retorna um array com valores ganhos por mês, valor total e valor recebido, e marcar maior valor do mês
     * @param Carbon $date [Y-m]
     *
     * @return array
     */
    public function valuePerDay(Carbon $date):array
    {
        $max_day = date("t", strtotime($date . '-01')); //resgatar dia máximo do mês
        $array_days_max_values = [];
        $total_value = 0;
        $total_recieve = 0;
        $max_number = 0;
        $max_day_index = null;

        for ($i = 1; $i <= $max_day; $i++) {
            $day = $i <= 9 ? "0$i" : $i;

            $amount = HistoricCompany::whereMonth('pay_date', $date->month)
                ->whereYear('pay_date', $date->year)
                ->whereDay('pay_date', $day)
                ->sum('amount_paid');

            // verifica se é o maior valor até agora
            if ($amount > $max_number) {
                $max_number = $amount;
                $max_day_index = $i;
            }

            $total_value += $amount;

            $array_days_max_values[$i] = [
                'value' => $amount,
                'formatted' => getMoneyToStringBr($amount),
                'higher_value' => false,
            ];
        }

        // marca o maior dia
        if ($max_day_index !== null && $max_number > 0) {
            $array_days_max_values[$max_day_index]['higher_value'] = true;
        }
        //total recebido(pago)
        $total_recieve += HistoricCompany::whereMonth('pay_date', $date->month)
            ->whereYear('pay_date', $date->year)
            ->where('monthly_fee_status', MonthlyFee::PAID->value)
            ->sum('amount_paid');
        return compact('array_days_max_values', 'total_recieve', 'total_value');
    }

        
    /**
     * Method getCompaniesByPaymentDay
     *
     * Retorna todas empresas que pagam mensalidade na data fornecida
     * @param string $date_complete [Y-m-d]
     *
     * @return void
     */
    public function getCompaniesByPaymentDay(string $date_complete)
    {
        $companies = Company::with(['historicCompany' => function ($query) use ($date_complete) {
            $query->whereDate('pay_date', $date_complete);
            $query->select('company_id', 'amount_paid');
        }])->whereHas('historicCompany', function ($query) use ($date_complete) {
            $query->whereDate('pay_date', $date_complete);
        })->select('id', 'company_name', 'uuid')->get();

        $companies->each(function ($company) {
            $historic = $company->historicCompany->first(); //pega primeiro registro(único) já com filtro aplicado acima
            if (!empty($historic)) {
                $historic->amount_paid_formated = getMoneyToStringBr($historic->amount_paid);
            }
            $company->historic_company = $historic;
            //remove o array e vira objeto
            unset($company->historicCompany);
        });
        return $companies;
    }
}
