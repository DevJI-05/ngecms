<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use App\Models\TeamMember;
use App\Rules\NotCircularTeamHierarchy;
use App\Support\HexColor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Member Details')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        TextInput::make('role')
                            ->label('Job Title')
                            ->required(),
                        Select::make('level')
                            ->label('Level')
                            ->options([
                                'komisaris' => 'Commissioner',
                                'direksi' => 'Board of Directors',
                                'manajer' => 'Director / Manager',
                                'staff' => 'Department Head / Staff',
                            ])
                            ->native(false)
                            ->required(),
                        Select::make('parent_id')
                            ->label('Reports To')
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query, ?TeamMember $record) => $record
                                    ? $query->whereNotIn('id', [$record->id, ...TeamMember::descendantIds($record->id)])
                                    : $query,
                            )
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->rules(fn (?TeamMember $record) => [new NotCircularTeamHierarchy($record?->id)]),
                        TextInput::make('initials')
                            ->label('Avatar Initials')
                            ->maxLength(3)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->integer()
                            ->minValue(0)
                            ->default(0),
                    ]),

                Section::make('Avatar Appearance')
                    ->columns(2)
                    ->components([
                        ColorPicker::make('avatar_bg')->label('Background Color')->regex(HexColor::REGEX)->required(),
                        ColorPicker::make('avatar_color')->label('Text Color')->regex(HexColor::REGEX)->required(),
                    ]),
            ]);
    }
}
