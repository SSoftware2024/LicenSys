<?php

namespace App\Http\Controllers;

use App\Services\TransferService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransferController extends Controller
{
    public function __construct(
        private TransferService $service
    ) {
        
    }
    public function index()
    {
        $data = $this->service->indexView();
        return Inertia::render('Transfer/Index', [
            'transfers' => $data
        ]);
    }

    public function pixReceiptPhotoUrl(Request $request){
        return response()->json([
            'statement_url' => $this->service->pixReceiptPhotoUrl($request->id)
        ]);
    }
}
