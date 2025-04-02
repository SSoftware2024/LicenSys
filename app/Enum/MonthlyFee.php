<?php

namespace App\Enum;

use App\Traits\EnumFunctions;

/**
 * ! Usado na migration: [companies, historic_companies]
 */
enum MonthlyFee: string
{
    use EnumFunctions;
    case PAY = 'pay'; //pagar
    case PAID = 'paid'; //paga
    case LATE = 'late'; //atrasada
    case OVERDUE = 'overdue'; //vencida
}
