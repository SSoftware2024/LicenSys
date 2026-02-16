<?php

namespace App\Services;

use App\Classes\Abstract\CRUD;
use App\Models\GroupCompany;

final class CompanyGroupService extends CRUD
{
    protected function getModel()
    {
        return GroupCompany::class;
    }


    public function deleteWithRelations(int $id):int
    {
        $group_company = GroupCompany::find($id);
        $company_count = $group_company->company()->count();
        if ($company_count > 0) {
            $group_company->company()->update(['group_company_id' => null]);
        }
        $group_company->forceDelete();
        return $company_count;
    }

    public function read(string|null $search_name = '')
    {
        $company_groups = GroupCompany::query();
        if (isset($search_name) && !empty($search_name)) {
            $company_groups->where('name', 'like', "%$search_name%");
        }
        return $company_groups = $company_groups->withCount('company')->orderBy('name')->paginate();
    }
}
