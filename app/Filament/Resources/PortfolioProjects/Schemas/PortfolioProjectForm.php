<?php

namespace App\Filament\Resources\PortfolioProjects\Schemas;

use App\Filament\Forms\Components\IconPicker;
use App\Support\HexColor;
use App\Support\ServiceIconOptions;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

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
                            ->integer()
                            ->minValue(1900)
                            ->maxValue(fn (): int => (int) now()->year)
                            ->required(),
                        TextInput::make('scale')
                            ->label('Scale (1-5)')
                            ->integer()
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
                        IconPicker::make('icon')
                            ->label('Icon')
                            ->options(ServiceIconOptions::options())
                            ->required()
                            ->rule(Rule::in(array_keys(ServiceIconOptions::options()))),
                        FileUpload::make('image')
                            ->label('Project Image')
                            ->helperText('Optional. Shown on the project card and detail view instead of the icon overlay.')
                            ->image()
                            ->disk('public')
                            ->directory('portfolio-projects')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                Section::make('Appearance')
                    ->columns(3)
                    ->components([
                        ColorPicker::make('color')->label('Primary Color')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('bg_light')->label('Background Color')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('accent_text')->label('Accent Text Color')->regex(HexColor::REGEX)->required(),
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
                    ->integer()
                    ->minValue(0)
                    ->default(0),
            ]);
    }
}
