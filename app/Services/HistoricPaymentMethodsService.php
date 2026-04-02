<?php

namespace App\Services;

final class HistoricPaymentMethodsService 
{
    public function create(array $data)
    {
        
        //pegar valor a ser pago e comparar com se all value é maior, caso maior deduzir que o troco ja foi entregue e salvar no banco valor da mensalidade
        ds('created :)');
        ds($data);
    }
}
