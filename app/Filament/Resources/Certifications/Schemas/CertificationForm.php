<?php

namespace App\Filament\Resources\Certifications\Schemas;

use App\Support\HexColor;
use App\Support\ServiceIconOptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

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
                        Select::make('icon')
                            ->label('Icon')
                            ->options(ServiceIconOptions::options())
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->required(),
                        ColorPicker::make('icon_bg')->label('Icon Background')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('icon_color')->label('Icon Color')->regex(HexColor::REGEX)->required(),
                        Placeholder::make('icon_preview')
                            ->label('Preview')
                            ->content(fn (Get $get): HtmlString => new HtmlString(
                                '<i class="ti '.e($get('icon')).'" style="font-size: 22px;"></i>',
                            )),
                    ]),
            ]);
    }
}
