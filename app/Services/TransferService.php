<?php

namespace App\Services;

use App\Enum\MonthlyFee;
use App\Enum\ToastType;
use App\Models\HistoricCompany;
use App\Models\PaymentMethod;
use App\Models\Transfer;
use Illuminate\Support\Facades\Storage;

class TransferService
{
    #===================================================================VIEWS==================================================================#
    public function indexView()
    {
        return Transfer::with(['company' => function ($query) {
            $query->select('id', 'company_name');
        }])->with(['historicCompany' => function ($query) {
            $query->select('id', 'amount_paid', 'pay_date', 'monthly_fee_status');
        }])->get();
    }

    public function pixReceiptPhotoUrl(int $id)
    {
        $file_name = Transfer::where('id', $id)->first()->pix_receipt_photo;
        return Storage::disk('local')->temporaryUrl(
            'statement/' . $file_name,
            now()->addMinute(2)
        );
    }

    public function processTransfer(int $id, int $historic_company_id)
    {

        $historicCompany = HistoricCompany::find($historic_company_id);
        $toast = [
            'type' => ToastType::SUCCESS->value,
            'msg' => ''
        ];
        if(!PaymentMethod::where('name', 'pix')->exists()) throw new \Exception("Forma de pagamento 'pix' não encontrada");
        
        if ($historicCompany->monthly_fee_status != MonthlyFee::PAID->value) {
            //inserir forma de pagamento como pix e o valor
            $payment_methods_list = [
                [
                    'payment_method_id' => PaymentMethod::where('name', 'pix')->first()->id,
                    'value' => (float) $historicCompany->amount_paid
                ]
            ];
            (new HistoricPaymentMethodsService)->create($payment_methods_list, $historic_company_id);
            //pagar
            (new HistoricCompanyService)->pay($historic_company_id);
            //deletar transferencia
            $this->delete($id);
            $toast['msg'] = 'Baixa realizada com sucesso';
        } else {
            $this->delete($id);
            $toast = [
                'type' => ToastType::INFO->value,
                'msg' => 'Transferência excluida, pagamento já havia sido realizado'
            ];
        }
        return $toast;
    }

    public function delete(int $id)
    {
        $transfer = Transfer::find($id);
        $path = "statement/{$transfer->pix_receipt_photo}";
        $is_deleted = Storage::exists($path) && Storage::delete($path);
        if (!$is_deleted) {
            throw new \Exception("Caminho do arquivo não encontrado.");
        }
        $transfer->forceDelete();
    }
}
