<?php

namespace App\Services;

use App\Classes\Abstract\CRUD;
use App\Classes\CompanyClass;
use App\Classes\HistoricCompanyClass;
use App\Classes\SystemClass;
use App\Enum\MonthlyFee;
use App\Models\Company;
use App\Models\GroupCompany;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

final class CompanyService extends CRUD
{
    protected function getModel()
    {
        return Company::class;
    }

    public function index(array $filter, ?CarbonInterface $date = null, Builder $companies): mixed
    {
        $companyClass = new CompanyClass();
        $companies = $companyClass->buildFilterCompanyQuery($filter, $date, $companies);
        $companies = $companies->paginate();
        $companies->getCollection()->transform(function ($company) {
            //filtro relaizado acima, apenas cria atributo dinâmico
            $company->current_month_status = $company->historicCompany->first()->monthly_fee_status ?? null;
            $company->value_monthly_fee_formated = getMoneyToStringBr($company->value_monthly_fee);
            return $company;
        });
        return $companies;
    }

    public function createWithHistoric(array $data)
    {
        $company = $this->create([
            'uuid' => $data['uuid'],
            'company_name' => strtoupper($data['company_name']),
            'payment_day' => $data['payment_day'],
            'systems_useds' => $data['systems_useds'],
            'value_monthly_fee' => convertToMoney($data['value_monthly_fee']),
            'group_company_id' => $data['group_company_id'],
            'activated' => $data['activated'],
            'isFiscal' => false,
            'created_by_user_id' => Auth::id()
        ]);
        HistoricCompanyClass::generate($company);
    }
    public function updatePrepareData(Company|int $company, array $data): mixed
    {
        $data = [
            'payment_day' => $data['payment_day'],
            'company_name' => strtoupper($data['company_name']),
            'systems_useds' => $data['systems_useds'],
            'value_monthly_fee' => convertToMoney($data['value_monthly_fee']),
            'group_company_id' => $data['group_company_id'],
            'activated' => $data['activated'],
            'isFiscal' => false,
            'updated_by_user_id' => Auth::id()
        ];
        if (is_int($company)) {
            $company = $this->update($company, $data);
        } else {
            $company = $company->update($data);
        }
        return $company;
    }

    public function toggleActive(int $id):bool
    {
        $company = Company::findOrFail($id);
        $company->activated = !$company->activated;
        $company->updated_by_user_id = Auth::id();
        $company->save();
        return $company->activated;
    }

    public function deleteWithHistoric(int $id)
    {
        $company = Company::findOrFail($id);
        $company->historicCompany()->forceDelete();
        $company->forceDelete();
    }

    public function read() {}

    #===================================================================VIEWS==================================================================#
    public function createViewData()
    {
        $uuid = Company::uuidExists();
        $systems_for_sale = (new SystemClass())->getSystemsForSale();
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();

        return compact('uuid', 'systems_for_sale', 'groups_company', 'monthly_fee_status');
    }

    public function updateViewData(int $id)
    {
        $company =  Company::findOrFail($id);
        $systems_for_sale = (new SystemClass())->getSystemsForSale();
        $groups_company = GroupCompany::orderBy('name')->get();
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();

        return compact('company', 'systems_for_sale', 'groups_company', 'monthly_fee_status');
    }
}
