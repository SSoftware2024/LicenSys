<?php

namespace App\Http\Controllers;

use App\Services\PaymentMethodService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_methods = (new PaymentMethodService())->read();
        return Inertia::render('PaymentMethod/Index', [
            'payment_methods' => $payment_methods
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);
        $data = $request->only('name');
        (new PaymentMethodService())->create($data);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:payment_methods,id'],
            'name' => ['required', 'string', 'max:255']
        ]);
        $data = $request->only('name');
        (new PaymentMethodService())->update($request->id,$data);
    }
}
