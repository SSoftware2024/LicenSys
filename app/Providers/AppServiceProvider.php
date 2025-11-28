<?php

namespace App\Providers;

use App\Console\Commands\MonthlyStatusServiceCommand;
use App\Enum\TypeUser;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
