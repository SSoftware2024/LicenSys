<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\TransferService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __construct(
        private TransferService $service
    ) {}

    public function proccess(Request $request)
    {
        $request->validate([
            'company_uuid' => ['required', 'uuid', 'exists:companies,uuid'],
            'historic_company_id' => ['required', 'exists:historic_companies,id'],
            'pix_origin_name' => ['required', 'string', 'min:10'],
            'pix_receipt_photo' => ['required', 'file', 'max:1024', 'mimes:jpg,jpeg,png,pdf'],
        ]);
        $data_pix = array_filter(
            $request->all(),
            fn($key) => str_starts_with($key, 'pix_'),
            ARRAY_FILTER_USE_KEY //usa como value a key
        );
        $this->service->proccess($request->company_uuid, $request->historic_company_id, $data_pix);

    }
}
