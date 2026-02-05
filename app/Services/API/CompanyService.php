<?php

use App\Models\Company;

final class CompanyService
{
    private string $uuid = '';

    public function exists():bool {
        return Company::where('uuid', $this->uuid)->exists();
    }
}
