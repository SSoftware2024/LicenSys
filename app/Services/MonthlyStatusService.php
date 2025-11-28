<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\System;
use App\Enum\MonthlyFee;
use App\Models\HistoricCompany;
use Illuminate\Support\Facades\Log;

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
    public function getStatusMonthByDate(HistoricCompany $historic, bool $is_removal = false): string
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

    public function updateAllCompaniesMonthlyStatus(): void
    {
        $historics = HistoricCompany::whereYear('pay_date', now()->year)->orderBy('id')->cursor();
        $service = new MonthlyStatusService();
        $date = now();
        foreach ($historics as $value) {
            $new_status = $service->getStatusMonthByDate($value, false);
            $date_payment = Carbon::parse($value->pay_date);
            $date_payment_limit = $date_payment->copy()->addDays($this->limit_days);

            //muda status
            if ($new_status !== $value->monthly_fee_status) {
                $value->monthly_fee_status = $new_status;
                $value->save();
            }

            //desativa empresa, se mês atual, vencido e passou do limite
            if (
                $new_status == MonthlyFee::OVERDUE->value &&
                $date->greaterThan($date_payment_limit) &&
                $date_payment->month == $date->month
            ) {
                $value->company()->update([
                    'activated' => false
                ]);
            }

            // Log::info("Empresa ID {$value->company_id} - Status Mensalidade atualizado para: {$new_status}");
        }
    }
}
