<?php

namespace Cotiga\ModuleTickers;

use Filament\Contracts\Plugin;
use Filament\Panel;

class ModuleTickersPlugin implements Plugin
{
    public static function make(): static
    {
        return new static;
    }

    public function getId(): string
    {
        return 'tickers';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverResources(
            in: __DIR__.'/Filament/Resources',
            for: 'Cotiga\\ModuleTickers\\Filament\\Resources',
        );
    }

    public function boot(Panel $panel): void {}
}
