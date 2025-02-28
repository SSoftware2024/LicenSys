<?php

namespace App\Enum;

use App\Traits\EnumFunctions;

/**
 * ! Usado na migration:
 */
enum MonthlyFee: string
{
    use EnumFunctions;
    case PAY = 'PAGAR';
    case PAID = 'PAGA';
    case LATE = 'ATRASADA';
    case OVERDUE = 'VENCIDA';
}
