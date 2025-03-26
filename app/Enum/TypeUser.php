<?php

namespace App\Enum;

use App\Traits\EnumFunctions;

/**
 * ! Usado na migration: users
 */
enum TypeUser: string
{
    use EnumFunctions;
    case ADMIN = 'admin';
    case DEFAULT = 'padrao';
}
