<?php

namespace App\Providers;

use App\Models\User;
use App\Enum\TypeUser;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Console\Commands\MonthlyStatusServiceCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->gates();
    }

    private function gates()
    {
        Gate::define('admin-access', function (User $user) {
            return $user->type === TypeUser::ADMIN->value;
        });
    }
}
