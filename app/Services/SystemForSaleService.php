<?php
namespace App\Services;

final class SystemForSaleService
{
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
}
