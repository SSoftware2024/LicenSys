<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Facades\Toast;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Services\CompanyGroupService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CompanyGroupController extends Controller
{
    public function __construct(
        private CompanyGroupService $service
    ) {}
    function index(Request $request)
    {
        $company_groups = $this->service->read($request->input('name', ''));
        return Inertia::render('CompanyGroup/Index', compact('company_groups'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:5', 'unique:group_companies,name'],
        ], [
            'name.unique' => 'Grupo empresa já existente na base de dados.'
        ]);

        $data = $request->only('name');
        $this->service->create($data);
        Toast::success('Grupo criado com sucesso!');
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => ['required', 'min:5', Rule::unique(GroupCompany::class, 'name')->ignore($id)],
            'id' => ['required', 'integer', 'exists:group_companies,id'],
        ], [
            'name.unique' => 'Grupo empresa já existente na base de dados.'
        ]);

        $data = $request->only('name');
        $this->service->update($request->input('id'), $data);
        Toast::success('Grupo atualizado com sucesso!');
    }

    function delete(int $id)
    {
        try {
            Validator::make(['id' => $id], [
                'id' => ['required', 'exists:group_companies,id'],
            ])->validate();
            $company_count = $this->service->deleteWithRelations($id);
            Toast::success('Grupo excluído com sucesso!');
            Toast::info("Total de $company_count desvinculadas do grupo!");
        } catch (ValidationException $e) {
            Toast::error("Erro de validação: {$e->errors()['id'][0]}");
        }
    }
}
