<?php

namespace App\Filament\Resources\Certifications\Schemas;

use App\Filament\Forms\Components\IconPicker;
use App\Support\HexColor;
use App\Support\ServiceIconOptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Certificate Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Certificate Name')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('issuer')
                            ->label('Issuer')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('valid_text')
                            ->label('Validity Note')
                            ->helperText('Example: Valid through 2027')
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->integer()
                            ->minValue(0)
                            ->default(0),
                    ]),

                Section::make('Icon Appearance')
                    ->columns(3)
                    ->components([
                        IconPicker::make('icon')
                            ->label('Icon')
                            ->options(ServiceIconOptions::options())
                            ->required()
                            ->rule(Rule::in(array_keys(ServiceIconOptions::options()))),
                        ColorPicker::make('icon_bg')->label('Icon Background')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('icon_color')->label('Icon Color')->regex(HexColor::REGEX)->required(),
                    ]),
            ]);
    }
}
