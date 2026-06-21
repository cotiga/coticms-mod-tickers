<?php

namespace Cotiga\ModuleTickers\Filament\Resources\Tickers;

use BackedEnum;
use Cotiga\ModuleTickers\Filament\Resources\Tickers\Pages\CreateTicker;
use Cotiga\ModuleTickers\Filament\Resources\Tickers\Pages\EditTicker;
use Cotiga\ModuleTickers\Filament\Resources\Tickers\Pages\ListTickers;
use Cotiga\ModuleTickers\Filament\Resources\Tickers\Schemas\TickerForm;
use Cotiga\ModuleTickers\Filament\Resources\Tickers\Tables\TickersTable;
use Cotiga\ModuleTickers\Models\Ticker;
use Filament\Resources\Resource;
use UnitEnum;

class TickerResource extends Resource
{
    protected static ?string $model = Ticker::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-speaker-wave';

    protected static ?string $navigationLabel = 'Annonces (bandeau)';

    protected static ?string $modelLabel = 'annonce';

    protected static ?string $pluralModelLabel = 'annonces';

    protected static UnitEnum|string|null $navigationGroup = 'Annonces';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return \Cotiga\CotiCmsCore\Models\ModuleSettings::get()->tickers_actif;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny();
    }

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return TickerForm::make($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return TickersTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickers::route('/'),
            'create' => CreateTicker::route('/create'),
            'edit' => EditTicker::route('/{record}/edit'),
        ];
    }
}
