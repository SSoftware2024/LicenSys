<?php

namespace App\Services;

use App\Classes\Abstract\CRUD;
use App\Models\HistoricPaymentMethod;
use App\Models\PaymentMethod;

final class PaymentMethodService extends CRUD
{
    protected function getModel()
    {
        return PaymentMethod::class;
    }

    /**
     * Method deleteWithRelations
     *
     * Deleta metodos de pagamento se não houver relações nele
     * 
     * @param int $id 
     *
     * @return void
     */
    public function deleteWithRelations(int $id)
    {
        $is_have_relations = HistoricPaymentMethod::where('payment_method_id', $id)->exists();
        $data = [
            'success' => !$is_have_relations,
            'register_deleteds' => 0
        ];
        if (!$is_have_relations) {
            $data['register_deleteds'] = parent::delete($id);
            $data['success'] = true;
        }
        return $data;
    }

    public function read(string|null $search_name = '')
    {
        $paymentMethods = PaymentMethod::query();
        if (isset($search_name) && !empty($search_name)) {
            $paymentMethods->where('name', 'like', "%$search_name%");
        }
        //ajustar isso na view, variavel count, acho que aq vale a pena tirar paginte, são poucos dados
        $paymentMethods = $paymentMethods->withCount('historicPaymentMethod')->orderBy('name')->paginate();
        return $paymentMethods;
    }

    public function getPaymentMethods() {}
}
