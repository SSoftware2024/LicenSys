<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Enum\TypeUser;
use App\Facades\Toast;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $service
    ) {}
    public function index(Request $request)
    {
        $type = $request->type ?: TypeUser::DEFAULT->value;

        if ($type === TypeUser::ADMIN->value && Gate::denies('adminAccess')) {
            Toast::warning('Você não tem acesso a página requistada');
            return redirect()->back();
        }

        $type = TypeUser::from($type);
        $users = $this->service->searchWithType(type: $type, name_email: $request->name_email);
        return Inertia::render('User/Index', [
            'type_user' => $request->type,
            'users' => $users,
        ]);
    }
    public function saveView(Request $request): InertiaResponse | RedirectResponse
    {
        if ($request->type === TypeUser::ADMIN->value && Gate::denies('adminAccess')) {
            Toast::warning('Você não tem acesso a página requistada');
            return redirect()->route('user', [
                'type' => TypeUser::DEFAULT->value
            ]);
        }
        $data = $this->service->ruleSaveView($request->id);
        $user = $data['user'];
        if(!$data['success']){
            Toast::warning($data['message']);
            return redirect()->route('user', [
                'type' => $data['user_type']
            ]);
        }
        
        return Inertia::render('User/Save', [
            'type_user' => $request->type,
            'operation' => $request->operation,
            'id' => $request->id ?: null,
            'user' => $user,
        ]);
    }

    public function profileEditView(): InertiaResponse
    {
        $user = User::select('name', 'email')->find(Auth::id());
        return Inertia::render('Auth/ProfileEdit', [
            'user' => $user,
        ]);
    }
    public function profileEdit(Request $request)
    {
        $user = Auth::user();
        switch ($user->type) {
            case TypeUser::ADMIN->value:
                (new UpdateUserProfileInformation())->update(
                    $user,
                    $request->only('name', 'email')
                );
                break;
            case TypeUser::DEFAULT->value:
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                break;

            default:
                break;
        }
        Toast::success('Perfil atualizado com sucesso!');
    }
    public function updatePassword(Request $request)
    {
        (new UpdateUserPassword)->update(Auth::user(), $request->all());
        Toast::success('Senha atualizada com sucesso!');
    }

    public function save(Request $request)
    {
        $data = $request->except('operation', 'type');
        switch ($request->operation) {
            case 'create':
                $user = $this->create($data, $request->type);
                Toast::success('Usuário cadastrado com sucesso');
                $user->fresh();

                if (Gate::allows('adminAccess')) {
                    return redirect()->route('user.saveView', [
                        'operation' => 'update',
                        'type' => $request->type,
                        'id' => $user->id
                    ]);
                } else {
                    return redirect()->route('user', TypeUser::DEFAULT->value);
                }
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
    public function delete($id)
    {
        User::where('id', $id)->delete();
        Toast::success('Usuário deletado com sucesso');
    }

    public function toggleActivete(Request $request)
    {
        $data = $this->service->toggleActivete($request->id, $request->value);
        Toast::{$data['type_toast']}($data['message']);
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
                $user = $this->service->createDefaultUser($data);
                break;
        }
        return $user;
    }
    private function update(array $data, string $type)
    {

        switch ($type) {
            case 'admin':

                $this->validateSaveData($data, 'update');
                $user = User::find($data['id']);
                $user->name = $data['name'];
                $user->activated = (bool) $data['activated'];
                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }

                //verficação de mudança de email
                if ($data['email'] !== $user->email && $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
                    //não testada
                    $user->email = $data['email'];
                    $user->email_verified_at = null;
                    $user->save();
                    $user->sendEmailVerificationNotification();
                } else {
                    $user->email = $data['email'];
                    $user->save();
                }

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
