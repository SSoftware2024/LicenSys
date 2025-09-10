<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Facades\Toast;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CompanyGroupController extends Controller
{
    function index()
    {
        $company_groups = GroupCompany::withCount('company')->orderBy('name')->paginate();
        return Inertia::render('CompanyGroup/Index', compact('company_groups'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5', 'unique:group_companies,name'],
        ],[
            'name.unique' => 'Grupo empresa já existente na base de dados.'
        ]);
        GroupCompany::create([
            'name' => $request->name,
        ]);
        Toast::success('Grupo criado com sucesso!');
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => ['required', 'min:5', Rule::unique(GroupCompany::class,'name')->ignore($id)],
        ],[
            'name.unique' => 'Grupo empresa já existente na base de dados.'
        ]);
        GroupCompany::where('id', $id)->update([
            'name' => $request->name,
        ]);
        Toast::success('Grupo atualizado com sucesso!');
    }

    function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:group_companies,id'],
        ]);
        $group = GroupCompany::find($request->id);
        $company_count = $group->company()->count();
        if ($company_count > 0) {
            $group->company()->update(['group_company_id' => null]);
        }
        $group->forceDelete();
        Toast::success('Grupo excluído com sucesso!');
        Toast::info("Total de $company_count desvinculadas do grupo!");
        return back();
    }
}
