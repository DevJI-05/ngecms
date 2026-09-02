<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Forms\Components\IconPicker;
use App\Support\HexColor;
use App\Support\ServiceIconOptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Service Name')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('tagline')
                            ->label('Tagline')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('cat')
                            ->label('Category')
                            ->options([
                                'pipeline' => 'Gas Pipeline',
                                'cng' => 'CNG',
                                'maintenance' => 'Maintenance',
                                'engineering' => 'Engineering',
                                'safety' => 'Safety & HSE',
                            ])
                            ->native(false)
                            ->required(),
                        IconPicker::make('icon')
                            ->label('Icon')
                            ->options(ServiceIconOptions::options())
                            ->required()
                            ->rule(Rule::in(array_keys(ServiceIconOptions::options()))),
                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('foot_note')
                            ->label('Footnote')
                            ->helperText('Example: Estimated project: 3 — 18 months')
                            ->required(),
                        Textarea::make('prompt')
                            ->label('WhatsApp Inquiry Message')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Appearance')
                    ->columns(3)
                    ->components([
                        ColorPicker::make('icon_bg')->label('Icon Background')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('icon_color')->label('Icon Color')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('accent')->label('Accent Color')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('badge_bg')->label('Badge Background')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('badge_color')->label('Badge Text Color')->regex(HexColor::REGEX)->required(),
                    ]),

                Section::make('Badges')
                    ->components([
                        Repeater::make('badges')
                            ->label('Badges')
                            ->simple(TextInput::make('badge')->required())
                            ->default([])
                            ->addActionLabel('Add badge'),
                    ]),

                Section::make('Scope of Work / Specifications')
                    ->components([
                        Repeater::make('sections')
                            ->label('Sections')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Section Title')
                                    ->required(),
                                Repeater::make('items')
                                    ->label('Points')
                                    ->simple(TextInput::make('item')->required())
                                    ->default([])
                                    ->addActionLabel('Add point'),
                            ])
                            ->default([])
                            ->addActionLabel('Add section')
                            ->columnSpanFull(),
                    ]),

                TextInput::make('sort_order')
                    ->label('Display Order')
                    ->integer()
                    ->minValue(0)
                    ->default(0),
            ]);
    }
}
