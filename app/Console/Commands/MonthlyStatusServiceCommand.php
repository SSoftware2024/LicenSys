<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MonthlyStatusService;

class MonthlyStatusServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monthly-status-service-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a cada dia a meia noite todos os status mensais das empresas no ano atual';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new MonthlyStatusService())->updateAllCompaniesMonthlyStatus();
    }
}
