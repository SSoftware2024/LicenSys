<?php

namespace App\Http\Controllers\API;

use App\Enum\MonthlyFee;
use App\Http\Controllers\Controller;
use App\Services\API\LicenseManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LicenseManagerController extends Controller
{
    public function getMonths(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => ['required', 'string', 'uuid'],
            'month' => ['required', 'integer', 'between:0,12'],
            'year' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != 'all' && !is_numeric($value)) {
                        $fail("O {$attribute} deve ser 'all' ou um número válido.");
                    }
                }
            ],
            'monthly_fee' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_array($value) && $value != 'all') {
                        $fail("O {$attribute} deve ser 'all' ou um array de status válidos.");
                    }
                    if (is_array($value)) {
                        foreach ($value as $item) {
                            if (!in_array($item, MonthlyFee::cases())) {
                                $fail("O {$attribute} contém um valor inválido: {$item}");
                            }
                        }
                    }
                }
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro na validação dos dados',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = (new LicenseManagerService())->getMonths(
            $request->uuid,
            $request->month,
            $request->year,
            $request->monthly_fee
        );
        return response()->json($data);
    }

    public function getData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => ['required', 'string', 'uuid'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro na validação dos dados',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = (new LicenseManagerService())->getData($request->uuid);
        return response()->json($data);
    }
}
