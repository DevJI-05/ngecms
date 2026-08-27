<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Support\ServiceIconOptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

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
                        Select::make('icon')
                            ->label('Icon')
                            ->options(ServiceIconOptions::options())
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->required(),
                        Placeholder::make('icon_preview')
                            ->label('Preview')
                            ->content(fn (Get $get): HtmlString => new HtmlString(
                                '<i class="ti '.e($get('icon')).'" style="font-size: 22px;"></i>',
                            )),
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
                        ColorPicker::make('icon_bg')->label('Icon Background')->required(),
                        ColorPicker::make('icon_color')->label('Icon Color')->required(),
                        ColorPicker::make('accent')->label('Accent Color')->required(),
                        ColorPicker::make('badge_bg')->label('Badge Background')->required(),
                        ColorPicker::make('badge_color')->label('Badge Text Color')->required(),
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
                    ->numeric()
                    ->default(0),
            ]);
    }
}
