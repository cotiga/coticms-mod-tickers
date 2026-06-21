<?php

namespace Cotiga\ModuleTickers\Filament\Resources\Tickers\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class TickerForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('texte')
                    ->label('Texte de l\'annonce')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Les emojis sont autorisés (ex. 🎉, ✨).')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('lien')
                    ->label('Lien (optionnel)')
                    ->url()
                    ->maxLength(255)
                    ->helperText('URL vers laquelle pointe l\'annonce. Vide = non cliquable.')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('ordre')
                    ->label('Ordre d\'affichage')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('onl')
                    ->label('En ligne')
                    ->default(true)
                    ->inline(false),
            ])
            ->columns(2);
    }
}
