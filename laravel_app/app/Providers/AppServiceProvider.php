<?php

namespace App\Providers;

use App\Repositories\BarangRepository;
use App\Repositories\Interfaces\IBarangRepository;
use App\Repositories\KategoriRepository;
use App\Repositories\Interfaces\IKategoriRepository;
use App\Services\BarangService;
use App\Services\Interfaces\IBarangService;
use App\Services\KategoriService;
use App\Services\Interfaces\IKategoriService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IBarangRepository::class, BarangRepository::class);
        $this->app->bind(IKategoriRepository::class, KategoriRepository::class);
        $this->app->bind(IBarangService::class, BarangService::class);
        $this->app->bind(IKategoriService::class, KategoriService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
