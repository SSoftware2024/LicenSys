<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Enum\TypeUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;

class UserController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        // ds($request->type);
        return Inertia::render('User/Index');
    }
}
