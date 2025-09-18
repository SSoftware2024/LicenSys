<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Facades\Toast;
use App\Models\Company;
use App\Enum\MonthlyFee;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use App\Models\HistoricCompany;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\SystemForSaleService;
use Illuminate\Validation\ValidationException;

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
        $uuid = Company::uuidExists();
        $systems_for_sale = (new SystemForSaleService())->getSystemsForSale();
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();

        return Inertia::render('Company/Create', [
            'groups_company' => $groups_company,
            'monthly_fee_status' => $monthly_fee_status,
            'systems_for_sale' => $systems_for_sale,
            'uuid' => $uuid,
        ]);
    }

    /********************************************METHODS************************************************/

    public function create(Request $request)
    {

        $now_day = now()->day;
        $max_day_month = cal_days_in_month(CAL_GREGORIAN, now()->month, now()->year);
        $max_day_month = $max_day_month === 31 ? 30 : $max_day_month;
        $request->validate([
            'uuid' => ['required', 'size:36', 'unique:companies,uuid'],
            'payment_day' => [
                'required',
                'integer',
                "between:1,$max_day_month",
                function ($attribute, $value, $fail) use ($now_day) {
                    if ($value < $now_day) {
                        $fail("O {$attribute} deve ser maior ou igual ao dia atual → " . $now_day);
                    }
                }
            ],
            'systems_useds' => ['required', 'array', 'min:1'],
            'systems_useds.*' => ['filled', 'string'],
            'value_monthly_fee' => ['required', 'max:8'],
            'group_company_id' => ['nullable', 'exists:group_companies,id'],
        ], [
            'systems_useds.0' => 'O campo :attribute não pode ser enviado'
        ], [
            'payment_day' => 'pagamento dia',
            'value_monthly_fee' => 'pagamento valor',
            'systems_useds' => 'Escolha de sistema',
            'group_company_id' => 'associar grupo',
            'systems_useds.0' => '-----------',
        ]);

        $company = Company::create([
            'uuid' => $request->uuid,
            'payment_day' => $request->payment_day,
            'systems_useds' => json_encode($request->systems_useds),
            'value_monthly_fee' => convertToMoney($request->value_monthly_fee),
            'group_company_id' => $request->group_company_id,
            'activated' => $request->activated,
            'isFiscal' => false,
            'created_by_user_id' => Auth::id()
        ]);
        //gerar historico mensalidade
        HistoricCompany::generate($company);
        Toast::success('Empresa criada com sucesso!');
    }
}
