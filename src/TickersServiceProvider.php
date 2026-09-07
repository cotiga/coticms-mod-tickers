<?php

namespace Cotiga\ModuleTickers;

use Cotiga\CotiCmsCore\Support\ModuleAsset;
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

        // CSS du module chargé sur TOUTES les pages (barre en tête de site, etc.),
        // où un @push('styles') local ne serait jamais exécuté.
        try {
            if ($this->app->bound('coti.css') && \Cotiga\CotiCmsCore\Models\ModuleSettings::get()->tickers_actif) {
                $this->app->make('coti.css')->push(ModuleAsset::url(__DIR__.'/../resources/dist/module-tickers.css', 'module-tickers/module-tickers.css'));
            }
        } catch (\Exception $e) {
            // Table modules pas encore migrée
        }

        // <x-tickers::bar /> → resources/views/components/bar.blade.php
        Blade::anonymousComponentNamespace('tickers::components', 'tickers');

        // Déclaration au socle : activer le module suffit à voir le bandeau, aucune
        // vue de projet à modifier. Emplacement et portée réglables en admin.
        try {
            if (\Cotiga\CotiCmsCore\Models\ModuleSettings::get()->tickers_actif) {
                \Cotiga\CotiCmsCore\Support\Slots::register(
                    key: 'tickers',
                    view: 'tickers::inc.slot',
                    label: 'Bandeau d\'annonces défilantes',
                    zone: 'haut-de-page',
                    scope: 'accueil',
                );
            }
        } catch (\Exception $e) {
            // Table modules pas encore migrée
        }
    }
}
