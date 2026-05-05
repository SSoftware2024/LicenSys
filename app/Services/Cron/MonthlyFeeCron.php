<?php

namespace App\Services\Cron;

use App\Classes\HistoricCompanyClass;
use App\Enum\MonthlyFee;
use App\Facades\SystemClassFacade;
use App\Models\HistoricCompany;
use Carbon\Carbon;

final class MonthlyFeeCron
{
    private int $limit_days = 0;
    public function __construct() {}

    private function getLimitDays()
    {
        $this->limit_days = SystemClassFacade::getLimitDays();
    }
    /**
     * companiesWithoutNewYear
     *
     * Retorna as empresas que não possuem meses gerados para o ano atual
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function companiesWithoutNewYear(): \Illuminate\Database\Eloquent\Collection
    {
        $currentYear = Carbon::now()->year;
        $companies = HistoricCompany::whereYear('pay_date', $currentYear)->pluck('company_id')->toArray();
        $allCompanies = \App\Models\Company::pluck('id')->toArray();
        $companiesWithoutNewYear = array_diff($allCompanies, $companies);
        return \App\Models\Company::whereIn('id', $companiesWithoutNewYear)->get();
    }

    /**
     * generateMonthsToNewYear
     *
     * Gera os meses do ano novo para as empresas que não possuem meses gerados
     *
     * @return void
     */
    public function generateMonthsToNewYear(): void
    {
        $companies = $this->companiesWithoutNewYear();
        if ($companies->count() > 0) {
            foreach ($companies as $company) {
                HistoricCompanyClass::generate($company);
            }
        }
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
        $date_payment_limit = $date_payment->copy()->addDays($this->getLimitDays());

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

    /**
     * updateAllCompaniesMonthlyStatus
     *
     * Atualiza todos os status mensais das empresas no ano atual, caso mês atual esteja vencido
     * e passou do limite desativa empresa
     *
     * @return void
     */
    public function updateAllCompaniesMonthlyStatus(): void
    {
        $historics = HistoricCompany::whereYear('pay_date', now()->year)->orderBy('id')->cursor();
        $date = now();
        foreach ($historics as $value) {
            $new_status = $this->getStatusMonthByDate($value, false);
            $date_payment = Carbon::parse($value->pay_date);
            $date_payment_limit = $date_payment->copy()->addDays($this->getLimitDays());

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
        }
    }
}
