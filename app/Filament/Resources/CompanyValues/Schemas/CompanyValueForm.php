<?php

namespace App\Filament\Resources\CompanyValues\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Value Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('icon')
                            ->label('Icon (emoji)')
                            ->helperText('Example: 🛡️, ⚙️, 🤝')
                            ->required(),
                        TextInput::make('name')
                            ->label('Value Name')
                            ->required(),
                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull(),
                        ColorPicker::make('accent')
                            ->label('Accent Color')
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }
}
