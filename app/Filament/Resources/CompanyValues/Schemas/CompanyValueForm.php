<?php

namespace App\Filament\Resources\CompanyValues\Schemas;

use App\Filament\Forms\Components\IconPicker;
use App\Support\CompanyValueIcons;
use App\Support\HexColor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class CompanyValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Value Details')
                    ->columns(2)
                    ->components([
                        IconPicker::make('icon')
                            ->label('Icon')
                            ->options(CompanyValueIcons::options())
                            ->required()
                            ->rule(Rule::in(array_keys(CompanyValueIcons::options()))),
                        TextInput::make('name')
                            ->label('Value Name')
                            ->required(),
                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull(),
                        ColorPicker::make('accent')
                            ->label('Accent Color')
                            ->regex(HexColor::REGEX)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->integer()
                            ->minValue(0)
                            ->default(0),
                    ]),
            ]);
    }
}
