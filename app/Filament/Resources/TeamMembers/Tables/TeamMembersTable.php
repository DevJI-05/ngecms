<?php

namespace App\Filament\Resources\TeamMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeamMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->weight('semibold')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Job Title')
                    ->searchable(),
                TextColumn::make('level')
                    ->label('Level')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'komisaris' => 'gray',
                        'direksi' => 'danger',
                        'manajer' => 'warning',
                        default => 'info',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'komisaris' => 'Commissioner',
                        'direksi' => 'Board of Directors',
                        'manajer' => 'Director / Manager',
                        default => 'Department Head / Staff',
                    }),
                TextColumn::make('parent.name')
                    ->label('Reports To')
                    ->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('level')
                    ->label('Level')
                    ->options([
                        'komisaris' => 'Commissioner',
                        'direksi' => 'Board of Directors',
                        'manajer' => 'Director / Manager',
                        'staff' => 'Department Head / Staff',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No team members yet')
            ->emptyStateDescription('Add a team member to build the organization structure.')
            ->emptyStateIcon(Heroicon::OutlinedUserGroup);
    }
}
