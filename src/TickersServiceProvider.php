<?php

namespace Cotiga\ModuleTickers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TickersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tickers');
        $this->publishes([__DIR__.'/../resources/views' => resource_path('views/vendor/tickers')], 'module-tickers-views');
        $this->publishes([__DIR__.'/../resources/dist/module-tickers.css' => public_path('vendor/module-tickers/module-tickers.css')], 'module-tickers-assets');

        $css = public_path('vendor/module-tickers/module-tickers.css');
        if (! file_exists($css)) {
            @mkdir(dirname($css), 0755, true);
            @copy(__DIR__.'/../resources/dist/module-tickers.css', $css);
        }

        // CSS du module chargé sur TOUTES les pages (barre en tête de site, etc.),
        // où un @push('styles') local ne serait jamais exécuté.
        try {
            if ($this->app->bound('coti.css') && \Cotiga\CotiCmsCore\Models\ModuleSettings::get()->tickers_actif) {
                $this->app->make('coti.css')->push(asset('vendor/module-tickers/module-tickers.css'));
            }
        } catch (\Exception $e) {
            // Table modules pas encore migrée
        }

        // <x-tickers::bar /> → resources/views/components/bar.blade.php
        Blade::anonymousComponentNamespace('tickers::components', 'tickers');
    }
}
