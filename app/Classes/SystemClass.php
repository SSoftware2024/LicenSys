<?php

namespace App\Classes;

use App\Models\System;

/**
 * Classe possui modo Facade
 */
final class SystemClass
{
    private int $limit_days_default = 0;
    private array $systems_for_sale = [
        'ERP_PDV',
        'ERP_MOBILE',
    ];
    /**
     * getSystemsForSale
     *
     * @return array
     */
    public function getSystemsForSale(): array
    {
        return $this->systems_for_sale;
    }

    /**
     * Method getSystem
     *
     * @param string $fields 
     * Colunas da tabela system -> 'id, other_field'
     *
     * @return System
     */
    private function getSystem(array $fields = ['*']): System|null
    {

        try {
            return System::select($fields)->findOrFail(1);
        } catch (\Exception $e) {
            return null;
        }
    }


    /**
     * Method getLimitDays
     * 
     * Retorna máximo de dias de espera para expiração da licença
     * 
     * @return int
     */
    public function getLimitDays(): int
    {
        try {
            $system = System::findOrFail(1);
            $limit_days = $system->limit_days ?? $this->limit_days_default;
        } catch (\Exception $e) {
            $limit_days = $this->limit_days_default;
        }
        return $limit_days;
    }

    /**
     * Method getDataPayment
     * Retorna dados de pagamentos, atualmente apenas pix
     * @return array
     */
    public function getDataPayment(): array
    {
        $system = $this->getSystem(['name_owner_pix','pix_key']);
        return !empty($system) ? $system->toArray() : [];
    }
}
