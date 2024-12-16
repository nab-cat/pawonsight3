<?php

namespace App\Providers;

use App\Models\stokbahan;
use Illuminate\Contracts\View\View;
use App\Observers\StokBahanObserver;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;


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
        stokbahan::observe(StokBahanObserver::class);
    }
}
