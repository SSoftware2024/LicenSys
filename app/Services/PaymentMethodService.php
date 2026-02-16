<?php

namespace App\Services;

use App\Classes\Abstract\CRUD;
use App\Models\PaymentMethod;

final class PaymentMethodService extends CRUD
{
    protected function getModel(){
        return PaymentMethod::class;
    }

    public function deleteWithRelations(int $id){
        $payment_method = PaymentMethod::find($id);
        $payment_method_count = 0;
        if($payment_method_count > 0){
            //desvincular todos
        }
        //apagar metodo de pagamento
        return parent::delete($id);
    }

    public function read(){
        return PaymentMethod::paginate();
    }
}
