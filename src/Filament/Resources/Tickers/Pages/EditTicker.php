<?php

namespace Cotiga\ModuleTickers\Filament\Resources\Tickers\Pages;

use Cotiga\ModuleTickers\Filament\Resources\Tickers\TickerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTicker extends EditRecord
{
    protected static string $resource = TickerResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
