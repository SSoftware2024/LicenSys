<?php

namespace App\Enum;

use App\Traits\EnumFunctions;

/**
 * ! Usado na migration: [companies, historic_companies]
 */
enum MonthlyFee: string
{
    use EnumFunctions;
    case PAY = 'pagar';
    case PAID = 'paga';
    case LATE = 'atrasada';
    case OVERDUE = 'vencida';
}
