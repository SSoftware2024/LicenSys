<?php

namespace App\Http\Controllers;

use App\Facades\Toast;
use App\Services\PaymentMethodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PaymentMethodController extends Controller
{
    public function __construct(
        private PaymentMethodService $service
    ) {}
    public function index(Request $request)
    {
        $payment_methods = $this->service->read($request->input('name',''));
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
        $this->service->create($data);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:payment_methods,id'],
            'name' => ['required', 'string', 'max:255']
        ]);
        $data = $request->only('name');
        $this->service->update($request->id, $data);
    }
    public function delete(int $id)
    {
        try {
            Validator::make(['id' => $id], [
                'id' => ['required', 'integer', 'exists:payment_methods,id'],
            ])->validate();
            $data = $this->service->deleteWithRelations($id);
            $data['success'] ?
                Toast::success('Forma de pagamento excluída com sucesso!') :
                Toast::warning("Deleção não ocorrida! Forma de pagamento já possui vínculo com baixa pagamento");
        } catch (ValidationException $e) {
            Toast::error("Erro de validação: {$e->errors()['id'][0]}");
        }
    }

    public function getPaymentMethods(){
        $this->service->getPaymentMethods();
    }
}
