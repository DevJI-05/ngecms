<?php

namespace App\Filament\Resources\PortfolioProjects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PortfolioProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Proyek')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('cat')
                    ->label('Kategori')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => $state === 'done' ? 'success' : 'warning'),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Lokasi'),
                TextColumn::make('client')
                    ->label('Klien'),
                ColorColumn::make('color')
                    ->label('Warna'),
            ])
            ->filters([
                SelectFilter::make('cat')
                    ->label('Kategori')
                    ->options([
                        'pipeline' => 'Gas Pipeline',
                        'cng' => 'CNG',
                        'maintenance' => 'Maintenance',
                        'engineering' => 'Engineering',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'done' => 'Selesai',
                        'ongoing' => 'Berlangsung',
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
