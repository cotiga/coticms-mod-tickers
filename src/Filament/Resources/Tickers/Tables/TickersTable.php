<?php

namespace Cotiga\ModuleTickers\Filament\Resources\Tickers\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TickersTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ordre')
                    ->label('Ordre')
                    ->sortable(),

                TextColumn::make('texte')
                    ->label('Texte')
                    ->searchable()
                    ->limit(60),

                TextColumn::make('lien')
                    ->label('Lien')
                    ->url(fn ($record) => $record->lien, true)
                    ->limit(30)
                    ->placeholder('—')
                    ->color('primary'),

                IconColumn::make('onl')
                    ->label('En ligne')
                    ->boolean(),
            ])
            ->defaultSort('ordre')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
