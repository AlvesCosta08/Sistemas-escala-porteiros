<?php

namespace App\Providers;

use App\Models\Alocacao;
use App\Policies\AlocacaoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Alocacao::class, AlocacaoPolicy::class);
    }
}