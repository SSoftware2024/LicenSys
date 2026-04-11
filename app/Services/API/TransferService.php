<?php

namespace App\Services\API;

use App\Models\Company;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class TransferService
{
    public function proccess(string $company_uuid, int $historic_company_id, array $data_pix)
    {
        //colocar transaction
        DB::beginTransaction();
        try {
            $company_id = Company::where('uuid', $company_uuid)->first()->id;
            $file = $data_pix['pix_receipt_photo'];
            $file->storeAs('statement/',$file->getClientOriginalName(), 'local');
            Payment::create([
                'company_id' => $company_id,
                'historic_company_id' => $historic_company_id,
                'pix_origin_name' => $data_pix['pix_origin_name'],
                'pix_receipt_photo' => $file->getClientOriginalName()
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function settle() {}
    public function cancel() {}
}
