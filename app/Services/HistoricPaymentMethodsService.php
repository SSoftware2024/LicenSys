<?php

namespace App\Services;

use App\Models\HistoricCompany;
use App\Models\HistoricPaymentMethod;

final class HistoricPaymentMethodsService
{
        
    /**
     * Method create
     *
     * @param array $payment_methods_list 
     *  [payment_method_id, value]
     * @param int $historic_company_id
     *
     * @return void
     */
    public function create(array $payment_methods_list, int $historic_company_id)
    {
        //convertendo e somando valores
        $all_value = array_reduce($payment_methods_list, function ($carry, $item) {
            return $carry += (float) $item['value'];
        });
        $value_pay = HistoricCompany::where('id', $historic_company_id)->first()->amount_paid;
        if ($all_value < $value_pay) {
            throw new \Exception('Valor do pagamento não atingido');
        }

        $payload = [];
        foreach ($payment_methods_list as $value) {
            $payload[] = [
                'historic_company_id' => $historic_company_id,
                'payment_method_id' => $value['payment_method_id'],
                'value_paid' => floatval($value['value']),
                'created_at' => now(),
                'updated_at' => now()
            ];
        };
        HistoricPaymentMethod::insert($payload);
    }
    public function removeAllPaymentsMethodsBy(int $historic_company_id): int
    {
        return HistoricPaymentMethod::where('historic_company_id', $historic_company_id)->forceDelete();
    }

    public function getMethodsPaymentByMonth(int $historic_company_id)
    {

        return HistoricPaymentMethod::with(['paymentMethod' => function ($query) {
            $query->select('id', 'name');
        }])
            ->select('id', 'historic_company_id','payment_method_id', 'value_paid')
            ->where('historic_company_id', $historic_company_id)
            ->get();
    }
}
