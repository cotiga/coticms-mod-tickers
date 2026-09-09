<?php

namespace Cotiga\ModuleTickers\Filament\Resources\Tickers\Pages;

use Cotiga\CotiCmsCore\Filament\Pages\CotiEditRecord;
use Cotiga\ModuleTickers\Filament\Resources\Tickers\TickerResource;
use Filament\Actions\DeleteAction;

class EditTicker extends CotiEditRecord
{
    protected static string $resource = TickerResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
