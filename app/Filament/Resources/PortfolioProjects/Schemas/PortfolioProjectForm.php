<?php

namespace App\Filament\Resources\PortfolioProjects\Schemas;

use App\Support\ServiceIconOptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PortfolioProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Project Name')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('cat')
                            ->label('Category')
                            ->options([
                                'pipeline' => 'Gas Pipeline',
                                'cng' => 'CNG',
                                'maintenance' => 'Maintenance',
                                'engineering' => 'Engineering',
                            ])
                            ->native(false)
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'done' => 'Completed',
                                'ongoing' => 'Ongoing',
                            ])
                            ->native(false)
                            ->required(),
                        TextInput::make('year')
                            ->label('Year')
                            ->numeric()
                            ->required(),
                        TextInput::make('scale')
                            ->label('Scale (1-5)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->default(1)
                            ->required(),
                        TextInput::make('location')
                            ->label('Location')
                            ->required(),
                        TextInput::make('client')
                            ->label('Client')
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
                    ]),

                Section::make('Appearance')
                    ->columns(3)
                    ->components([
                        ColorPicker::make('color')->label('Primary Color')->required(),
                        ColorPicker::make('bg_light')->label('Background Color')->required(),
                        ColorPicker::make('accent_text')->label('Accent Text Color')->required(),
                    ]),

                Section::make('Specifications & Stats')
                    ->columns(3)
                    ->components([
                        Repeater::make('specs')
                            ->label('Quick Specs (card badges)')
                            ->simple(TextInput::make('spec')->required())
                            ->default([])
                            ->addActionLabel('Add spec'),
                        Repeater::make('stats')
                            ->label('Stat Values')
                            ->helperText('Order must match Stat Labels')
                            ->simple(TextInput::make('value')->required())
                            ->default([])
                            ->addActionLabel('Add value'),
                        Repeater::make('stat_labels')
                            ->label('Stat Labels')
                            ->simple(TextInput::make('label')->required())
                            ->default([])
                            ->addActionLabel('Add label'),
                    ]),

                Section::make('Scope of Work & Highlights')
                    ->columns(2)
                    ->components([
                        Repeater::make('scope')
                            ->label('Scope of Work')
                            ->simple(TextInput::make('item')->required())
                            ->default([])
                            ->addActionLabel('Add item'),
                        Repeater::make('highlights')
                            ->label('Project Highlights')
                            ->simple(TextInput::make('item')->required())
                            ->default([])
                            ->addActionLabel('Add item'),
                    ]),

                TextInput::make('sort_order')
                    ->label('Display Order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
