<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Enum\TypeUser;
use App\Facades\Toast;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Actions\Fortify\CreateNewUser;
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
            return redirect()->route('user', [
                'type' => TypeUser::DEFAULT->value
            ]);
        }
        $id = $request->id;
        $user = null;
        if(!empty($id)){
            $user = User::select('id','name','email','activated')->find($id);

            //verficar se posso editar esse usuário, não pode ser eu mesmo e user comum não pode editar admin
        }

        return Inertia::render('User/Save', [
            'type_user' => $request->type,
            'operation' => $request->operation,
            'id' => $request->id ?: null,
            'user' => $user,
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->except('operation','type');
        switch ($request->operation) {
            case 'create':
                $user = $this->create($data, $request->type);
                Toast::success('Usuário cadastrado com sucesso');
                $user->fresh();
                return redirect()->route('user.saveView', [
                    'operation' => 'update',
                    'type' => $request->type,
                    'id' => $user->id
                ]);
                break;
            case 'update':
                $this->update($data, $request->type);
                Toast::success('Usuário atualizado com sucesso');
                break;

            default:
                # code...
                break;
        }
    }
    /* ----------------------------- PRIVATE METHODS ---------------------------- */

    private function create(array $data, string $type): User
    {
        $user = null;
        switch ($type) {
            case 'admin':
                $createNewUser = new CreateNewUser();
                $user = $createNewUser->create(input: $data);
                break;

            default:
                // user default
                $this->validateSaveData($data, 'create');
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
        switch ($type) {
            case 'admin':
                // $createNewUser = new CreateNewUser();
                // $user = $createNewUser->create(input: $data);
                break;

            default:
                // user default
                $this->validateSaveData($data, 'update');
                $user = User::find($data['id']);
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->activated = (bool) $data['activated'];
                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }
                $user->save();
                break;
        }
    }

    private function validateSaveData(array $data, string $operation): void
    {
        $validate = [];
        switch ($operation) {
            case 'create':
                $validate = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        'unique:users',
                    ],
                    'password' => ['required', 'string', Password::default(), 'confirmed'],
                ];
                break;
            case 'update':
                $validate =  [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        Rule::unique(User::class)->ignore($data['id']),
                    ],
                    'password' => ['nullable', 'string', Password::default(), 'confirmed'],
                ];
                break;

            default:
                # code...
                break;
        }
        Validator::make($data, $validate)->validate();
    }
}
