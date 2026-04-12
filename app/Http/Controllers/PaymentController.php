<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $service
    ) {
        
    }
    public function index()
    {
        $data = $this->service->indexView();
        return Inertia::render('Payment/Index', [
            'payments' => $data
        ]);
    }

    public function pixReceiptPhotoUrl(Request $request){
        return response()->json([
            'statement_url' => $this->service->pixReceiptPhotoUrl($request->id)
        ]);
    }
}
