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

class CompanyController extends Controller
{
    public function index()
    {
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();
        $date = now();
        /**
         * filtrando logo 'current_month_status' para minimizar loops em querys no tranforms abaixo
         */
        $companies = Company::with(['groupCompany:id,name', 'historicCompany' => function ($query) use ($date) {
            $query->select('id', 'company_id', 'pay_date', 'monthly_fee_status')
                ->whereMonth('pay_date', $date->month)
                ->whereYear('pay_date', $date->year);
        }])->paginate();

        $companies->getCollection()->transform(function ($company) {
            //filtro relaizado acima, apenas cria atributo dinâmico
            $company->current_month_status = $company->historicCompany->first()->monthly_fee_status;
            $company->value_monthly_fee_formated = getMoneyToStringBr($company->value_monthly_fee);
            return $company;
        });
        return Inertia::render('Company/Index', [
            'groups_company' => $groups_company,
            'monthly_fee_status' => $monthly_fee_status,
            'companies' => $companies
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
    public function updateView(int $id)
    {

        $company =  Company::findOrFail($id);
        $systems_for_sale = (new SystemForSaleService())->getSystemsForSale();
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();

        return Inertia::render('Company/Update', [
            'groups_company' => $groups_company,
            'monthly_fee_status' => $monthly_fee_status,
            'systems_for_sale' => $systems_for_sale,
            'company' => $company
        ]);
    }

    /********************************************METHODS************************************************/

    public function create(Request $request)
    {

        $now_day = now()->day;
        $max_day_month = now()->month == 2 ? cal_days_in_month(CAL_GREGORIAN, 2, now()->year) : 30;
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
            'systems_useds' => 'escolha de sistema',
            'group_company_id' => 'associar grupo',
            'systems_useds.0' => '-----------',
        ]);

        $company = Company::create([
            'uuid' => $request->uuid,
            'payment_day' => $request->payment_day,
            'systems_useds' => $request->systems_useds,
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

    public function update(Request $request)
    {
        $id = $request->id;
        $company = Company::findOrFail($id);
        $old_payment_day = $company->payment_day;
        $old_value_monthly_fee= $company->value_monthly_fee;
        $now_day = now()->day;
        $max_day_month = now()->month == 2 ? cal_days_in_month(CAL_GREGORIAN, 2, now()->year) : 30;
        $request->validate([
            'uuid' => ['required', 'size:36', "unique:companies,uuid, $id"],
            'payment_day' => [
                'required',
                'integer',
                "between:1,$max_day_month",
                function ($attribute, $value, $fail) use ($now_day, $old_payment_day) {
                    if ($value < $now_day && $value != $old_payment_day) {
                        $fail("O {$attribute} deve ser maior ou igual ao dia atual → $now_day ou igual seu valor antigo: $old_payment_day");
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
        $company->update([
            'payment_day' => $request->payment_day,
            'systems_useds' => $request->systems_useds,
            'value_monthly_fee' => convertToMoney($request->value_monthly_fee),
            'group_company_id' => $request->group_company_id,
            'activated' => $request->activated,
            'isFiscal' => false,
            'updated_by_user_id' => Auth::id()
        ]);
        //se alterar pagamento ou dia, deve-se atualizar os meses futuros
        HistoricCompany::generateUpdate($company, $old_payment_day, $old_value_monthly_fee);
        Toast::success('Empresa atualizada com sucesso!');
    }

    public function toggleActive(int $id)
    {
        $company = Company::findOrFail($id);
        $company->activated = !$company->activated;
        $company->updated_by_user_id = Auth::id();
        $company->save();
        $text = $company->activated ? 'ativada' : 'desativada';
        Toast::info("Empresa $text com sucesso!");
    }
    public function delete(int $id)
    {
        $company = Company::findOrFail($id);
        $company->historicCompany()->forceDelete();
        $company->forceDelete();
        Toast::warning("Empresa $id deletada com sucesso!");
    }
}
