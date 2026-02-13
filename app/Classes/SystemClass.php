<?php

namespace App\Classes;

use App\Models\System;
/**
 * Classe possui modo Facade
 */
final class SystemClass {
    private int $limit_days_default = 0;
    public function getLimitDays(): int
    {
        $limit_days = $this->limit_days_default;
        try {
             $system = System::findOrFail(1);
             $limit_days = $system->limit_days ?? $this->limit_days_default;
        } catch (\Exception $e) {
            $limit_days = $this->limit_days_default;
        }
        return $limit_days;
       
        
    }
}