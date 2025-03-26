<?php

namespace App\Http\Controllers;

use App\Enum\TypeUser;
use Inertia\Inertia;
use App\Facades\Toast;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Inertia\Response as InertiaResponse;

class UserController extends Controller
{
    public function index(Request $request): InertiaResponse | RedirectResponse
    {
        if($request->type === TypeUser::ADMIN->value && Gate::denies('admin-access')){
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
        if($request->type === TypeUser::ADMIN->value && Gate::denies('admin-access')){
            Toast::warning('Você não tem acesso a página requistada');
            return redirect()->route('user');
        }
        return Inertia::render('User/Save', [
            'type_user' => $request->type
        ]);
    }
}
