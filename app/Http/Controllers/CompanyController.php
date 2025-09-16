<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use App\Enum\MonthlyFee;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SystemForSaleService;

class CompanyController extends Controller
{
    public function index()
    {
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();
        return Inertia::render('Company/Index', [
            'groups_company' => $groups_company,
            'monthly_fee_status' => $monthly_fee_status,
        ]);
    }

    public function createView()
    {
        $key = $hash = '';
        Company::vinculationCodeExists($key, $hash);
        $systems_for_sale = (new SystemForSaleService())->getSystemsForSale();
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();

        return Inertia::render('Company/Create', [
            'groups_company' => $groups_company,
            'monthly_fee_status' => $monthly_fee_status,
            'systems_for_sale' => $systems_for_sale,
            'vinculation_code' => $key,
        ]);
    }
}
