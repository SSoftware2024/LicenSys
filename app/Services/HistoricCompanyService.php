<?php

namespace App\Services;

use App\Classes\Abstract\CRUD;
use App\Enum\MonthlyFee;
use App\Models\Company;
use App\Models\HistoricCompany;
use App\Services\Cron\MonthlyFeeCron;
use Illuminate\Http\Request;

final class HistoricCompanyService extends CRUD
{
    public function getModel()
    {
        return HistoricCompany::class;
    }

    public function read() {}

    public function pay(int $id): mixed
    {
        return HistoricCompany::where('id', $id)->update([
            'monthly_fee_status' => MonthlyFee::PAID->value,
            'date_paid' => now(),
        ]);
    }
    /**
     * Method removePayment
     *
     * Atuaiza status de pago para atrasado ou vencido
     * 
     * @param int $id
     *
     * @return mixed
     */
    public function removePayment(int $id): mixed
    {
        $historicCompany = HistoricCompany::find($id);
        $historicCompany->monthly_fee_status = (new MonthlyFeeCron())->getStatusMonthByDate($historicCompany, true);
        $historicCompany->date_paid = null;
        return $historicCompany->save();
    }

    /**
     * Method loadHistoric
     *
     * Retorna dados da tabela HistoricCompany com filtro predefinido
     * 
     * @param ?string $year 
     * @param string|int|null $month 
     * @param array|string|null $month_fee_status 
     * @param string $company_uuid 
     * @param array $appends 
     *
     * @return mixed
     */
    public function loadHistoric(
        ?string $year = null,
        string|int|null $month = 0,
        array|string|null $month_fee_status = null,
        string $company_uuid = 'empty',
        array $appends = []
    ) {
        $year = $year ?: 0;
        $month = $month ?: 0;
        $month_fee_status = $month_fee_status ?: [];
        $historicCompany = HistoricCompany::query();
        $historicCompany->with('company:id,company_name,uuid');

        if ($year != 'all') {
            $historicCompany->whereYear('pay_date', $year);
        }
        if ($company_uuid != 'empty') {
            $company_id = Company::where('uuid', $company_uuid)->first()->id;
            $historicCompany->where('company_id', $company_id);
        }
        //caso não seja vazio e caso array não contenha null == todos status
        if ($month_fee_status != 'all' && !in_array('all', $month_fee_status) && !in_array(null, $month_fee_status)) {
            $historicCompany->whereIn('monthly_fee_status', $month_fee_status);
        }
        if ($month > 0 && $month <= 12) {
            $historicCompany->whereMonth('pay_date', $month);
        }

        $historicCompany->orderBy('pay_date', 'desc');
        return $historicCompany->paginate(12)->appends($appends);
    }


    # =====================================RULE VIEWS========================================#

    public function indexViewData(Request $request): array
    {
        $monthly_fee_status = MonthlyFee::toArrayPortuguese();
        $companies = Company::select('id', 'uuid', 'company_name')->get();
        $allYears = range(2025, date('Y'));
        $historicCompany = null;
        if (isset($request->month_status)) {
            $historicCompany = $this->loadHistoric(
                $request->year,
                $request->month,
                $request->month_status,
                $request->company_uuid,
                $request->all()
            );
        }
        $url_paramters = [
            'year' => $request->year ?? 'all',
            'company_uuid' => $request->company_uuid ?? 'empty',
            'month_status' => $request->month_status ?? 'all',
            'month' => $request->month ?? 0,
        ];
        return compact(
            'monthly_fee_status',
            'companies',
            'allYears',
            'historicCompany',
            'url_paramters'
        );
    }
}
