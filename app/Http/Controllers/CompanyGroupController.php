<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyGroupController extends Controller
{
    function index()
    {
        return Inertia::render('CompanyGroup/Index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
        ]);
        ds('here');
    }
}
