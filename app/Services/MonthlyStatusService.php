<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\System;
use App\Enum\MonthlyFee;
use App\Models\HistoricCompany;

final class MonthlyStatusService
{
    private int $limit_days = 0;
    public function __construct()
    {
        $this->limit_days = System::find(1)->limit_days ?? 0;
    }


    /**
     * getStatusMonthByDate
     *
     * Atualiza status com base na data atual e de pagamento, apenas para atrasado ou vencido
     *
     * Caso remoção de pagamento seja ativada ele pode retornar atrasado ou vencido ou pagar
     *
     * @param  HistoricCompany $historic
     * @param  bool $is_removal
     * @return string
     */
    public function getStatusMonthByDate(HistoricCompany $historic, bool $is_removal = false) : string
    {
        $date = now();
        $date_payment = Carbon::parse($historic->pay_date);
        $status_original = $historic->monthly_fee_status;
        $isHaveToPay = $status_original == MonthlyFee::PAY->value;
        // data de pagamento + limite
        $date_payment_limit = $date_payment->copy()->addDays($this->limit_days);

        if ($is_removal === false) { // LÓGICA DE ATUALIZAÇÃO APENAS

            // ATRASADO: hoje > pagamento AND hoje <= pagamento + limite
            if (
                $date->greaterThan($date_payment) && //(25) > 23
                $isHaveToPay &&
                $date->lessThanOrEqualTo($date_payment_limit) //25 <= 26
            ) {
                return MonthlyFee::LATE->value;
            }

            // VENCIDO: hoje > pagamento + limite
            if (
                $date->greaterThan($date_payment_limit) && //27 > (23 +3)
                $isHaveToPay
            ) {
                return MonthlyFee::OVERDUE->value;
            }

            // Não mudou → retorna status atual
            return $status_original;
        } else { //LÓGICA PARA REMOVER PAGAMENTO

            // NÃO ATRASADO NEM VENCIDO → volta para PAY
            if ($date->lessThanOrEqualTo($date_payment)) {
                return MonthlyFee::PAY->value;
            }

            // ATRASADO dentro do limite
            if (
                $date->greaterThan($date_payment) &&
                $date->lessThanOrEqualTo($date_payment_limit)
            ) {
                return MonthlyFee::LATE->value;
            }

            // VENCIDO fora do limite
            if ($date->greaterThan($date_payment_limit)) {
                return MonthlyFee::OVERDUE->value;
            }
        }
        // fallback
        return $status_original;
    }

    public static function updateAllCompaniesMonthlyStatus() : void
    {
        $historics = HistoricCompany::whereYear('pay_date', now()->year)->orderBy('id')->cursor();
        $service = new MonthlyStatusService();
        foreach ($historics as $value) {
            $new_status = $service->getStatusMonthByDate($value, false);
            if ($new_status !== $value->monthly_fee_status) {
                $value->monthly_fee_status = $new_status;
                $value->save();
            }
        }
    }
}
