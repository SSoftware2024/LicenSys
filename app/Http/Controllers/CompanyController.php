<?php

namespace App\Http\Controllers;

use App\Classes\HistoricCompanyClass;
use App\Classes\SystemClass;
use App\Enum\MonthlyFee;
use App\Facades\Toast;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\GroupCompany;
use App\Models\HistoricCompany;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $service
    ) {}
    public function index(Request $request)
    {
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();
        $array_request = $request->all();
        $companies = $this->service->index($array_request, now(), Company::query());
        return Inertia::render('Company/Index', [
            'groups_company' => $groups_company,
            'monthly_fee_status' => $monthly_fee_status,
            'companies' => $companies
        ]);
    }

    public function createView()
    {
        $data = $this->service->createViewData();
        return Inertia::render('Company/Create', $data);
    }
    public function updateView(int $id)
    {
        $data = $this->service->updateViewData($id);
        return Inertia::render('Company/Update', $data);
    }

    /********************************************METHODS************************************************/

    public function create(Request $request)
    {

        $now_day = now()->day;
        $max_day_month = now()->month == 2 ? cal_days_in_month(CAL_GREGORIAN, 2, now()->year) : 30;
        $request->validate([
            'uuid' => ['required', 'size:36', 'unique:companies,uuid'],
            'company_name' => ['required', 'min:5'],
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
            'systems_useds' => 'escolha de sistema',
            'group_company_id' => 'associar grupo',
            'systems_useds.0' => '-----------',
        ]);
        $this->service->createWithHistoric($request->only([
            'uuid',
            'company_name',
            'payment_day',
            'systems_useds',
            'value_monthly_fee',
            'group_company_id',
            'activated'
        ]));
        Toast::success('Empresa criada com sucesso!');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $company = Company::findOrFail($id);
        $old_payment_day = $company->payment_day;
        $old_value_monthly_fee = $company->value_monthly_fee;
        $now_day = now()->day;
        $max_day_month = now()->month == 2 ? cal_days_in_month(CAL_GREGORIAN, 2, now()->year) : 30;
        $request->validate([
            'uuid' => ['required', 'size:36', "unique:companies,uuid, $id"],
            'company_name' => ['required', 'min:5'],
            'payment_day' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($now_day, $old_payment_day, $max_day_month) {
                    if ($value < $now_day && $value != $old_payment_day) {
                        $fail("O {$attribute} deve ser maior ou igual ao dia atual → $now_day ou igual seu valor antigo: $old_payment_day.");
                    }
                },
                function ($attribute, $value, $fail) use ($max_day_month) {
                    if ($value > $max_day_month) {
                        $fail("O {$attribute} não deve ser maior que $max_day_month");
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
            'systems_useds' => 'escolha de sistema',
            'group_company_id' => 'associar grupo',
            'systems_useds.0' => '-----------',
        ]);

        // Atualiza via model para manter a instância e depois gerar atualizações nos históricos
        $this->service->updatePrepareData($company, $request->only([
            'payment_day',
            'company_name',
            'systems_useds',
            'value_monthly_fee',
            'group_company_id',
            'activated'
        ]));
        //se alterar pagamento ou dia, deve-se atualizar os meses futuros
        HistoricCompanyClass::generateUpdate($company, $old_payment_day, $old_value_monthly_fee);
        Toast::success('Empresa atualizada com sucesso!');
    }

    public function toggleActive(int $id)
    {
        $is_activeted = $this->service->toggleActive($id);
        $text = $is_activeted ? 'ativada' : 'desativada';
        Toast::info("Empresa $text com sucesso!");
    }
    public function delete(int $id)
    {
        $this->service->deleteWithHistoric($id);
        Toast::warning("Empresa $id deletada com sucesso!");
    }

    /*********************************************PRIVATE METHODS************************************************/
}
