<?php

namespace App\Services\API;

use App\Classes\SystemClass;
use App\Facades\PixStatic;
use App\Models\Company;
use App\Models\HistoricCompany;
use App\Models\Transfer;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\DB;

class TransferService
{

    /**
     * Method proccess
     *
     * Insere tranferencia a ser dado baixa
     * @param string $company_uuid 
     * @param int $historic_company_id 
     * @param array $data_pix 
     *  ['pix_receipt_photo','pix_origin_name']
     *
     * @return void
     */
    public function proccess(string $company_uuid, int $historic_company_id, array $data_pix)
    {
        //colocar transaction
        DB::beginTransaction();
        try {
            $company_id = Company::where('uuid', $company_uuid)->first()->id;
            $file = $data_pix['pix_receipt_photo'];
            $file->storeAs('statement/', $file->getClientOriginalName(), 'local');
            Transfer::create([
                'company_id' => $company_id,
                'historic_company_id' => $historic_company_id,
                'pix_origin_name' => $data_pix['pix_origin_name'],
                'pix_receipt_photo' => $file->getClientOriginalName()
            ]);
            DB::commit();
            \broadcast(new \App\Events\TransferCountEvent());
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function getQrCodePix(int $historic_company_id)
    {
        $data_payment_pix = (new SystemClass)->getDataPayment(); //dados propietario pix
        if(empty($data_payment_pix)){
            throw new \Exception("Dados do recebedor pix não definidos", 400);
        }
        $historicCompany = HistoricCompany::where('id',$historic_company_id)->select('amount_paid','pay_date')->first();
        $payload = PixStatic::generatePayload(
            key: $data_payment_pix['pix_key'],
            name: $data_payment_pix['name_owner_pix'],
            city: 'Granja',          // Máx 25 chars, sem acento, sem "-CE"
            amount: (float) $historicCompany->amount_paid, //00.00
            txid: "LS".strtoupper(uniqid()),
            description: 'Mensalidade Licensys: '.date('d/m/Y', strtotime($historicCompany->pay_date))
        );
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(
                    300,
                    0,
                    null,
                    null,
                    Fill::uniformColor(
                        new Rgb(255, 255, 255),
                        new Rgb(0, 0, 0)
                    )
                ),
                new SvgImageBackEnd
            )
        ))->writeString($payload);
        // Remove a declaração <?xml ...> do SVG para permitir uso inline no HTML
        $clean = trim(substr($svg, strpos($svg, "\n") + 1));
        return 'data:image/svg+xml;base64,' . base64_encode(trim($clean));
    }
}
