<?php

namespace App\Classes;

use App\Models\PaymentMethod;
use App\Models\PaymentPaymentMethod;

final class PaymentMethodClass
{
    private PaymentMethod $payment_method;
    public function setPaymentMethod(PaymentMethod $paymentMethod){
        $this->payment_method = $paymentMethod;
    }
    public function getPaymentMethod(){
        if(!empty($this->payment_method)){
            return $this->payment_method;
        }else{
            throw new \Exception('payment_method is empty');
        }
    }
}
