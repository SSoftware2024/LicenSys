<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

#------------------------------CRON JOBS----------------------------------#
Schedule::command('app:monthly-status-service-command')->daily(); //todos os dias à meia noite
