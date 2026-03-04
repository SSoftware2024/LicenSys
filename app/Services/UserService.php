<?php

namespace App\Services;

use App\Enum\TypeUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

final class UserService
{
    public function searchWithType(TypeUser $type, string|null $name_email)
    {
        //buscar usuario de acordo com type
        return User::where('type', $type->value)->where('id', "!=", Auth::id())
            ->when($name_email, function ($query, $value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('name', 'asc')
            ->paginate();
    }

    public function createDefaultUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' =>  now(),
            'password' => Hash::make($data['password']),
            'type' => TypeUser::DEFAULT->value,
            'activated' => (bool) $data['activated']
        ]);
    }
    public function toggleActivete(int $id, bool $value)
    {
        $value = !$value;
        $type_toast = $value ? 'success' : 'info';
        $message = 'Usuário ' . ($value ? 'ativado' : 'desativado');
        User::where('id', $id)->update([
            'activated' => $value
        ]);
        return [
            'type_toast' => $type_toast,
            'message' => $message
        ];
    }
    # =========================================================== VIEWS ================================================================== #
    public function ruleSaveView(int|null $id)
    {
        $data = [
            'user' => null,
            'success' => true,
            'message' => '',
            'user_type' => ''
        ];
        if (!empty($id)) {
            $user = User::select('id', 'name', 'email', 'activated')->find($id);
            $data['user'] = $user;
            //verficar se posso editar esse usuário, não pode ser eu mesmo e user comum não pode editar admin
            if (Gate::allows('isMe', $id)) {
                $data['success'] = false;
                $data['message'] = 'Você não pode editar a si mesmo na edição genérica de usuários.';
                $data['user_type'] = $user->type;
            } else if (Gate::denies('adminAccess') && $user->type == TypeUser::ADMIN->value) { //user default tentando editar user admin
                $data['success'] = false;
                $data['message'] = 'Você não tem permissão para editar este usuário.';
                $data['user_type'] = TypeUser::DEFAULT->value;
            }
        }
        return $data;
    }
}
