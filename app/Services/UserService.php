<?php

namespace App\Services;

use App\Enum\TypeUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
}
