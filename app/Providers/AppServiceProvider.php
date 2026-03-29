<?php

namespace App\Providers;

use App\Enum\TypeUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
        //em produção isto precisa estar desabilitado, parâmetro -> false
        Model::preventLazyLoading(!app()->isProduction());
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
