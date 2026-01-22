<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\MonthsNewYear;

class MonthsNewYearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:months-to-new-year-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verfica se empresa não possui meses gerados do ano atual e gera os meses do ano novo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new MonthsNewYear())->generateMonthsToNewYear();
    }
}
