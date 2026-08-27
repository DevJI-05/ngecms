<?php

namespace App\Filament\Resources\CompanyValues\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompanyValuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->columns([
                TextColumn::make('icon')
                    ->label('Icon')
                    ->size('lg'),
                TextColumn::make('name')
                    ->label('Value Name')
                    ->weight('semibold')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->toggleable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No company values yet')
            ->emptyStateDescription('Add a value to showcase what the company stands for.')
            ->emptyStateIcon(Heroicon::OutlinedHeart);
    }
}
