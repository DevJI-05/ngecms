<?php

namespace App\Filament\Resources\Milestones\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MilestoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Milestone Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('year_label')
                            ->label('Year Label')
                            ->helperText('Example: 2008 — Founded')
                            ->required(),
                        TextInput::make('year')
                            ->label('Year (for ordering)')
                            ->numeric()
                            ->required(),
                        TextInput::make('name')
                            ->label('Title')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('badge')
                            ->label('Badge Label')
                            ->helperText('Example: Milestone, Certification, CNG, Award')
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->integer()
                            ->minValue(0)
                            ->default(0),
                    ]),

                Section::make('Timeline Appearance')
                    ->columns(3)
                    ->components([
                        ColorPicker::make('dot_color')->label('Timeline Dot Color')->required(),
                        ColorPicker::make('badge_bg')->label('Badge Background')->required(),
                        ColorPicker::make('badge_color')->label('Badge Text Color')->required(),
                    ]),
            ]);
    }
}
