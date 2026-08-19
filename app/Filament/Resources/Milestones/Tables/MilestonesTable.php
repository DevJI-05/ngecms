<?php

namespace App\Filament\Resources\Milestones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MilestonesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('year')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('year_label')
                    ->label('Tahun'),
                TextColumn::make('name')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('badge')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
