<?php

namespace App\Http\Controllers;

use App\Facades\Toast;
use App\Models\Transfer;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransferController extends Controller
{
    public function __construct(
        private TransferService $service
    ) {}
    public function index()
    {
        $data = $this->service->indexView();
        // \broadcast(new \App\Events\TransferCountEvent());
        return Inertia::render('Transfer/Index', [
            'transfers' => $data
        ]);
    }

    public function pixReceiptPhotoUrl(Request $request)
    {
        return response()->json([
            'statement_url' => $this->service->pixReceiptPhotoUrl($request->id)
        ]);
    }

    public function processTransfer(Request $request)
    {
        try {
            $toast = $this->service->processTransfer($request->id, $request->historic_company_id);
            Toast::{$toast['type']}($toast['msg']);
        } catch (\Exception $e) {
            Toast::warning($e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $this->service->delete($id);
            Toast::success('Transferência removida com sucesso');
        } catch (\Exception $e) {
            Toast::warning($e->getMessage());
        }
    }

    public function count()
    {
        return response()->json([
            'count' => Transfer::count()
        ]);
    }
}
