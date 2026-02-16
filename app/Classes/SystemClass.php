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
    private function getSystem(string $fields = '*'): System|null
    {
        try {
            return System::select($fields)->findOrFail(1);
        } catch (\Exception $e) {
            return null;
        }
    }
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

    public function getDataPayment(): array
    {
        $system = $this->getSystem('name_owner_pix, pix_key');
        return !empty($system) ? $system->toArray() : [];
    }
}
