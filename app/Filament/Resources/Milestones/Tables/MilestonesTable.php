<?php

namespace App\Filament\Resources\Milestones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MilestonesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('year')
            ->reorderable('sort_order')
            ->striped()
            ->columns([
                TextColumn::make('year_label')
                    ->label('Year'),
                TextColumn::make('name')
                    ->label('Title')
                    ->weight('semibold')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('badge')
                    ->label('Badge')
                    ->badge()
                    ->color('info'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No milestones yet')
            ->emptyStateDescription('Add a milestone to build the company timeline.')
            ->emptyStateIcon(Heroicon::OutlinedFlag);
    }
}
