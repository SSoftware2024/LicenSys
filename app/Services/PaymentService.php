<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class PaymentService
{
    #===================================================================VIEWS==================================================================#
    public function indexView()
    {
        return Payment::with(['company' => function ($query) {
            $query->select('id', 'company_name');
        }])->with(['historicCompany' => function ($query) {
            $query->select('id', 'amount_paid', 'pay_date', 'monthly_fee_status');
        }])->get();
    }

    public function pixReceiptPhotoUrl(int $id)
    {
        $file_name = Payment::where('id', $id)->first()->pix_receipt_photo;
        return Storage::disk('local')->temporaryUrl(
            'statement/' . $file_name,
            now()->addMinute(2)
        );
    }
}
