<?php

namespace App\Providers;

use App\Models\User;
use App\Enum\TypeUser;
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
        Gate::define('adminAccess', function (User $user) {
            return $user->type === TypeUser::ADMIN->value;
        });
        Gate::define('isMe', function (User $user, int $id) {
            return $user->id === $id;
        });
    }
}
