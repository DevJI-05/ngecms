<?php

namespace App\Filament\Resources\TeamMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Jabatan'),
                TextColumn::make('level')
                    ->label('Level')
                    ->badge(),
                TextColumn::make('parent.name')
                    ->label('Atasan Langsung')
                    ->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('level')
                    ->options([
                        'komisaris' => 'Komisaris',
                        'direksi' => 'Direksi Utama',
                        'manajer' => 'Direktur / Manajer',
                        'staff' => 'Kepala Departemen / Staff',
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
