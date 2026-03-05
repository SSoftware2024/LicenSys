<?php

namespace App\Models;

use App\Models\Company;
use App\Enum\MonthlyFee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricCompany extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    /********************************************CUSTOM METHODS************************************************/


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
        $historics = self::where('company_id', $company->id)
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



}
