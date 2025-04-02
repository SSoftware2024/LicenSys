<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Inertia\Inertia;
use App\Enum\TypeUser;
use App\Facades\Toast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request): InertiaResponse | RedirectResponse
    {
        if ($request->type === TypeUser::ADMIN->value && Gate::denies('admin-access')) {
            Toast::warning('Você não tem acesso a página requistada');
            return redirect()->back();
        }
        $type = $request->type ?: TypeUser::DEFAULT->value;
        //buscar usuario de acordo com type
        return Inertia::render('User/Index', [
            'type_user' => $request->type
        ]);
    }
    public function saveView(Request $request): InertiaResponse | RedirectResponse
    {
        if ($request->type === TypeUser::ADMIN->value && Gate::denies('admin-access')) {
            Toast::warning('Você não tem acesso a página requistada');
            return redirect()->route('user');
        }
        return Inertia::render('User/Save', [
            'type_user' => $request->type,
            'operation' => $request->operation,
        ]);
    }

    private function create(array $data, string $type)
    {
        $user = null;
        switch ($type) {
            case 'admin':
                    $createNewUser = new CreateNewUser();
                    $user = $createNewUser->create(input: $data);
                break;

            default:
                // user default
                Validator::make($data, [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        'unique:users',
                    ],
                    'password' => ['required', 'string', Password::default(), 'confirmed'],
                ])->validate();
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'email_verified_at' =>  now(),
                    'password' => Hash::make($data['password']),
                    'type' => TypeUser::DEFAULT->value,
                    'activated' => (bool) $data['activated']
                ]);
                break;
        }
        return $user;
    }
    private function update(array $data, string $type)
    {
        #teste
    }
    public function save(Request $request)
    {
        $data = $request->except('operation');
        switch ($request->operation) {
            case 'create':
                $user = $this->create($data, $request->type);
                Toast::success('Usuário cadastrado com sucesso');
                $user->fresh();
                return redirect()->route('user.saveView', [
                    'operation' => 'update',
                    'type' => $data['type'],
                    'id' => $user->id
                ]);
                break;
            case 'update':
                // $this->update([],'');
                break;

            default:
                # code...
                break;
        }
    }
}
