<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->searchable(),
                TextColumn::make('cat')
                    ->label('Kategori')
                    ->badge(),
                TextColumn::make('tagline')
                    ->limit(50),
                TextColumn::make('foot_note')
                    ->label('Catatan Kaki'),
            ])
            ->filters([
                SelectFilter::make('cat')
                    ->label('Kategori')
                    ->options([
                        'pipeline' => 'Gas Pipeline',
                        'cng' => 'CNG',
                        'maintenance' => 'Maintenance',
                        'engineering' => 'Engineering',
                        'safety' => 'Safety & HSE',
                    ]),
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
